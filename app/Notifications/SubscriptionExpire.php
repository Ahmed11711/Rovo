<?php

namespace App\Notifications;

use App\Models\Restaurant;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpire extends BaseNotification
{
    use Queueable;

    protected $restaurant;
    /**
     * Create a new notification instance.
     */
    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $siteName = global_setting()->name;
        $build = parent::build($notifiable);

        return $build
            ->subject(__('email.subscriptionExpire.subject') . ' - ' . $siteName . '!')
            ->greeting(__('email.subscriptionExpire.greeting', ['name' => $notifiable->name]))
            ->line(__('email.subscriptionExpire.line1'))
            ->line(__('email.subscriptionExpire.line2'))
            ->action(__('email.subscriptionExpire.action'), route('dashboard'))
            ->line(__('email.subscriptionExpire.line3'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
