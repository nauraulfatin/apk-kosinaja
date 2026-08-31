<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\KostDeletionService;

class SuperAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        return view('superadmin.dashboard', [

            'pendingAdmins' => User::with('kost')
                ->where('role', 'admin kost')
                ->where('status', 'pending')
                ->latest()
                ->get(),

            'admins' => User::with('kost')
                ->where('role', 'admin kost')
                ->latest()
                ->get(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI ADMIN
    |--------------------------------------------------------------------------
    */

    public function validasiAdmin(User $user)
    {
        abort_if(
            $user->role !== 'admin kost',
            404
        );

        $user->update([
            'status' => 'aktif'
        ]);

        return redirect()
            ->route('superadmin.pengajuan.index')
            ->with(
                'success',
                'Admin kost berhasil divalidasi.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | TOLAK ADMIN
    |--------------------------------------------------------------------------
    */

    public function tolakAdmin(User $user)
    {
        abort_if(
            $user->role !== 'admin kost',
            404
        );

        $user->update([
            'status' => 'ditolak'
        ]);

        return redirect()
            ->route('superadmin.pengajuan.index')
            ->with(
                'success',
                'Pengajuan admin kost ditolak.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | PENGAJUAN ADMIN KOST
    |--------------------------------------------------------------------------
    */

    public function pengajuan()
    {
        $items = User::with('kost')
            ->where('role', 'admin kost')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view(
            'superadmin.pengajuan.index',
            compact('items')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function detailPengajuan(User $user)
    {
        abort_if(
            $user->role !== 'admin kost',
            404
        );

        $user->load('kost');

        return view(
            'superadmin.pengajuan.detail',
            compact('user')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PENGAJUAN
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $items = User::with('kost')
            ->where('role', 'admin kost')
            ->whereIn('status', [
                'aktif',
                'ditolak'
            ])
            ->latest()
            ->get();

        return view(
            'superadmin.riwayat.index',
            compact('items')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT RIWAYAT
    |--------------------------------------------------------------------------
    */

    public function editRiwayat(User $user)
    {
        abort_if(
            $user->role !== 'admin kost',
            404
        );

        $user->load('kost');

        return view(
            'superadmin.riwayat.edit',
            compact('user')
        );
    }

    /*
|--------------------------------------------------------------------------
| HAPUS ADMIN KOST
|--------------------------------------------------------------------------
*/

public function hapusAdmin(User $user, KostDeletionService $kostDeletionService)
{
    abort_if($user->role !== 'admin kost', 404);

    $user->load('kost');

    if ($user->kost) {
        $kostDeletionService->delete($user->kost);
    }

    $user->delete();

    return redirect()
        ->route('superadmin.riwayat.index')
        ->with(
            'success',
            'Admin kost dan seluruh data kos terkait berhasil dihapus.'
        );
}

public function profil()
{
    $user = auth()->user();
    return view('profil.superadmin', compact('user'));
}

}