<?php

namespace App\Listeners;

use App\Events\ReservationReceived;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Notifications\NewReservationForRestaurant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendReservationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationReceived $event): void
    {
        $users = User::role('Admin_'.$event->reservation->branch->restaurant_id)->where('restaurant_id', $event->reservation->branch->restaurant->id)->get();

        Notification::send($users, new NewReservationForRestaurant($event->reservation));

        $pushNotification = new DashboardController();
        $pushUsersIds = [$users->pluck('id')->toArray()];
        $pushNotification->sendPushNotifications($pushUsersIds, __('email.reservation.subject'), $event->reservation->reservation_date_time->format('d M, h:i A'), route('reservations.index'));

    }
}
