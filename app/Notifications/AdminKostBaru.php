<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminKostBaru extends Notification
{
    use Queueable;


    public function __construct(
        public $admin
    ) {}



    public function via($notifiable)
    {
        return [
            'database'
        ];
    }



    public function toDatabase($notifiable)
    {
        return [

            'jenis_notifikasi' => 
                'admin_kost_baru',


            'title' =>
                'Admin Kost Baru',


            'message' =>
                'Admin kost ' .
                $this->admin->nama .
                ' melakukan pendaftaran dan menunggu persetujuan.',


            'admin_id' =>
                $this->admin->id,


            'url' =>
                route('superadmin.dashboard'),

        ];
    }
}