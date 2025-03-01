<?php

namespace App\Notifications;

use App\Models\Package;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class RestaurantUpdatedPlan extends BaseNotification
{
    use Queueable;
    private $package;
    private $forRestaurant;
    /**
     * Create a new notification instance.
     */
    public function __construct(Restaurant $restaurant, $packageID)
    {
        $this->forRestaurant = $restaurant;
        $this->package = Package::findOrFail($packageID);
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
            ->subject(__('email.restaurantUpdatedPlan.subject') . ' - ' . $siteName . '!')
            ->greeting(__('email.restaurantUpdatedPlan.greeting', ['name' => $notifiable->name]))
            ->line(__('email.restaurantUpdatedPlan.line1'))
            ->line(__('email.restaurantUpdatedPlan.line2'))
            ->line(__('modules.restaurant.name') . ': ' . $this->forRestaurant->name)
            ->line(__('modules.package.packageName') . ': ' . $this->package->package_name)
            ->line(__('email.restaurantUpdatedPlan.line4'))
            ->action(__('email.restaurantUpdatedPlan.action'), route('dashboard'));

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
