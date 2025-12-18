<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller {

    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('date')
            ->get();

        return view('pages.notifications', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();

        $user->notifications()->updateExistingPivot(
            $notificationId,
            ['seen' => true]
        );

        return back();
    }

    public function markAllAsRead()
    {
        $user = Auth::user();

        $notifications = $user->notifications()->wherePivot('seen', false)->get();

        foreach ($notifications as $notification) {
            $user->notifications()->updateExistingPivot($notification->id, ['seen' => true]);
        }

        return back();
    }



    public function destroy($notificationId)
    {
        $user = Auth::user();

        $user->notifications()->detach($notificationId);

        return back()->with('success', 'Notification removed.');
    }

}
