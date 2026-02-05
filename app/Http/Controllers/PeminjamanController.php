<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user')->latest()->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        $barang = Barang::where('jumlah', '>', 0)->get();
        $selectedBarangId = $request->query('barang_id');
        
        return view('peminjaman.create', compact('barang', 'selectedBarangId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam'   => 'required',
            'jenis_peminjam'  => 'required',
            'tanggal_pinjam'  => 'required|date',
            'barang_id'       => 'required|array',
            'barang_id.*'     => 'required|exists:barangs,id',
            'jumlah'          => 'required|array',
            'jumlah.*'        => 'required|integer|min:1',
        ]);

        return \DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => 'PMJ-' . strtoupper(Str::random(6)),
                'nama_peminjam'   => $request->nama_peminjam,
                'jenis_peminjam'  => $request->jenis_peminjam,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'status'          => 'dipinjam',
                'user_id'         => Auth::id(),
            ]);

            foreach ($request->barang_id as $i => $barangId) {
                $barang = Barang::findOrFail($barangId);
                $jumlahPinjam = $request->jumlah[$i];

                // Validasi stok cukup
                if ($barang->jumlah < $jumlahPinjam) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi (Tersedia: {$barang->jumlah})");
                }

                // Simpan detail peminjaman
                $peminjaman->barang()->attach($barangId, [
                    'jumlah'          => $jumlahPinjam,
                    'kondisi_sebelum' => $barang->kondisi,
                ]);

                // Kurangi stok barang
                $barang->decrement('jumlah', $jumlahPinjam);
            }

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil disimpan dan stok telah diperbarui');
        });
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('barang');
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        return \DB::transaction(function () use ($peminjaman) {
            // Jika status masih dipinjam, kembalikan stoknya saat data dihapus
            if ($peminjaman->status == 'dipinjam') {
                foreach ($peminjaman->barang as $barang) {
                    $barang->increment('jumlah', $barang->pivot->jumlah);
                }
            }

            $peminjaman->delete();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dihapus dan stok telah dikembalikan');
        });
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Hanya peminjaman dengan status "Dipinjam" yang dapat dikembalikan.');
        }

        return \DB::transaction(function () use ($peminjaman) {
            foreach ($peminjaman->barang as $barang) {
                $barang->increment('jumlah', $barang->pivot->jumlah);
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);

            return redirect()->back()->with('success', 'Semua barang berhasil dikembalikan dan stok telah diperbarui.');
        });
    }
}