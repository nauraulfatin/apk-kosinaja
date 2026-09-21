<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminKostDisetujui extends Notification
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
                'admin_kost_disetujui',
            'title' =>
                'Registrasi Admin Kost Disetujui',
            'message' =>
                'Selamat, akun Admin Kost kamu telah disetujui. Silakan login ke KosinAja.',
            'admin_id' =>
                $this->admin->id,
            'url' =>
                route('login'),

        ];
    }
}