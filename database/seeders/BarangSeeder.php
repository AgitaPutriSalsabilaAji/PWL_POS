<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Nasi Goreng', 'harga_beli' => 15000, 'harga_jual' => 20000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Mie Goreng', 'harga_beli' => 12000, 'harga_jual' => 18000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Es Teh Manis', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Kopi Susu', 'harga_beli' => 5000, 'harga_jual' => 10000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Headset Bluetooth', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Charger HP', 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 30000, 'harga_jual' => 50000],
            ['kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 80000, 'harga_jual' => 120000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Pulpen', 'harga_beli' => 2000, 'harga_jual' => 5000],
            ['kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Buku Tulis', 'harga_beli' => 5000, 'harga_jual' => 10000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
