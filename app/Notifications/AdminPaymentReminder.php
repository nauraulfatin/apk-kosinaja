<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminPaymentReminder extends Notification
{
    use Queueable;


    public function __construct(
        public $jumlahTagihan
    ) {}



    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [

            'jenis_reminder' =>
                'admin_jatuh_tempo',

            'tanggal' =>
                now()->format('Y-m-d'),

            'title' =>
                'Tagihan Belum Dibayar',


            'message' =>
                'Terdapat ' .
                $this->jumlahTagihan .
                ' tagihan penghuni yang belum dibayar.',


            'url' =>
                route('admin.tagihan.index'),

        ];
    }
}