<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 9/04/19
 * Time: 19:11
 */

namespace App\Http\Controllers\Api\Notifications;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\HelloNotificationStore;
use App\Notifications\HelloNotification;

class HelloNotificationsController extends Controller
{
    /**
     * Index.
     *
     * @param HelloNotificationStore $request
     * @return mixed
     */
    public function store(HelloNotificationStore $request)
    {
        $request->user()->notify(new HelloNotification);
        return response()->json('Notification sent.', 201);
    }
}
