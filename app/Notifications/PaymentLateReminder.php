<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentLateReminder extends Notification
{
    use Queueable;


    public function __construct(
        public $tagihan
    ) {}



    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [

                'tagihan_id' => $this->tagihan->id_tagihan,
                'jenis_reminder' =>'terlambat',
            'title' => 'Pembayaran Terlambat',

            'message' =>
                'Tagihan kos kamu sudah melewati jatuh tempo. ' .
                'Silakan segera lakukan pembayaran.',

            'url' =>
                route('penghuni.pembayaran.index'),

        ];
    }
}