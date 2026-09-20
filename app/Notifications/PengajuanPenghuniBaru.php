<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PengajuanPenghuniBaru extends Notification
{
    use Queueable;


    public function __construct(
        public $namaPenghuni
    ) {}


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pengajuan Penghuni Baru',
            'message' => $this->namaPenghuni . 
                ' mengajukan bergabung dengan kos Anda.',
            'url' => route('admin.pengajuan.index')
        ];
    }
}