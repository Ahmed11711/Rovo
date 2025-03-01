<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('SMTP Test Email')
            ->greeting('Hello!')
            ->line('This is a test email to verify your SMTP settings.')
            ->line('If you received this email, your SMTP settings are configured correctly.')
            ->line('Thank you for using our application!');
    }
}
