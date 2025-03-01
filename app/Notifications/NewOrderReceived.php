<?php

namespace App\Notifications;

use App\Models\NotificationSetting;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderReceived extends BaseNotification
{
    
    protected $order;
    protected $settings;
    protected $notificationSetting;

    /**
     * Create a new notification instance.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->settings = $order->branch->restaurant;
        $this->notificationSetting = NotificationSetting::where('type', 'order_received')->where('restaurant_id', $order->branch->restaurant_id)->first();
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
        $build = parent::build($notifiable);
        return $build
            ->subject(__('email.newOrder.subject'). ' #'.$this->order->order_number)
            ->greeting(__('app.hello') .' '. $notifiable->name . ',')
            ->line(__('email.newOrder.text1'). __('modules.order.orderNumber') . '#'.$this->order->order_number)
            ->line(__('email.newOrder.text2'))
            ->line(__('modules.customer.name').': ' . ($this->order->customer ? $this->order->customer->name : '--'))
            ->line(__('email.newOrder.text3') . $this->formatOrderItems($this->order->items))
            ->line(__('modules.order.amount').': ' . currency_format($this->order->total, $this->settings->currency_id))
            ->line(__('app.time').': ' . $this->order->date_time->format('h:i A'))
            ->action(__('email.newOrder.action'), route('orders.index'))
            ->line(__('email.newOrder.text4'));
    }

    /**
     * Format order items for the email.
     *
     * @param $items
     * @return string
     */
    protected function formatOrderItems($items)
    {
        return $items->map(function ($item) {
            return $item->quantity . ' x ' . $item->menuItem->item_name;
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
            'total_price' => $this->order->total
        ];
    }
}
