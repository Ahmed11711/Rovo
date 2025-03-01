<?php

namespace App\Observers;

use App\Models\NotificationSetting;

class NotificationSettingObserver
{

    public function creating(NotificationSetting $notificationSetting)
    {
        if (restaurant()) {
            $notificationSetting->restaurant_id = restaurant()->id;
        }
    }

}
