<?php

namespace App\Notifications;

use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TrialLicenseExpPre extends BaseNotification
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
            ->subject(__('email.trialLicenseExpPre.subject') . ' - ' . $siteName . '!')
            ->greeting(__('email.trialLicenseExpPre.greeting', ['name' => $notifiable->name]))
            ->line(__('email.trialLicenseExpPre.line1', ['date' => \Carbon\Carbon::parse($this->restaurant->trial_ends_at)->format('d F, Y')]))
            ->line(__('email.trialLicenseExpPre.line2'))
            ->action(__('email.trialLicenseExpPre.action'), route('dashboard'))
            ->line(__('email.trialLicenseExpPre.line3'));
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
