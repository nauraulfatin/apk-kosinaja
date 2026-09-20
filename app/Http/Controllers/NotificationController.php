<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * Menampilkan semua notifikasi user
     */
    public function index()
    {

        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);


        return view(
            'notifications.index',
            compact('notifications')
        );

    }




    /**
     * Membaca satu notifikasi
     */
    public function read($id)
    {

        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();



        $notification->markAsRead();



        return redirect(
            $notification->data['url'] ?? '/'
        );

    }





    /**
     * Membaca semua notifikasi
     */
    public function markAllRead()
    {

        auth()->user()
            ->unreadNotifications
            ->markAsRead();



        return back();

    }

}