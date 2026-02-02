<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    // 1 lokasi punya banyak barang
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
