<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'nama_peminjam',
        'jenis_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'user_id'
    ];

    // peminjaman dicatat oleh user (admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // satu peminjaman punya banyak barang
    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'detail_peminjaman')
                    ->withPivot('jumlah', 
                                'kondisi_sebelum', 
                                'kondisi_sesudah')
                    ->withTimestamps();
    }
}
