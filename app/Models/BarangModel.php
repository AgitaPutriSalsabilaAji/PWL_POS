<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'barang'; // nama tabel di database

    protected $primaryKey = 'barang_id'; // jika primary key bukan 'id'

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    // Relasi ke model Kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }
}
