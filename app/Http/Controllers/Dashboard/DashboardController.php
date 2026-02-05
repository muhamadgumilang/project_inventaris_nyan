<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total Statistik
        $totalBarang = \App\Models\Barang::count();
        $totalKategori = \App\Models\Kategori::count();
        $totalLokasi = \App\Models\Lokasi::count();
        
        // Statistik Peminjaman
        $totalPeminjaman = \App\Models\Peminjaman::count();
        $peminjamanAktif = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanSelesai = \App\Models\Peminjaman::where('status', 'dikembalikan')->count();
        $peminjamanTerlambat = \App\Models\Peminjaman::where('status', 'terlambat')->count();
        
        // Statistik Kondisi Barang
        $barangBaik = \App\Models\Barang::where('kondisi', 'baik')->count();
        $barangRusakRingan = \App\Models\Barang::where('kondisi', 'rusak_ringan')->count();
        $barangRusakBerat = \App\Models\Barang::where('kondisi', 'rusak_berat')->count();
        $barangHilang = \App\Models\Barang::where('kondisi', 'hilang')->count();
        
        // Barang dengan stok rendah (jumlah < 5)
        $barangStokRendah = \App\Models\Barang::where('jumlah', '<', 5)->count();
        
        // Peminjaman Terbaru
        $peminjamanTerbaru = \App\Models\Peminjaman::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Barang Terbaru
        $barangTerbaru = \App\Models\Barang::with(['kategori', 'lokasi'])
            ->latest()
            ->take(5)
            ->get();
        
        // Kategori dengan jumlah barang terbanyak
        $kategoriPopuler = \App\Models\Kategori::withCount('barang')
            ->orderBy('barang_count', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard.index', compact(
            'totalBarang',
            'totalKategori',
            'totalLokasi',
            'totalPeminjaman',
            'peminjamanAktif',
            'peminjamanSelesai',
            'peminjamanTerlambat',
            'barangBaik',
            'barangRusakRingan',
            'barangRusakBerat',
            'barangHilang',
            'barangStokRendah',
            'peminjamanTerbaru',
            'barangTerbaru',
            'kategoriPopuler'
        ));
    }
}