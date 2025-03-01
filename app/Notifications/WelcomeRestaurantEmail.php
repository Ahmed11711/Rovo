<?php

namespace App\Notifications;

use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeRestaurantEmail extends BaseNotification
{

    public $restaurant;

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
        $build = parent::build($notifiable);

        $siteName = global_setting()->name;
        return $build
            ->subject('Welcome to ' . $siteName . '! Let\'s Start Simplifying Your Restaurant Operations! 🍽️')
            ->greeting(__('app.hello') . ' ' . $notifiable->name . ',')
            ->line('Congratulations and welcome to ' . $siteName . '! We\'re thrilled to have your restaurant join our platform.')
            ->line('What\'s next?')
            ->line('Set Up Your Menu: Add your menu items, categories, and pricing with ease')
            ->line('Manage Orders: Start accepting orders via QR codes or POS and track everything in real time.')
            ->line('Optimize Your Workflow: Assign roles to your staff, monitor reservations, and manage your kitchen orders efficiently.')
            ->line('Let\'s make restaurant management smoother than ever!');
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
