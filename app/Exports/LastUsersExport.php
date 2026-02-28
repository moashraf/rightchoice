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

        // فلتر النوع
        if (!empty($this->filters['filter_type'])) {
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

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->MOP ?? $user->phone ?? '',
            $user->status == 1 ? 'active' : 'inactive',
            $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
