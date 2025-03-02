<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray(); // Ambil barang_id yang ada di database

        if (empty($barangIds)) {
            return; // Hentikan seeder jika tidak ada barang
        }

        $data = [];
        foreach ($barangIds as $barangId) {
            $data[] = [
                'barang_id' => $barangId,
                'user_id' => 1, // Pastikan user_id 1 ada di database
                'stok_tanggal' => now(),
                'stok_jumlah' => rand(10, 50),
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}
