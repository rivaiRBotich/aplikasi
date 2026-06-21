<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Events\UserOnlineStatusChanged;

class AuthenticatedSessionController extends Controller
{
    // /**
    //  * Display the login view.
    //  */
    public function create(): View
    {
        return view('auth.login');
    }

    // /**
    //  * Handle an incoming authentication request.
    //  */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // $request->authenticate();

    //     // $request->session()->regenerate();

    //     // return redirect()->intended(route('dashboard', absolute: false));
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     // --- MODIFIKASI BAGIAN REDIRECT INI ---
    //     $user = $request->user();
        
    //     if ($user->role === 'admin') {
    //         return redirect()->intended(route('admin.dashboard', absolute: false));
    //     } elseif ($user->role === 'doctor') {
    //         return redirect()->intended(route('doctor.dashboard', absolute: false));
    //     }

    //     return redirect()->intended(route('dashboard', absolute: false));
    // }

    // /**
    //  * Destroy an authenticated session.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::guard('web')->logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();
    //     $request->session()->regenerate();

    //     $user = $request->user();

    //     // ✅ Set online saat login
    //     if ($user->role === 'doctor') {
    //         $user->update(['is_online' => true, 'last_seen_at' => now()]);
    //     }

    //     if ($user->role === 'admin') {
    //         return redirect()->intended(route('admin.dashboard'));
    //     } elseif ($user->role === 'doctor') {
    //         return redirect()->intended(route('doctor.dashboard'));
    //     }

    //     return redirect()->intended(route('dashboard'));
    // }

    // public function destroy(Request $request): RedirectResponse
    // {
    //     $user = Auth::user();

    //     // ✅ Set offline saat logout
    //     if ($user && $user->role === 'doctor') {
    //         $user->update(['is_online' => false, 'last_seen_at' => now()]);
    //     }

    //     Auth::guard('web')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/');
    // }
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        if ($user->role === 'doctor') {
            // ✅ Ganti ke DB::table
            DB::table('users')->where('id', $user->id)->update([
                'is_online'    => 1,
                'last_seen_at' => now(),
            ]);
            broadcast(new UserOnlineStatusChanged($user->fresh(), true));
        }

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'doctor') {
            return redirect()->intended(route('doctor.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user && $user->role === 'doctor') {
            // ✅ Ganti ke DB::table
            DB::table('users')->where('id', $user->id)->update([
                'is_online'    => 0,
                'last_seen_at' => now(),
            ]);
            broadcast(new UserOnlineStatusChanged($user->fresh(), false));
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
