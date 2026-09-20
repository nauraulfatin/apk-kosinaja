<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Notifications\PaymentReminder;
use App\Notifications\PaymentLateReminder;
use App\Notifications\AdminPaymentReminder;
use App\Notifications\AdminPaymentLateReminder;
use Carbon\Carbon;

class CheckPaymentReminder extends Command
{
    protected $signature = 'app:check-payment-reminder';


    protected $description =
        'Mengirim pengingat pembayaran tagihan';



    public function handle()
    {

        $today = Carbon::today();



        /*
        |--------------------------------------------------------------------------
        | REMINDER PENGHUNI SEBELUM JATUH TEMPO
        |
        | H-3
        | H-1
        | H
        |--------------------------------------------------------------------------
        */


        $tagihans = Tagihan::with([
                'user',
                'kamar.kost.user'
            ])
            ->where('status', 'pending')
            ->whereIn(
                'tanggal_jatuh_tempo',
                [
                    $today->copy()->addDays(3),
                    $today->copy()->addDays(1),
                    $today,
                ]
            )
            ->get();



        foreach ($tagihans as $tagihan) {


            if (!$tagihan->user) {
                continue;
            }



            $selisih = $today->diffInDays(
                Carbon::parse(
                    $tagihan->tanggal_jatuh_tempo
                ),
                false
            );



            $jenisReminder = match ($selisih) {

                3 =>
                    'Pengingat Pembayaran',

                1 =>
                    'Besok Jatuh Tempo',

                0 =>
                    'Jatuh Tempo Hari Ini',

                default =>
                    'Pengingat Pembayaran'
            };



            $sudahAda = $tagihan->user
                ->notifications()
                ->where(
                    'type',
                    PaymentReminder::class
                )
                ->whereJsonContains(
                    'data->tagihan_id',
                    $tagihan->id_tagihan
                )
                ->whereJsonContains(
                    'data->jenis_reminder',
                    $jenisReminder
                )
                ->whereDate(
                    'created_at',
                    today()
                )
                ->exists();



            if (!$sudahAda) {

                $tagihan->user->notify(
                    new PaymentReminder(
                        $tagihan,
                        $jenisReminder
                    )
                );

            }

        }




        /*
        |--------------------------------------------------------------------------
        | REMINDER PENGHUNI TELAT BAYAR
        |
        | H+1
        | H+3
        | H+6
        |--------------------------------------------------------------------------
        */


        $tagihanTelat = Tagihan::with([
                'user'
            ])
            ->where('status', 'telat')
            ->get();



        foreach ($tagihanTelat as $tagihan) {


            if (!$tagihan->user) {
                continue;
            }



            $hariTelat = Carbon::parse(
                    $tagihan->tanggal_jatuh_tempo
                )
                ->startOfDay()
                ->diffInDays($today);



            if (
                $hariTelat == 1 ||
                (
                    $hariTelat >= 3 &&
                    $hariTelat % 3 == 0
                )
            ) {


                $sudahAda = $tagihan->user
                    ->notifications()
                    ->where(
                        'type',
                        PaymentLateReminder::class
                    )
                    ->whereJsonContains(
                        'data->tagihan_id',
                        $tagihan->id_tagihan
                    )
                    ->whereJsonContains(
                        'data->jenis_reminder',
                        'terlambat'
                    )
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->exists();



                if (!$sudahAda) {

                    $tagihan->user->notify(
                        new PaymentLateReminder(
                            $tagihan
                        )
                    );

                }

            }

        }




        /*
        |--------------------------------------------------------------------------
        | REMINDER ADMIN SEBELUM JATUH TEMPO
        |--------------------------------------------------------------------------
        */


        $adminList = $tagihans
            ->groupBy(
                fn($tagihan) =>
                optional(
                    $tagihan->kamar->kost
                )->id_user
            );



        foreach ($adminList as $adminTagihan) {


            $admin =
                $adminTagihan
                    ->first()
                    ?->kamar
                    ?->kost
                    ?->user;



            if (!$admin) {
                continue;
            }



            $sudahAda = $admin
                ->notifications()
                ->where(
                    'type',
                    AdminPaymentReminder::class
                )
                ->whereJsonContains(
                    'data->jenis_reminder',
                    'admin_jatuh_tempo'
                )
                ->whereJsonContains(
                    'data->tanggal',
                    today()->format('Y-m-d')
                )
                ->exists();



            if (!$sudahAda) {

                $admin->notify(
                    new AdminPaymentReminder(
                        $adminTagihan->count()
                    )
                );

            }

        }




        /*
        |--------------------------------------------------------------------------
        | REMINDER ADMIN UNTUK TAGIHAN TELAT
        |--------------------------------------------------------------------------
        */


        $adminTelat = Tagihan::with([
                'kamar.kost.user'
            ])
            ->where('status', 'telat')
            ->get()
            ->groupBy(
                fn($tagihan) =>
                optional(
                    $tagihan->kamar->kost
                )->id_user
            );



        foreach ($adminTelat as $tagihanAdmin) {


            $admin =
                $tagihanAdmin
                    ->first()
                    ?->kamar
                    ?->kost
                    ?->user;



            if (!$admin) {
                continue;
            }



            $hariTelat = Carbon::parse(
                    $tagihanAdmin
                        ->first()
                        ->tanggal_jatuh_tempo
                )
                ->startOfDay()
                ->diffInDays($today);



            if (
                $hariTelat == 1 ||
                (
                    $hariTelat >= 3 &&
                    $hariTelat % 3 == 0
                )
            ) {


                $sudahAda = $admin
                    ->notifications()
                    ->where(
                        'type',
                        AdminPaymentLateReminder::class
                    )
                    ->whereJsonContains(
                        'data->jenis_reminder',
                        'admin_telat'
                    )
                    ->whereJsonContains(
                        'data->tanggal',
                        today()->format('Y-m-d')
                    )
                    ->exists();



                if (!$sudahAda) {

                    $admin->notify(
                        new AdminPaymentLateReminder(
                            $tagihanAdmin->count(),
                            $tagihanAdmin
                        )
                    );

                }

            }

        }



        $this->info(
            'Payment reminder selesai dikirim.'
        );

    }
}