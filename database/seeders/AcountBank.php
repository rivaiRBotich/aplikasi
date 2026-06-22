<?php

// namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use app\Models\AccountBank;

// class AcountBank extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         acount_bank::create([
//             'nama_bank' => 'Bank BCA',
//             'account' => '888-2222-xxxx',
//             'nama_penerima' => 'Pt. Sekantin',
//         ]);
//     }
// }


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountBank;

class AcountBank extends Seeder
{
    public function run(): void
    {
        AccountBank::create([
            'nama_bank' => 'Bank BCA',
            'account' => '888-2222-xxxx',
            'nama_penerima' => 'Pt. Sekantin',
        ]);
    }
}