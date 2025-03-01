<?php

namespace App\Livewire\Billing;

use Livewire\Component;
use App\Models\GlobalInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class InvoiceTable extends Component
{
    use WithPagination;
    public $search;
    public $restaurantId;

    public function downloadReceipt($id)
    {
        $invoice = GlobalInvoice::findOrFail($id);

        if (!$invoice) {

            $this->alert('error', __('messages.noInvoiceFound'), [
                'toast' => true,
                'position' => 'top-end',
                'showCancelButton' => false,
                'cancelButtonText' => __('app.close')
            ]);

            return;
        }


        $pdf = Pdf::loadView('billing.billing-receipt', ['invoice' => $invoice]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'billing-receipt-' . uniqid() . '.pdf');
    }

    public function render()
    {
        $query = GlobalInvoice::query()
            ->with(['restaurant', 'package'])
            ->orderByDesc('id');

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('restaurant', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('package', function ($q) {
                    $q->where('package_type', 'like', '%' . $this->search . '%');
                })
                ->orWhere('gateway_name', 'like', '%' . $this->search . '%')
                ->orWhere('total', 'like', '%' . $this->search . '%')
                ->orWhere('transaction_id', 'like', '%' . $this->search . '%')
                ->orWhere('package_type', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->restaurantId) {
            $query->where('restaurant_id', $this->restaurantId);
        }

        $invoices = $query->paginate(10);

        return view('livewire.billing.invoice-table', [
            'invoices' => $invoices
        ]);
    }
}
