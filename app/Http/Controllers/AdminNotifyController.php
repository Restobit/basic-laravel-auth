<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminNotifyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {

        $admins = User::whereHas('roles', function ($query) {
            $query->where(['role_id' => 1]);
            return $query;
        })->get();

        try {
            Notification::send($admins, new UserRegisteredNotification());
        }
        catch(\Exception $e){
            return($e);
        }
        return $admins;
    }
}
