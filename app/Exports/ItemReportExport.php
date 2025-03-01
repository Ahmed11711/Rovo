<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\MenuItem;
use App\Scopes\AvailableMenuItemScope;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemReportExport implements WithMapping, FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
            [__('menu.itemReport') . ' ' . $this->startDate .' - ' . $this->endDate],
            [
            'Item Name',
            'Quantity',
            'Amount',
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $item->item_name,
            $item->orders->sum('quantity'),
            $item->orders->sum('amount')
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
        return MenuItem::withoutGlobalScope(AvailableMenuItemScope::class)->with(['orders' => function ($q) {
            return $q->whereDate('created_at', '>=', $this->startDate)->whereDate('created_at', '<=', $this->endDate);
        }])->get();
    }

}
