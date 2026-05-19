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
use App\Http\Controllers\AturanKosController;
use App\Http\Controllers\PengajuanSewaController;

/*
|--------------------------------------------------------------------------
| TAMBAHAN CONTROLLER ADUAN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AduanAdminController;
use App\Http\Controllers\Penghuni\AduanPenghuniController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman statis
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/hubungi', [HomeController::class, 'hubungi'])->name('hubungi');

// Katalog
Route::get('/katalog', [HomeController::class, 'katalog'])->name('katalog');

// Detail
Route::get('/katalog/{id}', [HomeController::class, 'detailKost'])->name('detailKost');
Route::get('/kamar/{id}', [HomeController::class, 'detailKamar'])->name('detailKamar');

//Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-admin-kost', [AdminKostController::class, 'create'])->name('admin-kost.register');
Route::post('/register-admin-kost', [AdminKostController::class, 'store'])->name('admin-kost.register.store');


Route::get('/register/penghuni', [PenghuniController::class, 'create'])->name('register.penghuni');
   Route::post('/register/penghuni', [PenghuniController::class, 'store'])->name('register.penghuni.store');
   Route::get('/register/admin', [AuthController::class, 'showRegisterAdmin'])->name('register.admin');
   Route::post('/register/admin', [AuthController::class, 'registerAdmin'])->name('register.admin.store');

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
    '/kost',
    [AdminKostController::class, 'index']
)->name('kost.index');

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

    Route::get(
    '/tagihan/{user}/detail',
    [TagihanController::class, 'detail']
)->name('tagihan.detail');

    Route::post(
        '/tagihan/{tagihan}/validasi',
        [TagihanController::class, 'validasiBukti']
    )->name('tagihan.validasi');

    Route::post(
        '/tagihan/{tagihan}/tolak',
        [TagihanController::class, 'tolakBukti']
    )->name('tagihan.tolak');

    /*
    |--------------------------------------------------------------------------
    | ATURAN KOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        '/aturan',
        AturanKosController::class
    )->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | ADUAN KOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/aduan',
        [AduanAdminController::class, 'index']
    )->name('aduan.index');

    Route::get(
        '/aduan/{id}',
        [AduanAdminController::class, 'show']
    )->name('aduan.show');

    Route::put(
        '/aduan/{id}',
        [AduanAdminController::class, 'update']
    )->name('aduan.update');

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
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pembayaran',
        [TagihanController::class, 'penghuniIndex']
    )->name('pembayaran.index');

    Route::get(
        '/pembayaran/create',
        [TagihanController::class, 'createPembayaran']
    )->name('pembayaran.create');

    Route::post(
        '/pembayaran',
        [TagihanController::class, 'storePembayaran']
    )->name('pembayaran.store');

    

    /*
    |--------------------------------------------------------------------------
    | ATURAN
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/aturan',
        'penghuni.aturan.index'
    )->name('aturan.index');

    /*
    |--------------------------------------------------------------------------
    | ADUAN
    |--------------------------------------------------------------------------
    */

    Route::view(
        '/aduan',
        'penghuni.aduan.index'
    )->name('aduan.index');

    /*
    |--------------------------------------------------------------------------
    | PROFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profil',
        [PenghuniController::class, 'profil']
    )->name('profil.index');

    Route::get(
        '/profil/edit',
        [PenghuniController::class, 'editProfil']
    )->name('profil.edit');

    Route::put(
        '/profil',
        [PenghuniController::class, 'updateProfil']
    )->name('profil.update');

    /*
    |--------------------------------------------------------------------------
    | ATURAN KOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/aturan',
        [AturanKosController::class, 'penghuniIndex']
    )->name('aturan.index');

    /*
    |--------------------------------------------------------------------------
    | ADUAN KOS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/aduan',
        [AduanPenghuniController::class, 'index']
    )->name('aduan.index');

    Route::get(
        '/aduan/create',
        [AduanPenghuniController::class, 'create']
    )->name('aduan.create');

    Route::post(
        '/aduan',
        [AduanPenghuniController::class, 'store']
    )->name('aduan.store');

    
});