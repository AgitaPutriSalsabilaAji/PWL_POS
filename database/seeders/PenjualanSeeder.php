<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('m_user')->pluck('user_id')->toArray();

        if (empty($userIds)) {
            return; // Hentikan seeder jika tidak ada user
        }

        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'pembeli' => 'Pembeli ' . $i,
                'penjualan_kode' => 'TRX' . str_pad($i, 3, '0', STR_PAD_LEFT), // TRX001, TRX002...
                'penjualan_tanggal' => now(),
                'user_id' => $userIds[array_rand($userIds)],
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
