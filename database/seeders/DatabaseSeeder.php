<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Super Admin Klinik MBC
        // User::create([
        //     'name' => 'Super Admin MBC',
        //     'email' => 'admin@mbc.com',
        //     'password' => Hash::make('password123'), // Password untuk login
        //     'role' => 'admin',
        //     'balance' => 0,
        // ]);

        // // 2. Akun Dokter Umum
        // User::create([
        //     'name' => 'dr. Andi Wijaya',
        //     'email' => 'dokter.umum@mbc.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'doctor',
        //     'clinic_category'=>'umum',
        //     'balance' => 0,
        // ]);

        // // 3. Akun Dokter Kecantikan (Estetika)
        // User::create([
        //     'name' => 'dr. Citra Lestari, Sp.DVE',
        //     'email' => 'dokter.kecantikan@mbc.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'doctor',
        //     'clinic_category'=>'kecantikan',
        //     'balance' => 0,
        // ]);

        // // 4. Akun Dokter Gigi
        // User::create([
        //     'name' => 'drg. Budi Pratama',
        //     'email' => 'dokter.gigi@mbc.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'doctor',
        //     'clinic_category'=>'gigi',
        //     'balance' => 0,
        // ]);

        // // 5. Akun Pasien / User Biasa (Diberi Saldo Awal untuk Simulasi)
        // User::create([
        //     'name' => 'Rian Hidayat (Pasien)',
        //     'email' => 'user@gmail.com',
        //     'password' => Hash::make('password123'),
        //     'role' => 'user',
        //     'balance' => 150000, // Saldo awal Rp 150.000 untuk tes chat langsung nanti
        // ]);

        // \DB::table('chat_tariffs')->insert([
        //     ['category' => 'umum', 'price' => 25000, 'created_at' => now(), 'updated_at' => now()],
        //     ['category' => 'kecantikan', 'price' => 50000, 'created_at' => now(), 'updated_at' => now()],
        //     ['category' => 'gigi', 'price' => 35000, 'created_at' => now(), 'updated_at' => now()],
        // ]);
    }
}