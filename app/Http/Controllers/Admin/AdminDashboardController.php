<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DoctorCommission;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    // 1. Menu Dashboard / Ringkasan
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $pendingTopups = DB::table('topups')->where('status', 'pending')->count();
        $tariffs = DB::table('chat_tariffs')->get();

        return view('admin.dashboard', compact('totalUsers', 'totalDoctors', 'pendingTopups', 'tariffs'));
    }

    // 2. Menu Manajemen Produk (Dengan Upload File & Pagination)
    public function products()
    {
        // Menampilkan 5 produk per halaman
        $products = Product::latest()->paginate(5);
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'solution' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Proses simpan file gambar ke folder storage/app/public/products
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'solution' => $request->solution,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Produk sukses ditambahkan');
    }

    // 3. Menu Manajemen Portofolio (Dengan Upload File & Pagination)
    public function portfolios()
    {
        $portfolios = Portfolio::latest()->paginate(5);
        return view('admin.portfolios', compact('portfolios'));
    }

    public function storePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'excerpt' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('image')->store('portfolios', 'public');

        Portfolio::create([
            'title' => $request->title,
            'category' => $request->category,
            'date' => now()->format('d M Y'),
            'excerpt' => $request->excerpt,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Portofolio sukses diposting');
    }

    // 4. Menu Manajemen Top-up Saldo User
    public function topups()
    {
        $topups = DB::table('topups')
            ->join('users', 'topups.user_id', '=', 'users.id')
            ->select('topups.*', 'users.name as user_name', 'users.email')
            ->latest()
            ->paginate(10);

        return view('admin.topups', compact('topups'));
    }

    public function verifyTopup($id, $status)
    {
        $topup = DB::table('topups')->where('id', $id)->first();

        if ($topup && $topup->status == 'pending') {
            if ($status == 'approved') {
                // Tambah saldo ke akun user
                User::where('id', $topup->user_id)->increment('balance', $topup->amount);
                DB::table('topups')->where('id', $id)->update(['status' => 'approved']);
                $msg = 'Topup berhasil disetujui, saldo user bertambah!';
            } else {
                DB::table('topups')->where('id', $id)->update(['status' => 'rejected']);
                $msg = 'Topup ditolak.';
            }
            return redirect()->back()->with('success', $msg);
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan atau sudah diproses.');
    }

    // 5. Menu Takeover Chat Instan (Admin Balas Chat & Refund Saldo Pasien)
    public function activeChats()
    {
        // Menampilkan chat rooms yang dialihkan ke admin karena dokter offline
        // Sementara kita ambil mock data room dari db untuk simulasi tampilan menu
        $rooms = DB::table('chat_rooms')
            ->join('users', 'chat_rooms.user_id', '=', 'users.id')
            ->select('chat_rooms.*', 'users.name as user_name')
            ->where('chat_rooms.status', 'waiting_admin')
            ->paginate(5);

        return view('admin.chats', compact('rooms'));
    }

    public function refundChat($id)
    {
        $room = DB::table('chat_rooms')->where('id', $id)->first();
        
        if ($room) {
            // Kembalikan saldo/poin ke user
            User::where('id', $room->user_id)->increment('balance', $room->price_at_time);
            
            // Ubah status room menjadi ditutup/jadwal ulang
            DB::table('chat_rooms')->where('id', $id)->update(['status' => 'refunded_and_rescheduled']);
            
            return redirect()->back()->with('success', 'Dokter offline: Saldo berhasil dikembalikan utuh ke user & jadwalkan ulang!');
        }
        return redirect()->back()->with('error', 'Sesi chat tidak valid.');
    }

    public function updateTariff(Request $request)
    {
        DB::table('chat_tariffs')->where('category', 'umum')->update(['price' => $request->price_umum]);
        DB::table('chat_tariffs')->where('category', 'kecantikan')->update(['price' => $request->price_kecantikan]);
        DB::table('chat_tariffs')->where('category', 'gigi')->update(['price' => $request->price_gigi]);

        return redirect()->back()->with('success', 'Tarif chat berhasil diperbarui!');
    }

    // Hapus Produk & Gambarnya dari Server
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file gambar asli dari folder storage/app/public/products jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari server!');
    }

    // Hapus Portofolio & Gambarnya dari Server
    public function destroyPortfolio($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Hapus file gambar asli dari folder storage/app/public/portfolios jika ada
        if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->back()->with('success', 'Portofolio berhasil dihapus dari server!');
    }

    // 1. Tampilkan Halaman Manajemen Dokter
    public function doctors()
    {
        $doctors = User::where('role', 'doctor')->latest()->paginate(10);
        return view('admin.doctors', compact('doctors'));
    }

    // 2. Proses Daftarkan Dokter Baru oleh Admin
    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'specialist' => 'required|in:umum,kecantikan,gigi',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'doctor',
            'specialist' => $request->specialist,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'balance' => 0,
        ]);

        return redirect()->back()->with('success', 'Akun Dokter baru berhasil didaftarkan ke sistem!');
    }

    // 3. Tampilkan Halaman Daftar Pasien / User
    public function users()
    {
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    // 1. Reset Password User / Dokter secara Instan (Default ke: password123)
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make('password123')
        ]);

        return redirect()->back()->with('success', 'Password untuk ' . $user->name . ' berhasil di-reset menjadi: password123');
    }

    // 2. Hapus Akun Dokter
    public function destroyDoctor($id)
    {
        $doctor = User::where('id', $id)->where('role', 'doctor')->firstOrFail();
        $doctor->delete();

        return redirect()->back()->with('success', 'Akun dokter berhasil dihapus dari sistem.');
    }

    // 3. Lihat Aktivitas Chat & Pembagian Komisi Dokter
    // public function doctorActivities()
    // {
    //     // Mengambil data dokter beserta hitungan chat yang selesai dan total komisi mereka
    //     $doctors = User::where('role', 'doctor')->latest()->paginate(10);
        
    //     $completedChats = DB::table('chat_rooms')
    //         ->join('users as patients', 'chat_rooms.user_id', '=', 'patients.id')
    //         ->join('users as doctors', 'chat_rooms.doctor_id', '=', 'doctors.id')
    //         ->select('chat_rooms.*', 'patients.name as patient_name', 'doctors.name as doctor_name')
    //         ->where('chat_rooms.status', 'closed')
    //         ->latest()
    //         ->paginate(10, ['*'], 'chats_page');

    //     return view('admin.doctor_activities', compact('doctors', 'completedChats'));
    // }

    // public function doctorActivities(Request $request)
    // {
    //     // Filter bulan & tahun — default bulan ini
    //     $month =(int) $request->get('month', now()->month);
    //     $year  = (int)      $request->get('year', now()->year);

    //     // Komisi per dokter per bulan
    //     $commissions = DoctorCommission::with('doctor')
    //         ->where('month', $month)
    //         ->where('year', $year)
    //         ->latest()
    //         ->paginate(10);
    //     dd($commissions->toArray());
    //     // Log chat selesai filter bulan
    //     $completedChats = DB::table('chat_rooms')
    //         ->join('users as patients', 'chat_rooms.user_id', '=', 'patients.id')
    //         ->join('users as doctors', 'chat_rooms.doctor_id', '=', 'doctors.id')
    //         ->leftJoin('chat_tariffs', 'chat_rooms.category', '=', 'chat_tariffs.category')
    //         ->select(
    //             'chat_rooms.*',
    //             'patients.name as patient_name',
    //             'doctors.name as doctor_name',
    //             DB::raw('ROUND(chat_rooms.price_at_time * COALESCE(chat_tariffs.doctor_percentage, 80) / 100) as commission_earned')
    //         )
    //         ->where('chat_rooms.status', 'closed')
    //         ->whereMonth('chat_rooms.updated_at', $month)
    //         ->whereYear('chat_rooms.updated_at', $year)
    //         ->latest('chat_rooms.updated_at')
    //         ->paginate(10, ['*'], 'chats_page');

    //     return view('admin.doctor_activities', compact('commissions', 'completedChats', 'month', 'year'));
    // }

    public function doctorActivities(Request $request)
    {
        // 1. Ambil filter bulan dan tahun (pastikan 2 digit untuk bulan agar pas dengan format tanggal)
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);
        
        // Membuat format string pencarian, misal: "2026-06"
        $searchDate = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);

        // =========================================================================
        // PROSES OTOMATISASI ISI TABEL: Menggunakan LIKE (Kebal Tipe Data Kolom)
        // =========================================================================
        $activeDoctors = \App\Models\User::where('role', 'doctor')
            ->join('chat_rooms', 'users.id', '=', 'chat_rooms.doctor_id')
            ->leftJoin('chat_tariffs', 'chat_rooms.category', '=', 'chat_tariffs.category')
            ->where('chat_rooms.status', 'closed')
            // Ganti whereMonth & whereYear menjadi LIKE string
            ->where('chat_rooms.updated_at', 'LIKE', $searchDate . '%')
            ->select(
                'users.id as doctor_id',
                DB::raw('COUNT(chat_rooms.id) as total_chats'),
                DB::raw('SUM(ROUND(chat_rooms.price_at_time * COALESCE(chat_tariffs.doctor_percentage, 80) / 100)) as total_commission')
            )
            ->groupBy('users.id')
            ->get();

        // Loop untuk memasukkan data ke tabel doctor_commissions
        foreach ($activeDoctors as $data) {
            // Cek apakah data rekap sudah ada
            $existingRecord = DB::table('doctor_commissions')
                ->where('doctor_id', $data->doctor_id)
                ->where('month', $month)
                ->where('year', $year)
                ->first();

            $currentStatus = ($existingRecord && $existingRecord->status === 'paid') ? 'paid' : 'unpaid';

            // Gunakan DB::table langsung agar terhindar dari error konfigurasi model
            DB::table('doctor_commissions')->updateOrInsert(
                [
                    'doctor_id' => $data->doctor_id,
                    'month'     => $month,
                    'year'      => $year,
                ],
                [
                    'total_chats'      => $data->total_chats,
                    'total_commission' => $data->total_commission,
                    'status'           => $currentStatus,
                    'created_at'       => $existingRecord->created_at ?? now(),
                    'updated_at'       => now(),
                ]
            );
        }
        // =========================================================================

        // 2. AMBIL DATA REKAP UNTUK BLADE (JOIN MANUAL)
        $commissions = DB::table('doctor_commissions')
            ->join('users', 'doctor_commissions.doctor_id', '=', 'users.id')
            ->select('doctor_commissions.*', 'users.name as doctor_name')
            ->where('doctor_commissions.month', $month)
            ->where('doctor_commissions.year', $year)
            ->latest('doctor_commissions.updated_at')
            ->paginate(10, ['*'], 'commissions_page');

        // 3. LOG CHAT SELESAI (Ganti juga menjadi LIKE agar isinya ikut muncul)
        $completedChats = DB::table('chat_rooms')
            ->join('users as patients', 'chat_rooms.user_id', '=', 'patients.id')
            ->join('users as doctors', 'chat_rooms.doctor_id', '=', 'doctors.id')
            ->leftJoin('chat_tariffs', 'chat_rooms.category', '=', 'chat_tariffs.category')
            ->select(
                'chat_rooms.*',
                'patients.name as patient_name',
                'doctors.name as doctor_name',
                DB::raw('ROUND(chat_rooms.price_at_time * COALESCE(chat_tariffs.doctor_percentage, 80) / 100) as commission_earned')
            )
            ->where('chat_rooms.status', 'closed')
            ->where('chat_rooms.updated_at', 'LIKE', $searchDate . '%')
            ->latest('chat_rooms.updated_at')
            ->paginate(10, ['*'], 'chats_page');

        return view('admin.doctor_activities', compact('commissions', 'completedChats', 'month', 'year'));
    }

    public function generateCommissions(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year  = (int) $request->input('year', now()->year);

        // Ambil semua dokter yang memiliki chat berstatus 'closed' di bulan & tahun pilihan
        $activeDoctors = \App\Models\User::where('role', 'doctor')
            ->join('chat_rooms', 'users.id', '=', 'chat_rooms.doctor_id')
            ->leftJoin('chat_tariffs', 'chat_rooms.category', '=', 'chat_tariffs.category')
            ->where('chat_rooms.status', 'closed')
            ->whereMonth('chat_rooms.updated_at', $month)
            ->whereYear('chat_rooms.updated_at', $year)
            ->select(
                'users.id as doctor_id',
                DB::raw('COUNT(chat_rooms.id) as total_chats'),
                DB::raw('SUM(ROUND(chat_rooms.price_at_time * COALESCE(chat_tariffs.doctor_percentage, 80) / 100)) as total_commission')
            )
            ->groupBy('users.id')
            ->get();

        if ($activeDoctors->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada transaksi chat selesai pada bulan ini untuk digenerate.');
        }

        // Masukkan atau update data ke tabel doctor_commissions
        foreach ($activeDoctors as $data) {
            // Cek dulu apakah data rekap untuk dokter ini di bulan/tahun tersebut sudah ada
            $existingRecord = DoctorCommission::where('doctor_id', $data->doctor_id)
                ->where('month', $month)
                ->where('year', $year)
                ->first();

            // Tentukan status: jika sudah ada dan statusnya 'paid', jangan diubah ke 'unpaid' lagi
            $currentStatus = ($existingRecord && $existingRecord->status === 'paid') ? 'paid' : 'unpaid';

            DoctorCommission::updateOrCreate(
                [
                    'doctor_id' => $data->doctor_id,
                    'month'     => $month,
                    'year'      => $year,
                ],
                [
                    'total_chats'      => $data->total_chats,
                    'total_commission' => $data->total_commission,
                    'status'           => $currentStatus,
                ]
            );
        }

        return redirect()->back()->with('success', 'Rekapitulasi komisi bulan ini berhasil diperbarui ke database!');
    }

    // Validasi pembayaran komisi oleh admin
    // public function payCommission($id)
    // {
    //     $commission = DoctorCommission::findOrFail($id);

    //     if ($commission->status === 'paid') {
    //         return redirect()->back()->with('error', 'Komisi ini sudah dibayar sebelumnya.');
    //     }

    //     $commission->update([
    //         'status'  => 'paid',
    //         'paid_at' => now(),
    //         'paid_by' => Auth::id(),
    //     ]);
    //     $namaBulan = Carbon::createFromDate($commission->year, (int) $commission->month, 1)->translatedFormat('F');

    //     return redirect()->back()->with('success', 
    //         'Komisi ' . $commission->doctor->name . ' bulan ' . 
    //         $namaBulan . ' ' . 
    //         $commission->year . ' telah ditandai LUNAS!'
    //     );
    //     // return redirect()->back()->with('success', 
    //     //     'Komisi ' . $commission->doctor->name . ' bulan ' . 
    //     //     \Carbon\Carbon::create()->month($commission->month)->translatedFormat('F') . 
    //     //     ' ' . $commission->year . ' telah ditandai LUNAS!'
    //     // );
    // }

    public function payCommission($id)
    {
        $commission = DoctorCommission::findOrFail($id);

        if (strtolower($commission->status) === 'paid') {
            return redirect()->back()->with('error', 'Komisi ini sudah dibayar sebelumnya.');
        }

        $commission->update([
            'status'  => 'paid',
            'paid_at' => now(),
            'paid_by' => \Auth::id(), // Menyimpan ID Admin yang menekan tombol lunas
        ]);

        $namaBulan = Carbon::createFromDate($commission->year, (int) $commission->month, 1)->translatedFormat('F');

        return redirect()->back()->with('success', 
            'Komisi ' . ($commission->doctor->name ?? 'Dokter') . ' bulan ' . 
            $namaBulan . ' ' . 
            $commission->year . ' telah dibayarkan!'
        );
    }

}