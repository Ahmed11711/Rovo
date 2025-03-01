<?php

namespace App\Notifications;

use App\Models\NotificationSetting;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffWelcomeEmail extends BaseNotification
{

    public $restaurant;
    public $password;
    public $notificationSetting;

    /**
     * Create a new notification instance.
     */
    public function __construct(Restaurant $restaurant, $password)
    {
        $this->restaurant = $restaurant;
        $this->password = $password;
        $this->notificationSetting = NotificationSetting::where('type', 'staff_welcome')->where('restaurant_id', $this->restaurant->id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($this->notificationSetting->send_email == 1 && $notifiable->email != '') {
            return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $build = parent::build($notifiable);

        return $build
            ->subject(__('email.staffWelcome.subject') . $this->restaurant->name . '!')
            ->greeting(__('app.hello') . ' ' . $notifiable->name . ',')
            ->line(__('email.staffWelcome.text1'))
            ->line(__('email.staffWelcome.text2') . $notifiable->email)
            ->line(__('email.staffWelcome.text3') . $this->password)
            ->action(__('email.staffWelcome.action'), route('login'));
    }

}
