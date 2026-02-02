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
        $peminjaman = Peminjaman::with('user')->latest()->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam'   => 'required',
            'jenis_peminjam'  => 'required',
            'tanggal_pinjam'  => 'required|date',
            'barang_id.*'     => 'required',
            'jumlah.*'        => 'required|integer|min:1',
        ]);

        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => 'PMJ-' . strtoupper(Str::random(6)),
            'nama_peminjam'   => $request->nama_peminjam,
            'jenis_peminjam'  => $request->jenis_peminjam,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'status'          => 'dipinjam',
            'user_id'         => Auth::id(),
        ]);

        foreach ($request->barang_id as $i => $barangId) {
            $peminjaman->barang()->attach($barangId, [
                'jumlah'          => $request->jumlah[$i],
                'kondisi_sebelum' => 'baik',
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil disimpan');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load('barang');
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }
}