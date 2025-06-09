<?php

namespace App\Exports;

use App\Models\Technician;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TechniciansExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Technician::select(
            'id',
            'first_name',
            'last_name',
            'email',
            'specialization',
            'active',
            'hourly_rate',
            'certification_expiry'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Specialization',
            'Active',
            'Hourly Rate (USD)',
            'Certification Expiry',
        ];
    }
}

