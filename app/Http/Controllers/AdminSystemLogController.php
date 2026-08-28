<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use SplFileObject;

class AdminSystemLogController extends Controller
{
    private const ALLOWED_LEVELS = ['info', 'warning', 'error'];

    public function index(Request $request)
    {
        $validated = $request->validate([
            'file' => ['nullable', 'string'],
            'level' => ['nullable', 'in:info,warning,error'],
            'search' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
            'per_page' => ['nullable', 'integer', 'in:25,50,100'],
        ]);

        $files = $this->availableLogFiles();
        $selectedFile = $validated['file'] ?? ($files[0]['name'] ?? null);

        if ($selectedFile !== null && !collect($files)->contains('name', $selectedFile)) {
            abort(404);
        }

        $entries = $selectedFile
            ? $this->readLogFile(storage_path('logs/' . $selectedFile), $validated)
            : collect();

        $levelCounts = [
            'info' => $entries->where('level_group', 'info')->count(),
            'warning' => $entries->where('level_group', 'warning')->count(),
            'error' => $entries->where('level_group', 'error')->count(),
        ];

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = (int) ($validated['per_page'] ?? 50);
        $logs = new LengthAwarePaginator(
            $entries->forPage($page, $perPage)->values(),
            $entries->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin_system_logs.index', compact(
            'logs',
            'files',
            'selectedFile',
            'levelCounts'
        ));
    }

    public function clear(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'string'],
        ]);

        $files = $this->availableLogFiles();
        $selectedFile = $validated['file'];

        if (!collect($files)->contains('name', $selectedFile)) {
            abort(404);
        }

        $path = storage_path('logs/' . $selectedFile);

        if (!is_file($path) || !is_writable($path)) {
            return redirect()
                ->route('sitemanagement.systemLogs.index', ['file' => $selectedFile])
                ->with('error', 'تعذر مسح ملف اللوج. تأكد من صلاحيات الكتابة على الملف.');
        }

        if (file_put_contents($path, '', LOCK_EX) === false) {
            return redirect()
                ->route('sitemanagement.systemLogs.index', ['file' => $selectedFile])
                ->with('error', 'حدث خطأ أثناء مسح ملف اللوج.');
        }

        clearstatcache(true, $path);

        return redirect()
            ->route('sitemanagement.systemLogs.index', ['file' => $selectedFile])
            ->with('success', 'تم مسح السجلات القديمة من ملف ' . $selectedFile . ' بنجاح.');
    }

    private function availableLogFiles(): array
    {
        $paths = glob(storage_path('logs/*.log')) ?: [];

        usort($paths, static function (string $first, string $second): int {
            return filemtime($second) <=> filemtime($first);
        });

        return array_map(static function (string $path): array {
            return [
                'name' => basename($path),
                'size' => filesize($path) ?: 0,
                'modified_at' => date('Y-m-d H:i:s', filemtime($path)),
            ];
        }, $paths);
    }

    private function readLogFile(string $path, array $filters): Collection
    {
        if (!is_file($path) || !is_readable($path)) {
            return collect();
        }

        $entries = collect();
        $current = null;
        $file = new SplFileObject($path, 'r');

        while (!$file->eof()) {
            $line = rtrim((string) $file->fgets(), "\r\n");

            if (preg_match(
                '/^\[(?<datetime>\d{4}-\d{2}-\d{2}[ T][^\]]+)\]\s+(?<environment>[^.]+)\.(?<level>[A-Z]+):\s*(?<message>.*)$/',
                $line,
                $matches
            )) {
                $this->appendEntry($entries, $current, $filters);

                $level = strtolower($matches['level']);
                $current = [
                    'datetime' => $matches['datetime'],
                    'environment' => $matches['environment'],
                    'level' => $level,
                    'level_group' => $this->levelGroup($level),
                    'message' => $matches['message'],
                ];

                continue;
            }

            if ($current !== null && $line !== '') {
                $current['message'] .= "\n" . $line;
            }
        }

        $this->appendEntry($entries, $current, $filters);

        return $entries->reverse()->values();
    }

    private function appendEntry(Collection $entries, ?array $entry, array $filters): void
    {
        if ($entry === null || !in_array($entry['level_group'], self::ALLOWED_LEVELS, true)) {
            return;
        }

        if (!empty($filters['level']) && $entry['level_group'] !== $filters['level']) {
            return;
        }

        $entryDate = substr($entry['datetime'], 0, 10);

        if (!empty($filters['date_from']) && $entryDate < $filters['date_from']) {
            return;
        }

        if (!empty($filters['date_to']) && $entryDate > $filters['date_to']) {
            return;
        }

        if (!empty($filters['search'])) {
            $haystack = $entry['environment'] . ' ' . $entry['level'] . ' ' . $entry['message'];

            if (mb_stripos($haystack, $filters['search']) === false) {
                return;
            }
        }

        $entries->push($entry);
    }

    private function levelGroup(string $level): ?string
    {
        if ($level === 'info' || $level === 'notice') {
            return 'info';
        }

        if ($level === 'warning') {
            return 'warning';
        }

        if (in_array($level, ['error', 'critical', 'alert', 'emergency'], true)) {
            return 'error';
        }

        return null;
    }
}
