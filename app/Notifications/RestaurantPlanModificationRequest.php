<?php

namespace App\Notifications;

use App\Models\Package;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class RestaurantPlanModificationRequest extends BaseNotification
{
    use Queueable;

    private $planChange;
    private $forRestaurant;
    private $packageName;

    /**
     * Create a new notification instance.
     */
    public function __construct(Restaurant $restaurant, $offlinePlanChangeRequest)
    {
        $this->forRestaurant = $restaurant;
        $this->planChange = $offlinePlanChangeRequest;
        $this->packageName = optional($this->planChange->package)->package_name ?? 'N/A';
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
            ->subject(__('email.offlineRequestReview.subject', ['site_name' => $siteName]))
            ->greeting(__('email.offlineRequestReview.greeting', ['name' => $notifiable->name]))
            ->line(__('email.offlineRequestReview.line1'))
            ->line(__('email.offlineRequestReview.line2', ['restaurant_name' => $this->forRestaurant->name]))
            ->line(__('email.offlineRequestReview.line3', ['package_name' => $this->packageName]))
            ->line(__('email.offlineRequestReview.line4', ['package_type' => $this->planChange->package_type]))
            ->line(__('email.offlineRequestReview.line5'))
            ->line(__('email.offlineRequestReview.line6'));
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
