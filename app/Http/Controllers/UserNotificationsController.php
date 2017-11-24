<?php

namespace App\Http\Controllers;


class UserNotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark a specific notification as read.
     *
     * @param \App\User $user
     * @param int   $notificationId
     */
    public function destroy($user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();

    }
}
