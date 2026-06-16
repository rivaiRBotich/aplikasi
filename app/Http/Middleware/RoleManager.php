<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $authUserRole = Auth::user()->role;

        // Jika role user tidak sesuai dengan role yang diwajibkan oleh route
        if ($authUserRole !== $role) {
            // Overide redirection berdasarkan role aslinya
            switch ($authUserRole) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'doctor':
                    return redirect()->route('doctor.dashboard');
                case 'user':
                    return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}