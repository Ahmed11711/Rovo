<?php

namespace App\Notifications;

use App\Models\NotificationSetting;
use App\Models\Order;

class SendOrderBill extends BaseNotification
{

    protected $order;
    protected $settings;
    protected $notificationSetting;

    /**
     * Create a new notification instance.
     *
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->settings = $order->branch->restaurant;
        $this->notificationSetting = NotificationSetting::where('type', 'order_bill_sent')->where('restaurant_id', $order->branch->restaurant_id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($this->notificationSetting->send_email == 1 && $notifiable->email != '') {
            return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Calculate tax amounts
        $taxesWithAmount = [];

        foreach ($this->order->taxes as $tax) {
            $taxAmount = $this->order->sub_total * ($tax->tax->tax_percent / 100);
            $taxesWithAmount[] = [
                'name' => $tax->tax->tax_name,
                'amount' => $taxAmount,
                'rate' => $tax->tax->tax_percent,
            ];
        }

        $chargesWithAmount = [];

        foreach ($this->order->charges as $charge) {
            
            $chargeAmount = $charge->charge->charge_type == 'percent' ? ($charge->charge->charge_value / 100) * $this->order->sub_total : $charge->charge->charge_value;
            $chargesWithAmount[] = [
                'name' => $charge->charge->charge_name,
                'amount' => $chargeAmount,
                'rate' => $charge->charge->charge_value,
                'type' => $charge->charge->charge_type,
            ];
        }

        $build = parent::build($notifiable);
        return $build
            ->subject(__('email.sendOrderBill.subject', ['order_number' => $this->order->order_number, 'site_name' => $this->settings->name]))
            ->markdown('emails.order-bill', [
                        'order' => $this->order,
                        'subtotal' => $this->order->sub_total,
                        'taxesWithAmount' => $taxesWithAmount,
                        'chargesWithAmount' => $chargesWithAmount,
                        'totalPrice' => $this->order->total,
                        'items' => $this->order->items,
                        'settings' => $this->settings,
                    ]);
    }

    /**
     * Format order items for the email body.
     *
     * @param $items
     * @return string
     */
    protected function formatOrderSummary($items)
    {
        return $items->map(function ($item) {
            return $item->quantity . ' x ' . $item->name . ' @ ' . currency_format($item->price, $this->settings->currency_id);
        })->implode(', ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->order->customer->name,
            'table_id' => $this->order->table_id,
            'total_price' => $this->order->total_price,
        ];
    }

}
