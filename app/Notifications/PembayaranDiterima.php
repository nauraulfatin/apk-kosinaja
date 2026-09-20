<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiterima extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pembayaran Diterima',
            'message' => 'Pembayaran kamu telah diverifikasi oleh admin kos.',
            'url' => route('penghuni.pembayaran.index')
        ];
    }
}