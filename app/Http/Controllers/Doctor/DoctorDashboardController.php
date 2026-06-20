<?php

// namespace App\Http\Controllers\Doctor;

// use App\Http\Controllers\Controller;
// use App\Models\ChatRoom;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

// class DoctorDashboardController extends Controller
// {
//     public function index()
//     {
//         $doctor = Auth::user();

//         // Ambil antrean pasien yang murni masih kosong (belum diambil dokter mana pun)
//         $availableChats = ChatRoom::with('patient')
//             ->where('status', 'pending')
//             ->whereNull('doctor_id')
//             ->where('category', $doctor->clinic_category)
//             ->orderBy('created_at', 'asc')
//             ->get();

//         // Ambil daftar chat aktif khusus yang sedang ditangani dokter ini
//         $activeChats = ChatRoom::with('patient')
//             ->where('doctor_id', $doctor->id)
//             ->where('status', 'active')
//             ->orderBy('updated_at', 'desc')
//             ->get();

//         return view('doctor.dashboard', compact('availableChats', 'activeChats'));
//     }

//     public function acceptRoom($id)
//     {
//         $doctor = Auth::user();
        
//         // Cek room di database
//         $room = ChatRoom::where('id', $id)->firstOrFail();

//         // === PROTEKSI RACING CONDITION ===
//         // Jika room sudah diisi doctor_id lain atau statusnya sudah bukan pending
//         if ($room->doctor_id !== null || $room->status !== 'pending') {
//             return redirect()->back()->with('error', 'Maaf, antrean pasien ini sudah diambil oleh dokter lain.');
//         }

//         // Jika lolos verifikasi, kunci job ini untuk dokter ini
//         $room->update([
//             'doctor_id' => $doctor->id,
//             'status' => 'active'
//         ]);

//         return redirect()->route('chat.room', $room->id)->with('success', 'Anda telah terhubung dengan pasien.');
//     }

//     // === FITUR AKHIRI SESI CHAT + TRANSFER KOMISI DINAMIS DARI ADMIN ===
//     public function endChat($id)
//     {
//         $doctor = Auth::user();

//         DB::beginTransaction();

//         try {
//             // 1. Cari room yang sedang dipegang oleh dokter ini dan statusnya masih aktif
//             $room = ChatRoom::where('id', $id)
//                 ->where('doctor_id', $doctor->id)
//                 ->where('status', 'active')
//                 ->firstOrFail();

//             // 2. Ubah status menjadi closed (Sesi Berakhir)
//             $room->update([
//                 'status' => 'closed'
//             ]);

//             // 3. PROSES HITUNG KOMISI DINAMIS (PILIHAN ADMIN)
//             // Ambil data tarif dan persentase komisi dari tabel chat_tariffs berdasarkan kategori chat
//             $tariff = DB::table('chat_tariffs')->where('category', $room->category)->first();
            
//             $price = $tariff ? $tariff->price : 25000; // Fallback harga jika kosong
            
//             // Ambil persentase dari admin (jika kolom kosong/null, otomatis gunakan fallback 80%)
//             $adminPercentage = ($tariff && isset($tariff->doctor_percentage)) ? $tariff->doctor_percentage : 80; 
            
//             // Konversi angka murni (misal 80) menjadi nilai desimal (0.80)
//             $percentage = $adminPercentage / 100;
//             $commission = $price * $percentage;

//             // Tambahkan komisi murni yang ditentukan admin ke balance dokter
//             DB::table('users')->where('id', $doctor->id)->increment('balance', $commission);

//             DB::commit();
//             return redirect()->route('doctor.dashboard')->with('success', 'Sesi konsultasi telah berhasil diakhiri dan komisi sebesar ' . $adminPercentage . '% (Rp' . number_format($commission, 0, ',', '.') . ') telah ditambahkan ke dompet Anda.');

//         } catch (\Exception $e) {
//             DB::rollBack();
//             return redirect()->back()->with('error', 'Gagal menyelesaikan sesi chat: ' . $e->getMessage());
//         }
//     }
// }

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatTariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\DoctorCommission;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();

        $availableChats = ChatRoom::with('patient')
            ->where('status', 'pending')
            ->whereNull('doctor_id')
            ->where('category', $doctor->clinic_category)
            ->orderBy('created_at', 'asc')
            ->get();

        $activeChats = ChatRoom::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'active')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('doctor.dashboard', compact('availableChats', 'activeChats'));
    }

    public function acceptRoom($id)
    {
        $doctor = Auth::user();

        $updated = ChatRoom::where('id', $id)
            ->where('status', 'pending')
            ->whereNull('doctor_id')
            ->where('category', $doctor->clinic_category)
            ->update([
                'doctor_id' => $doctor->id,
                'status'    => 'active',
            ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Maaf, antrean ini sudah diambil dokter lain.');
        }

        return redirect()->route('chat.room', $id)->with('success', 'Anda telah terhubung dengan pasien.');
    }

    // public function endChat($id)
    // {
    //     $doctor = Auth::user();

    //     DB::beginTransaction();

    //     try {
    //         $room = ChatRoom::where('id', $id)
    //             ->where('doctor_id', $doctor->id)
    //             ->where('status', 'active')
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         $room->update(['status' => 'closed']);

    //         $tariff = ChatTariff::where('category', $room->category)->first();

    //         if (!$tariff) {
    //             Log::warning("Tariff tidak ditemukan untuk kategori: {$room->category}, room_id: {$room->id}");
    //         }

    //         $price           = $tariff->price ?? 25000;
    //         $adminPercentage = $tariff->doctor_percentage ?? 80;
    //         $commission      = $price * ($adminPercentage / 100);

    //         DB::table('users')->where('id', $doctor->id)->increment('balance', $commission);

    //         DB::commit();

    //         return redirect()->route('doctor.dashboard')->with(
    //             'success',
    //             "Sesi selesai. Komisi {$adminPercentage}% (Rp" . number_format($commission, 0, ',', '.') . ") telah ditambahkan."
    //         );

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error("endChat gagal: " . $e->getMessage());
    //         return redirect()->back()->with('error', 'Gagal menyelesaikan sesi: ' . $e->getMessage());
    //     }
    // }
    // use App\Models\DoctorCommission;

    public function endChat($id)
    {
        $doctor = Auth::user();

        DB::beginTransaction();

        try {
            $room = ChatRoom::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->firstOrFail();

            $room->update(['status' => 'closed']);

            $tariff = \App\Models\ChatTariff::where('category', $room->category)->first();

            if (!$tariff) {
                \Log::warning("Tariff tidak ditemukan: {$room->category}");
            }

            $price           = $tariff->price ?? 25000;
            $adminPercentage = $tariff->doctor_percentage ?? 80;
            $commission      = $price * ($adminPercentage / 100);

            // Update balance dokter
            DB::table('users')->where('id', $doctor->id)->increment('balance', $commission);
            DB::table('users')->where('id', $doctor->id)->increment('commission', $commission);

            // ✅ Akumulasi komisi per bulan
            DoctorCommission::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'month'     => now()->month,
                    'year'      => now()->year,
                ],
                [
                    'status' => 'unpaid', // jangan overwrite kalau sudah paid
                ]
            );

            // Increment total_commission & total_chats
            DoctorCommission::where('doctor_id', $doctor->id)
                ->where('month', now()->month)
                ->where('year', now()->year)
                ->increment('total_commission', $commission);

            DoctorCommission::where('doctor_id', $doctor->id)
                ->where('month', now()->month)
                ->where('year', now()->year)
                ->increment('total_chats', 1);

            DB::commit();

            return redirect()->route('doctor.dashboard')->with(
                'success',
                "Sesi selesai. Komisi {$adminPercentage}% (Rp" . number_format($commission, 0, ',', '.') . ") telah ditambahkan."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}