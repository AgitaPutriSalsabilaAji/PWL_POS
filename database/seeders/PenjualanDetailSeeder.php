<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua penjualan dari tabel t_penjualan
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        
        if (empty($penjualanIds)) {
            echo "Tidak ada data penjualan di tabel t_penjualan. Harap seed tabel t_penjualan terlebih dahulu.";
            return;
        }
        
        // Jika kamu mengharapkan tepat 10 transaksi, pastikan t_penjualan sudah terisi 10 record.
        // Jika tidak, kita akan menggunakan semua penjualan yang ada.
        $data = [];
        foreach ($penjualanIds as $penjualanId) {
            // Tambahkan tepat 3 detail untuk setiap transaksi penjualan
            for ($j = 0; $j < 3; $j++) {
                // Pilih barang secara acak dari 1 sampai 10
                $barang_id = rand(1, 10);
                // Ambil harga jual untuk barang tersebut dari tabel m_barang
                $harga = DB::table('m_barang')
                            ->where('barang_id', $barang_id)
                            ->value('harga_jual') ?? 0;
                            
                $data[] = [
                    'penjualan_id' => $penjualanId,
                    'barang_id'    => $barang_id,
                    'harga'        => $harga,
                    'jumlah'       => rand(1, 5),
                ];
            }
        }
        
        // Insert data ke tabel t_penjualan_detail
        DB::table('t_penjualan_detail')->insert($data);
    }
}
