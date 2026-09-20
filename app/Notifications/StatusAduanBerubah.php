<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusAduanBerubah extends Notification
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
                'status_aduan_berubah',

            'title' =>
                'Status Aduan Diperbarui',

            'message' =>
                'Aduan kamu sekarang berstatus ' .
                $this->aduan->status .
                '.',

            'aduan_id' =>
                $this->aduan->id_aduan,

            'url' =>
                route('penghuni.aduan.index'),

        ];
    }
}