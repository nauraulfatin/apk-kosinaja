<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AduanBaru extends Notification
{
    use Queueable;


    public function __construct(
        public $aduan
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
                'aduan_baru',


            'title' =>
                'Aduan Baru',


            'message' =>
                'Penghuni ' .
                $this->aduan->user->nama .
                ' mengirim aduan baru.',


            'aduan_id' =>
                $this->aduan->id_aduan,


            'url' =>
                route('admin.aduan.index'),

        ];
    }
}