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
use App\Http\Controllers\Admin\PengajuanPenghuniController;
use App\Http\Controllers\ProfilPenghuniController;
use App\Http\Controllers\PengajuanSewaController;
use App\Http\Controllers\Admin\AduanAdminController;
use App\Http\Controllers\Penghuni\AduanPenghuniController;
use App\Http\Controllers\ProfilAdminController;
use App\Http\Controllers\ContactController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| BERANDA
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tentang', [
    HomeController::class,
    'tentang'
])->name('tentang');

Route::get('/hubungi', [
    HomeController::class,
    'hubungi'
])->name('hubungi');

// EMAIL
Route::post('/hubungi', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| KATALOG
|--------------------------------------------------------------------------
*/

Route::get('/katalog', [
    HomeController::class,
    'katalog'
])->name('katalog');

Route::get('/katalog/{id}', [
    HomeController::class,
    'detailKost'
])->name('detailKost');

Route::get('/kamar/{id}', [
    HomeController::class,
    'detailKamar'
])->name('detailKamar');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.post');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/register-admin-kost', [
    AdminKostController::class,
    'create'
])->name('admin-kost.register');

Route::post('/register-admin-kost', [
    AdminKostController::class,
    'store'
])->name('admin-kost.register.store');

Route::get('/register/penghuni', [
    AuthController::class,
    'showRegisterPenghuni'
])->name('register.penghuni');

Route::post('/register/penghuni', [
    AuthController::class,
    'registerPenghuni'
])->name('register.penghuni.store');

Route::get('/register/admin', [
    AuthController::class,
    'showRegisterAdmin'
])->name('register.admin');

Route::post('/register/admin', [
    AuthController::class,
    'registerAdmin'
])->name('register.admin.store');

/*
|--------------------------------------------------------------------------
| FORCE PASSWORD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/ganti-password-awal', [
        AuthController::class,
        'showForceChangePassword'
    ])->name('password.force');

    Route::post('/ganti-password-awal', [
        AuthController::class,
        'forceChangePassword'
    ])->name('password.force.store');

    Route::post('/hubungkan-kode', [
        ProfilPenghuniController::class,
        'submitKode'
    ])->name('penghuni.hubungkan.kode');
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

    Route::get('/dashboard', [
        SuperAdminController::class,
        'dashboard'
    ])->name('dashboard');

    Route::post('/admin-kost/{user}/validasi', [
        SuperAdminController::class,
        'validasiAdmin'
    ])->name('admin.validasi');

    Route::post('/admin-kost/{user}/tolak', [
        SuperAdminController::class,
        'tolakAdmin'
    ])->name('admin.tolak');

    Route::delete('/admin-kost/{user}/hapus', [
        SuperAdminController::class,
        'hapusAdmin'
    ])->name('admin.hapus');

    Route::resource('/fasilitas', FasilitasController::class)
        ->except(['show']);

    Route::get('/pengajuan', [
        SuperAdminController::class,
        'pengajuan'
    ])->name('pengajuan.index');

    Route::get('/pengajuan/{user}', [
        SuperAdminController::class,
        'detailPengajuan'
    ])->name('admin.detail');

    Route::get('/riwayat', [
        SuperAdminController::class,
        'riwayat'
    ])->name('riwayat.index');

    Route::get('/riwayat/{user}/edit', [
        SuperAdminController::class,
        'editRiwayat'
    ])->name('riwayat.edit');

    Route::get('/profil', [SuperAdminController::class, 'profil'])
    ->name('profil');
    
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

    Route::get('/dashboard', [
        AdminKostController::class,
        'dashboard'
    ])->name('dashboard');

    Route::get('/kost', [
        AdminKostController::class,
        'index'
    ])->name('kost.index');

    Route::get('/kost/edit', [
        AdminKostController::class,
        'editKost'
    ])->name('kost.edit');

    Route::put('/kost', [
        AdminKostController::class,
        'updateKost'
    ])->name('kost.update');

    Route::get('/pengajuan-penghuni', [
        PengajuanPenghuniController::class,
        'index'
    ])->name('pengajuan.index');

    Route::get('/pengajuan-penghuni/{riwayatHunian}', [
        PengajuanPenghuniController::class,
        'show'
    ])->name('pengajuan.show');

    Route::put('/pengajuan-penghuni/{riwayatHunian}/approve', [
        PengajuanPenghuniController::class,
        'approve'
    ])->name('pengajuan.approve');

    Route::resource('/kamar', KamarController::class)
        ->except(['show']);

    Route::get('/kamar/{kamar}/fasilitas', [
        KamarController::class,
        'editFasilitas'
    ])->name('kamar.fasilitas.edit');

    Route::put('/kamar/{kamar}/fasilitas', [
        KamarController::class,
        'updateFasilitas'
    ])->name('kamar.fasilitas.update');

    Route::resource('/periode', PeriodePenagihanController::class)
        ->except(['show']);

    Route::resource('/kamar/{kamar}/harga', HargaKamarController::class)
        ->except(['show'])
        ->names('kamar.harga');

    Route::resource('/penghuni', PenghuniController::class)
        ->except(['show']);

    Route::get('/penghuni/aktif', [
        PenghuniController::class, 'aktif'
    ])->name('penghuni.aktif');

    Route::get('/penghuni/antrian', [
        PenghuniController::class, 'antrian'
    ])->name('penghuni.antrian');

    Route::get('/penghuni/nonaktif', [
        PenghuniController::class, 'nonaktif'
    ])->name('penghuni.nonaktif');

    Route::put('/penghuni/{riwayatHunian}/nonaktifkan', [
        PenghuniController::class, 'nonaktifkan'
    ])->name('penghuni.nonaktifkan');

    Route::get('/penghuni/{riwayatHunian}/aktifkan', [
        PenghuniController::class, 'formAktifkan'
    ])->name('penghuni.formAktifkan');

    Route::put('/penghuni/{riwayatHunian}/aktifkan', [
        PenghuniController::class, 'aktifkan'
    ])->name('penghuni.aktifkan');

    Route::post('/kost/refresh-kode',
    [AdminKostController::class, 'refreshKode']
)->name('kost.refresh-kode');

    Route::get('/tagihan', [
        TagihanController::class,
        'adminIndex'
    ])->name('tagihan.index');

    Route::get('/tagihan/{user}/detail', [
        TagihanController::class,
        'detail'
    ])->name('tagihan.detail');

    Route::post('/tagihan/{pembayaran}/validasi', [
        TagihanController::class,
        'validasiBukti'
    ])->name('tagihan.validasi');

    Route::post('/tagihan/{pembayaran}/tolak', [
        TagihanController::class,
        'tolakBukti'
    ])->name('tagihan.tolak');

    Route::get('tagihan/riwayat', [
        TagihanController::class, 'riwayat'
    ])->name('tagihan.riwayat');

    Route::get('tagihan/export-pdf', [
        TagihanController::class, 'exportPdf'
    ])->name('tagihan.export-pdf');

    Route::resource('/aturan', AturanKosController::class)
        ->except(['show']);

    Route::get('/aduan', [
        AduanAdminController::class,
        'index'
    ])->name('aduan.index');

    Route::get('/aduan/{id}', [
        AduanAdminController::class,
        'show'
    ])->name('aduan.show');

    Route::put('/aduan/{id}', [
        AduanAdminController::class,
        'update'
    ])->name('aduan.update');

    Route::get('/profil', [ProfilAdminController::class, 'index'])->name('profil.index');
});

Route::middleware(['auth', 'force.password'])
    ->group(function () {
        Route::get('/admin/profil', [ProfilAdminController::class, 'index'])
            ->name('admin.profil.index');
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

    Route::get('/dashboard', [
        PenghuniController::class,
        'dashboard'
    ])->name('dashboard');

    Route::get('/pembayaran', [
        TagihanController::class,
        'penghuniIndex'
    ])->name('pembayaran.index');

    Route::get('/pembayaran/create', [
        TagihanController::class,
        'createPembayaran'
    ])->name('pembayaran.create');

    Route::post('/pembayaran', [
        TagihanController::class,
        'storePembayaran'
    ])->name('pembayaran.store');

    Route::get('/riwayat-pembayaran', [
        TagihanController::class, 'riwayatPembayaran'
    ])->name('riwayat-pembayaran');

    Route::get('/aturan', [
        AturanKosController::class,
        'penghuniIndex'
    ])->name('aturan.index');

    Route::get('/aduan', [
        AduanPenghuniController::class,
        'index'
    ])->name('aduan.index');

    Route::get('/aduan/create', [
        AduanPenghuniController::class,
        'create'
    ])->name('aduan.create');

    Route::post('/aduan', [
        AduanPenghuniController::class,
        'store'
    ])->name('aduan.store');

    Route::get('/profil', function () {
        return view('profil.index');
    })->name('penghuni.profil.index');

    Route::get('/profil/edit', function () {
        return view('profil.index');
    })->name('profil.edit');

    Route::put('/profil', [
        PenghuniController::class,
        'updateProfil'
    ])->name('profil.update');

    Route::post('/pengajuan-sewa', [
        PengajuanPenghuniController::class,
        'store'
    ])->name('pengajuan.store');

    Route::post('/penghuni/hubungkan', [
        PenghuniController::class,
        'hubungkan'
    ])->name('penghuni.hubungkan');

});

/*
|--------------------------------------------------------------------------
| PROFIL (GLOBAL - agar kompatibel dengan route('profil.index'))
|--------------------------------------------------------------------------
*/

Route::get('/profil', function () {

    $riwayat = \App\Models\RiwayatHunian::with('kamar.kost')
        ->where('id_user', auth()->id())
        ->latest()
        ->first();

    $riwayatList = \App\Models\RiwayatHunian::with(['kamar.kost.user'])
        ->where('id_user', auth()->id())
        ->where('status', 'nonaktif')
        ->latest()
        ->get();

    return view('profil.index', compact('riwayat', 'riwayatList'));

})->name('profil.index');