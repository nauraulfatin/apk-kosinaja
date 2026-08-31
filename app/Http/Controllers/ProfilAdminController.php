<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Kost;

class ProfilAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PROFIL ADMIN KOST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user()->load('kost');

        return view(
            'profil.admin',
            compact(
                'user'
            )
        );
    }


}