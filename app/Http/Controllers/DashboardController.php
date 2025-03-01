<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{

    public function index()
    {
        if (user()->hasRole('Super Admin')) {
            return redirect(RouteServiceProvider::SUPERADMIN_HOME);
        }

        return view('dashboard.index');
    }

    public function superadmin()
    {
        return view('dashboard.superadmin');
    }

    public function beamAuth()
    {
        $userID = 'tbltrk-'.auth()->id();
        $userIDInQueryParam = request()->user_id;

        if ($userID != $userIDInQueryParam) {
            return response('Inconsistent request', 401);

        } else {
            $beamsClient = new \Pusher\PushNotifications\PushNotifications([
                'instanceId' => pusherSettings()->instance_id,
                'secretKey' => pusherSettings()->beam_secret,
            ]);

            $beamsToken = $beamsClient->generateToken($userID);
            return response()->json($beamsToken);
        }

    }


    public function sendPushNotifications($usersIDs, $title, $body, $link)
    {
        if (App::environment('codecanyon') && pusherSettings()->beamer_status && count($usersIDs) > 0) {
            $beamsClient = new \Pusher\PushNotifications\PushNotifications([
            'instanceId' =>  pusherSettings()->instance_id,
            'secretKey' =>  pusherSettings()->beam_secret,
            ]);


            $pushIDs = [];

            foreach ($usersIDs[0] as $key => $uid) {
                $pushIDs[] = 'tbltrk-' . $uid;
            }

            $publishResponse = $beamsClient->publishToUsers(
            $pushIDs,
            array(
              'web' => array(
                'notification' => array(
                  'title' => $title,
                  'body' => $body,
                  'deep_link' => $link,
                  'icon' => asset('apple-icon-180x180.png')
                  )
              )
            ));
        }
    }

    public function accountUnverified()
    {
        return view('dashboard.padding-approval');
    }

}
