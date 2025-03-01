<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements WithMapping, FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->startDate = Carbon::createFromFormat('m/d/Y', $this->startDate)->toDateString();
        $this->endDate = Carbon::createFromFormat('m/d/Y', $this->endDate)->toDateString();
    }
 
    public function headings(): array
    {
        return [
            [__('menu.salesReport') . ' ' . $this->startDate .' - ' . $this->endDate],
            [
            'Date',
            'Quantity',
            'Amount',
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $item->date,
            $item->total_orders,
            $item->total_amount
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

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereDate('orders.date_time', '>=', $this->startDate)->whereDate('orders.date_time', '<=', $this->endDate)
            ->select(
            DB::raw('DATE(orders.created_at) as date'),
            DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
            DB::raw('SUM(order_items.amount) as total_amount')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->where('orders.status', 'paid')
            ->get();
    }

}
