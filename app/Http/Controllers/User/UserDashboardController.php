<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatRoom; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\TopupCreated;
use App\Models\AccountBank;

class UserDashboardController extends Controller
{
    // 1. Halaman Utama Pasien
    public function index()
    {   
        $bank = DB::table('acount_bank')->first();
        $user = Auth::user();

        // == FIX 1: Menggunakan whereIn agar status 'pending' ATAU 'active' terbaca sempurna ==
        $activeChat = DB::table('chat_rooms')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active']) 
            ->first();

        // 2. AMBIL RIWAYAT CHAT YANG SUDAH SELESAI (CLOSED)
        $chatHistory = \App\Models\ChatRoom::with('doctor')
            ->where('user_id', $user->id)
            ->where('status', 'closed')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Ambil data pendukung lainnya (topup, tarif, dll)
        $tariffs = DB::table('chat_tariffs')->get();
        $topups = DB::table('topups')->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();

        $doctors = User::where('role', 'doctor')
        ->select('id', 'name', 'clinic_category', 'is_online', 'last_seen_at')
        ->get();
        return view('dashboard', compact('user', 'activeChat', 'chatHistory', 'tariffs', 'topups','doctors','bank'));
    }

    // 2. Proses Pengajuan Top-up Saldo (Upload Bukti)
    public function storeTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ],[
            'amount.required'     => 'Nominal isi saldo wajib diisi.',
            'amount.numeric'      => 'Nominal isi saldo harus berupa angka.',
            'amount.min'          => 'Minimal pengisian saldo adalah Rp10.000.',
            'proof_image.required'=> 'Bukti transfer wajib diunggah.',
            'proof_image.image'   => 'File yang diunggah harus berupa file gambar.',
            'proof_image.mimes'   => 'Format gambar tidak cocok! Sistem hanya menerima format: jpeg, png, jpg, atau webp.',
            'proof_image.max'     => 'Ukuran gambar terlalu besar! Maksimal ukuran file adalah 2MB.',   
        ]);

        $imagePath = $request->file('proof_image')->store('proofs', 'public');

        // DB::table('topups')->insert([
        //     'user_id' => Auth::id(),
        //     'amount' => $request->amount,
        //     'proof_image' => $imagePath,
        //     'status' => 'pending',
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        $topupId = DB::table('topups')->insertGetId([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'proof_image' => $imagePath,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);
 
        // ✅ BARU — broadcast supaya dashboard & halaman topup admin update real-time
        broadcast(new TopupCreated(
            topupId: $topupId,
            userName: Auth::user()->name,
            amount: (int) $request->amount,
            proofImage: $imagePath,
            createdAt: now()->format('d M Y H:i'),
        ));

        return redirect()->back()->with('success', 'Permohonan top-up berhasil dikirim! Menunggu konfirmasi admin Klinik MBC.');
    }

    // 3. Fungsi Inisiasi Pembuatan Room Chat
    public function createRoom($category)
    {
        $user = Auth::user();

        // == SAFETY CHECK: Jika pasien ternyata sudah punya sesi pending/active yang menggantung,
        // langsung lempar balik ke dalam room agar saldo tidak terpotong dua kali! ==
        $existingChat = DB::table('chat_rooms')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active'])
            ->first();

        if ($existingChat) {
            return redirect()->route('chat.room', $existingChat->id)->with('success', 'Melanjutkan sesi konsultasi Anda.');
        }
        
        // Ambil tarif klinik berdasarkan kategori
        $tariff = DB::table('chat_tariffs')->where('category', $category)->first();
        $price = $tariff ? $tariff->price : 0;

        // Validasi apakah saldo pasien cukup
        if ($user->balance < $price) {
            return redirect()->back()->with('error', 'Saldo Anda tidak cukup untuk memulai chat di klinik ini. Silakan top-up terlebih dahulu.');
        }

        try {
            // Gunakan Transaksi: Saldo hanya terpotong jika pembuatan room 100% SUKSES
            $room = DB::transaction(function () use ($user, $price, $category) {
                
                // 1. Potong Saldo Pasien
                User::where('id', $user->id)->decrement('balance', $price);

                // 2. Buat Room Chat Baru
                $roomId = DB::table('chat_rooms')->insertGetId([
                    'user_id' => $user->id,
                    'doctor_id' => null,
                    'category' => $category,
                    'price_at_time' => $price,
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return $roomId;
            });

            // Jika sukses, lempar langsung ke halaman room chat
            return redirect()->route('chat.room', $room);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}