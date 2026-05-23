<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class LastUsersExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldAutoSize
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = User::query();

        // ترتيب
        if (isset($this->filters['sortBy']) && $this->filters['sortBy'] == 1) {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        // بحث نصي
        if (!empty($this->filters['search_key'])) {
            $key = $this->filters['search_key'];
            $query->where(function ($q) use ($key) {
                $q->where('name', 'like', '%' . $key . '%')
                  ->orWhere('MOP', 'like', '%' . $key . '%')
                  ->orWhere('invited_by', 'like', '%' . $key . '%');
            });
        }

        // فلتر الحالة
        if (isset($this->filters['filter_status']) && $this->filters['filter_status'] !== '') {
            $query->where('status', $this->filters['filter_status']);
        }

        if (!empty($this->filters['filter_user_id'])) {
            $query->where('id', (int) $this->filters['filter_user_id']);
        }

        if (!empty($this->filters['filter_invited_by'])) {
            $query->where('invited_by', $this->filters['filter_invited_by']);
        }

        if (isset($this->filters['has_aqars']) && $this->filters['has_aqars'] !== '') {
            if ((int) $this->filters['has_aqars'] === 1) {
                $query->whereHas('aqars', function ($q) {
                    $q->whereNull('deleted_at');
                });
            } else {
                $query->whereDoesntHave('aqars', function ($q) {
                    $q->whereNull('deleted_at');
                });
            }
        }

        if (isset($this->filters['has_package']) && $this->filters['has_package'] !== '') {
            if ((int) $this->filters['has_package'] === 1) {
                $query->whereHas('UserPriceing');
            } else {
                $query->whereDoesntHave('UserPriceing');
            }
        }

        if (($this->filters['type_tab'] ?? null) === 'companies') {
            $query->where('TYPE', 4);
        } elseif (($this->filters['type_tab'] ?? null) === 'developer') {
            $query->where('TYPE', 3);
        } elseif (($this->filters['type_tab'] ?? null) === 'normal') {
            $query->whereIn('TYPE', [1, 2]);
        } elseif (!empty($this->filters['filter_type'])) {
            $query->where('TYPE', $this->filters['filter_type']);
        }

        return $query->limit(3000);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Email',
            'Phone',
            'Status',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->email,
            $row->MOP ?? $row->phone ?? '',
            $row->status == 1 ? 'active' : 'inactive',
            $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '',
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
