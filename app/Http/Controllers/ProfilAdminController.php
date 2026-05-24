<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfilAdminController extends Controller
{
    public function index()
    {
        $admin = Auth::user();

        $kost = $admin->kost;

        $view = view()->file(
            resource_path('views/profil/index.admin.blade.php'),
            compact('admin', 'kost')
        );

        return $view;
    }
}