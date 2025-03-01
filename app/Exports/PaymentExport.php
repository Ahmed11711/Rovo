<?php

namespace App\Exports;

use App\Models\Payment;
use App\Models\Payments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport implements WithMapping, FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            'Amount',
            'Method',
            'Transaction ID',
            'Date and Time',
            'Order #',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->amount,
            $payment->payment_method,
            $payment->transaction_id,
            $payment->created_at->timezone(timezone())->format('d M Y, h:i A'),
            $payment->order_id,
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
        return Payment::orderBy('id', 'desc')->get();
    }

}
