<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification
{
    use Queueable;


    public function __construct(
        public $tagihan,
        public $jenisReminder
    ) {}



    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [

            'tagihan_id' => $this->tagihan->id_tagihan,
            'jenis_reminder' => $this->jenisReminder,      
            'title' => $this->jenisReminder,
            'message' =>
                match ($this->jenisReminder) {

                    'Pengingat Pembayaran' =>
                        'Tagihan kos kamu akan jatuh tempo pada ' .
                        $this->tagihan->tanggal_jatuh_tempo
                            ->format('d F Y') .
                        '. Silakan lakukan pembayaran.',


                    'Besok Jatuh Tempo' =>
                        'Tagihan kos kamu akan jatuh tempo besok. Segera lakukan pembayaran.',


                    'Jatuh Tempo Hari Ini' =>
                        'Tagihan kos kamu jatuh tempo hari ini. Silakan lakukan pembayaran.',


                    default =>
                        'Terdapat pengingat pembayaran kos kamu.'
                },


            'url' =>
                route('penghuni.pembayaran.index'),

        ];
    }
}