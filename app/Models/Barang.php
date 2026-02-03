<?php
// app/Models/Barang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';

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

    protected $casts = [
        'tanggal_beli' => 'date',
        'harga' => 'decimal:2',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
    public function peminjaman()
{
    return $this->belongsToMany(
        Peminjaman::class,
        'detail_peminjamans'
    )->withPivot(
        'jumlah',
        'kondisi_sebelum',
        'kondisi_sesudah'
    )->withTimestamps();
}

    /**
     * Generate kode barang otomatis dengan format BRG-XXXX
     */
    public static function generateKodeBarang()
    {
        // Ambil kode barang terakhir
        $lastBarang = self::orderBy('kode_barang', 'desc')->first();
        
        if (!$lastBarang || !$lastBarang->kode_barang) {
            // Jika belum ada barang, mulai dari BRG-0001
            return 'BRG-0001';
        }
        
        // Extract nomor dari kode terakhir (misal: BRG-0001 -> 0001)
        $lastKode = $lastBarang->kode_barang;
        
        // Cek apakah format kode valid (BRG-XXXX)
        if (preg_match('/BRG-(\d+)/', $lastKode, $matches)) {
            $lastNumber = intval($matches[1]);
            $newNumber = $lastNumber + 1;
            return 'BRG-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }
        
        // Jika format tidak sesuai, mulai dari awal
        return 'BRG-0001';
    }

}