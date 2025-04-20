<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini (sesuaikan dengan tabel di database)
    protected $table = 'm_kategori'; // Sesuaikan dengan nama tabel yang sesuai dengan database Anda

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'nama', // Kolom nama kategori
        'deskripsi', // Kolom deskripsi kategori (jika ada)
    ];

    // Mendefinisikan hubungan dengan model UserModel (bila menggunakan relasi One to Many)
    public function users()
    {
        return $this->hasMany(UserModel::class, 'kategori_id', 'id'); // Relasi ke tabel users
    }
}
