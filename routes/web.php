<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Doctor\DoctorDashboardController;

Route::get('/', [MainController::class, 'index']);

// ==========================================
// 1. ROUTE UNTUK USER / PASIEN (Biasa)
// ==========================================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::post('/user/topup/store', [UserDashboardController::class, 'storeTopup'])->name('user.topup.store');
    Route::get('/chat/initiate/{category}', [UserDashboardController::class, 'createRoom'])->name('chat.initiate');
});

// ==========================================
// 2. ROUTE UNTUK ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Menu Utama Sidebar
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminDashboardController::class, 'products'])->name('admin.products');
    Route::get('/admin/portfolios', [AdminDashboardController::class, 'portfolios'])->name('admin.portfolios');
    Route::get('/admin/topups', [AdminDashboardController::class, 'topups'])->name('admin.topups');
    Route::get('/admin/chats', [AdminDashboardController::class, 'activeChats'])->name('admin.chats');

    // Aksi Bisnis Admin
    Route::post('/admin/tariff/update', [AdminDashboardController::class, 'updateTariff'])->name('admin.tariff.update');
    Route::post('/admin/product/store', [AdminDashboardController::class, 'storeProduct'])->name('admin.product.store');
    Route::post('/admin/portfolio/store', [AdminDashboardController::class, 'storePortfolio'])->name('admin.portfolio.store');
    Route::get('/admin/topup/verify/{id}/{status}', [AdminDashboardController::class, 'verifyTopup'])->name('admin.topup.verify');
    Route::post('/admin/chat/refund/{id}', [AdminDashboardController::class, 'refundChat'])->name('admin.chat.refund');
    Route::delete('/admin/product/delete/{id}', [AdminDashboardController::class, 'destroyProduct'])->name('admin.product.delete');
    Route::delete('/admin/portfolio/delete/{id}', [AdminDashboardController::class, 'destroyPortfolio'])->name('admin.portfolio.delete');
    Route::get('/admin/doctors', [AdminDashboardController::class, 'doctors'])->name('admin.doctors');
    Route::post('/admin/doctor/store', [AdminDashboardController::class, 'storeDoctor'])->name('admin.doctor.store');
    Route::get('/admin/users', [AdminDashboardController::class, 'users'])->name('admin.users');
    Route::post('/admin/user/reset-password/{id}', [AdminDashboardController::class, 'resetPassword'])->name('admin.user.reset_password');
    Route::delete('/admin/doctor/delete/{id}', [AdminDashboardController::class, 'destroyDoctor'])->name('admin.doctor.delete');
    Route::get('/admin/doctors/activities', [AdminDashboardController::class, 'doctorActivities'])->name('admin.doctors.activities');
    Route::get('/admin/doctors/activities', [AdminDashboardController::class, 'doctorActivities'])->name('admin.doctors.activities');
    Route::post('/admin/commission/pay/{id}', [AdminDashboardController::class, 'payCommission'])->name('admin.commission.pay');
    Route::post('/admin/doctors/activities/generate', [AdminDashboardController::class, 'generateCommissions'])->name('admin.commission.generate');
});
// ==========================================
// 3. ROUTE UNTUK DOKTER
// ==========================================
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('doctor.dashboard'); // Nanti kita buat file view-nya
    })->name('doctor.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/chat/room/{id}', [ChatController::class, 'showSpace'])->name('chat.room');
    Route::post('/chat/room/{id}/send', [ChatController::class, 'sendMessage'])->name('chat.message.send');
});

Route::middleware(['auth', 'verified'])->prefix('doctor')->name('doctor.')->group(function () {
    // Halaman Utama Dashboard Dokter
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    
    // Aksi Dokter saat menyetujui/mengambil alih ruang chat pasien
    Route::post('/chat/room/{id}/accept', [DoctorDashboardController::class, 'acceptRoom'])->name('chat.accept');
    Route::post('/chat/room/{id}/end', [DoctorDashboardController::class, 'endChat'])->name('chat.end');
});

Route::post('/doctor/heartbeat', function () {
    if (auth()->check() && auth()->user()->role === 'doctor') {
        DB::table('users')->where('id', auth()->id())->update([
            'is_online'    => 1,
            'last_seen_at' => now(),
        ]);
    }
    return response()->json(['ok' => true]);
})->middleware('auth')->name('doctor.heartbeat');

Route::post('/doctor/offline', function (Request $request) {
    if (auth()->check() && auth()->user()->role === 'doctor') {
        DB::table('users')->where('id', auth()->id())->update([
            'is_online'    => 0,
            'last_seen_at' => now(),
        ]);
    }
    return response()->json(['ok' => true]);
})->middleware('auth')->name('doctor.offline');


require __DIR__.'/auth.php';