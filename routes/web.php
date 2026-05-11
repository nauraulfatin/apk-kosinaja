<?php

use App\Http\Controllers\AdminKostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\HargaKamarController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PeriodePenagihanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin-kost', [AdminKostController::class, 'create'])->name('admin-kost.register');
Route::post('/register-admin-kost', [AdminKostController::class, 'store'])->name('admin-kost.register.store');

Route::middleware('auth')->group(function () {

    Route::get(
        '/ganti-password-awal',
        [AuthController::class, 'showForceChangePassword']
    )->name('password.force');

    Route::post(
        '/ganti-password-awal',
        [AuthController::class, 'forceChangePassword']
    )->name('password.force.store');

});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'force.password',
    'role:super admin'
])
->prefix('super-admin')
->name('superadmin.')
->group(function () {

    Route::get(
        '/dashboard',
        [SuperAdminController::class, 'dashboard']
    )->name('dashboard');

    Route::post(
        '/admin-kost/{user}/validasi',
        [SuperAdminController::class, 'validasiAdmin']
    )->name('admin.validasi');

    Route::post(
        '/admin-kost/{user}/tolak',
        [SuperAdminController::class, 'tolakAdmin']
    )->name('admin.tolak');

    Route::resource(
        '/fasilitas',
        FasilitasController::class
    )->except(['show']);

    /*
|--------------------------------------------------------------------------
| PENGAJUAN ADMIN KOST
|--------------------------------------------------------------------------
*/

Route::get(
    '/pengajuan',
    [SuperAdminController::class, 'pengajuan']
)->name('pengajuan.index');

Route::get(
    '/pengajuan/{user}',
    [SuperAdminController::class, 'detailPengajuan']
)->name('admin.detail');

/*
|--------------------------------------------------------------------------
| RIWAYAT PENGAJUAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/riwayat',
    [SuperAdminController::class, 'riwayat']
)->name('riwayat.index');

Route::get(
    '/riwayat/{user}/edit',
    [SuperAdminController::class, 'editRiwayat']
)->name('riwayat.edit');

Route::delete(
    '/admin-kost/{user}/hapus',
    [SuperAdminController::class, 'hapusAdmin']
)->name('admin.hapus');

});

/*
|--------------------------------------------------------------------------
| ADMIN KOST
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'force.password',
    'role:admin kost'
])
->prefix('admin')
->name('admin.')
->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [AdminKostController::class, 'dashboard']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | INFORMASI KOST
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/kost/edit',
        [AdminKostController::class, 'editKost']
    )->name('kost.edit');

    Route::put(
        '/kost',
        [AdminKostController::class, 'updateKost']
    )->name('kost.update');

    /*
    |--------------------------------------------------------------------------
    | KAMAR
    |--------------------------------------------------------------------------
    */

    Route::resource(
        '/kamar',
        KamarController::class
    )->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | FASILITAS KAMAR
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/kamar/{kamar}/fasilitas',
        [KamarController::class, 'editFasilitas']
    )->name('kamar.fasilitas.edit');

    Route::put(
        '/kamar/{kamar}/fasilitas',
        [KamarController::class, 'updateFasilitas']
    )->name('kamar.fasilitas.update');

    /*
    |--------------------------------------------------------------------------
    | PERIODE PENAGIHAN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        '/periode',
        PeriodePenagihanController::class
    )->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | HARGA KAMAR
    |--------------------------------------------------------------------------
    */

    Route::resource(
        '/kamar/{kamar}/harga',
        HargaKamarController::class
    )
    ->except(['show'])
    ->names('kamar.harga');

    /*
    |--------------------------------------------------------------------------
    | PENGHUNI
    |--------------------------------------------------------------------------
    */

    Route::resource(
        '/penghuni',
        PenghuniController::class
    )->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | TAGIHAN & PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/tagihan',
        [TagihanController::class, 'adminIndex']
    )->name('tagihan.index');

    Route::post(
        '/tagihan/{tagihan}/validasi',
        [TagihanController::class, 'validasiBukti']
    )->name('tagihan.validasi');

    Route::post(
        '/tagihan/{tagihan}/tolak',
        [TagihanController::class, 'tolakBukti']
    )->name('tagihan.tolak');

});

/*
|--------------------------------------------------------------------------
| PENGHUNI KOST
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'force.password',
    'role:penghuni kost'
])
->prefix('penghuni')
->name('penghuni.')
->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [PenghuniController::class, 'dashboard']
    )->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | TAGIHAN & PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/tagihan',
        [TagihanController::class, 'penghuniIndex']
    )->name('tagihan.index');

    Route::post(
        '/tagihan/{tagihan}/upload-bukti',
        [TagihanController::class, 'uploadBukti']
    )->name('tagihan.upload');

});