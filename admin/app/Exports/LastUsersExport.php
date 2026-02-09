<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class LastUsersExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        return User::query()
            ->orderByDesc('id')
            ->limit(1000);
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
