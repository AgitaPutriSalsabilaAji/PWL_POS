<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level'; // pastikan nama tabelnya benar
    protected $primaryKey = 'level_id';
    protected $fillable = ['nama_level']; // pastikan kolom ini memang ada
}
