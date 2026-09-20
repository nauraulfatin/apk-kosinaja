<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranMasuk extends Notification
{
    use Queueable;

    public function __construct(
        public string $namaPenghuni
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pembayaran Baru',
            'message' => $this->namaPenghuni .
                ' mengirim bukti pembayaran dan menunggu verifikasi.',
            'url' => route('admin.tagihan.index')
        ];
    }
}