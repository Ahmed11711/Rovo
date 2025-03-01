<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class CustomerEmailVerify extends BaseNotification
{

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
        $build = parent::build($notifiable);
        return $build
            ->subject(config('app.name') . ' ' . __('email.emailVerification.subject'))
            ->greeting(__('app.hello') . ' ' . $notifiable->name . '!')
            ->line(__('email.emailVerification.text1'))
            ->line($notifiable->email_otp);
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
