<?php

namespace App\Exports;

use App\Models\User;
use App\Scopes\BranchScope;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StaffExport implements WithMapping, FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            'User',
            'Email',
            'Role',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->email,
            $customer->getRoleNames()[0]
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle
            ->getFont()
            ->setName('Arial');
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'name' => 'Arial'], 'fill'  => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => array('rgb' => 'f5f5f5'),
            ]],
        ];
    }

    public function collection()
    {
        return User::withoutGlobalScope(BranchScope::class)
            ->where(function($q) {
                return $q->where('branch_id', branch()->id)
                    ->orWhereNull('branch_id');
            })->get();
    }

}
