<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'kondisi',
        'jumlah',
        'satuan',
        'tanggal_beli',
        'harga',
        'deskripsi',
        'foto'
    ];

    // barang milik satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // barang berada di satu lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // barang bisa dipinjam berkali-kali
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
