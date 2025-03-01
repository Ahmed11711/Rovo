<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NotifyWaiter;
use App\Events\WaiterNotification;

class NotifyWaiterListener
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
    public function handle(NotifyWaiter $event)
    {
        // Logic to send notification to waiter via POS, app, etc.
        // Example: Using broadcasting
        broadcast(new WaiterNotification($event->tableNumber));
    }
}
