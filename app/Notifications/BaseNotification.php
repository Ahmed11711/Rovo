<?php

namespace App\Notifications;

use App\Models\EmailSetting;
use App\Models\GlobalSetting;
use App\Models\Restaurant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class BaseNotification extends Notification implements ShouldQueue
{

    use Queueable, Dispatchable;


    protected $restaurant = null;
    public function build(object $notifiable = null)
    {
        // Set the company and global settings

        $restaurant = $this->restaurant;

        $globalSetting = GlobalSetting::first();

        $locale = $notifiable->locale ?? 'en';

        // Set the application locale based on the company's locale or global settings
        if (isset($locale)) {
            App::setLocale($locale ?? (!is_null($restaurant) ? $restaurant->locale : 'en'));
        } else {
            App::setLocale(session('locale') ?: $globalSetting->locale);
        }

        // Retrieve SMTP settings
        $smtpSetting = EmailSetting::first();

        // Initialize a mail message instance
        $build = (new MailMessage);

        // Set default reply name and email to SMTP settings
        $replyName = $companyName = $smtpSetting->mail_from_name;
        $replyEmail = $smtpFromEmail = $smtpSetting->mail_from_email;

        // Set the application logo URL from the global settings
        Config::set('app.logo', $globalSetting->logoUrl);
        Config::set('app.name', $companyName);

        // If a restaurant is specified, customize the reply name, email, logo URL, and application name
        if (!is_null($restaurant)) {
            $replyName = $restaurant->name;
            $replyEmail = $restaurant->email;
            Config::set('app.logo', $restaurant->logo_url);
            Config::set('app.name', $replyName);
        }

        // Ensure that the restaurant email and name are used if mail verification is successful
        // $restaurantEmail = config('mail.verified') === true ? $restaurantEmail : $replyEmail;


        // Return the mail message with configured from and replyTo settings
        return $build->from($smtpFromEmail, $replyName)->replyTo($replyEmail, $replyName);
    }
}
