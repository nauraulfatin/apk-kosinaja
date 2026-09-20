<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDitolak extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pembayaran Ditolak',
            'message' => 'Pembayaran kamu ditolak. Silakan cek kembali bukti pembayaran.',
            'url' => route('penghuni.pembayaran.index')
        ];
    }
}