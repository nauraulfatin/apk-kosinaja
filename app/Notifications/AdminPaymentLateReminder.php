<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminPaymentLateReminder extends Notification
{
    use Queueable;


    public function __construct(
        public $jumlahTelat,
        public $tagihans = []
    ) {}



    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | IDENTITAS REMINDER
            |--------------------------------------------------------------------------
            |
            | Digunakan untuk mencegah notif admin terkirim berulang
            |
            */

            'jenis_reminder' =>
                'admin_telat',


            'tanggal' =>
                now()->format('Y-m-d'),



            /*
            |--------------------------------------------------------------------------
            | ISI NOTIFIKASI
            |--------------------------------------------------------------------------
            */

            'title' =>
                'Tagihan Belum Dibayar',



            'message' =>
                'Terdapat ' .
                $this->jumlahTelat .
                ' penghuni yang belum melakukan pembayaran.',



            'jumlah_telat' =>
                $this->jumlahTelat,



            'url' =>
                route('admin.tagihan.index'),

        ];
    }
}