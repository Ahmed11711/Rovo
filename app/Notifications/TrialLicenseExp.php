<?php

namespace App\Notifications;

use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrialLicenseExp extends BaseNotification
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
            ->subject(__('email.trialLicenseExp.subject') . ' - ' . $siteName . '!')
            ->greeting(__('email.trialLicenseExp.greeting', ['name' => $notifiable->name]))
            ->line(__('email.trialLicenseExp.line1'))
            ->line(__('email.trialLicenseExp.line2'))
            ->action(__('email.trialLicenseExp.action'), route('dashboard'));
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
