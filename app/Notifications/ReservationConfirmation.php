<?php

namespace App\Notifications;

use App\Models\NotificationSetting;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationConfirmation extends BaseNotification
{

    protected $reservation;
    protected $settings;
    protected $notificationSetting;

    public function __construct(Reservation $reservation)
    {

        $this->reservation = $reservation;
        $this->settings = $reservation->branch ? $reservation->branch->restaurant : null;
        $this->notificationSetting = NotificationSetting::where('type', 'reservation_confirmed')->where('restaurant_id', $reservation->branch->restaurant_id)->first();
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
            ->subject(__('email.reservation.reservationConfirmation', ['site_name' => $this->reservation->branch->restaurant->name]))
            ->markdown('emails.table-reservation', [
                'notifiable' => $notifiable,
                'reservation' => $this->reservation,
                'settings' => $this->settings,
            ]);
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
