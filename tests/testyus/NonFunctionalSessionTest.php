<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class NonFunctionalSessionTest extends TestCase
{
    use RefreshDatabase;

    // NF7-01: Session dikonfigurasi berakhir setelah 60 menit.
    public function test_nf7_01_session_memiliki_batas_waktu_60_menit(): void
    {
        $this->assertEquals(
            60,
            config('session.lifetime'),
            'Session seharusnya berakhir setelah 60 menit.'
        );
    }

    // NF7-02: Session dapat menyimpan dan membaca data sebelum kedaluwarsa.
    public function test_nf7_02_session_dapat_digunakan_sebelum_batas_waktu(): void
    {
        config(['session.lifetime' => 60]);

        Session::put('status_pengujian', 'aktif');

        $this->assertEquals(
            'aktif',
            Session::get('status_pengujian')
        );
    }
}