<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        abort_if(!$request->user() || $request->user()->role !== $role, 403);
        abort_if($role === 'admin kost' && $request->user()->status !== 'aktif', 403, 'Akun admin kost belum divalidasi super admin.');
        return $next($request);
    }
}
