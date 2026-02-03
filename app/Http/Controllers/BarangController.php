<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::with(['kategori', 'lokasi'])->latest()->paginate(15);
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        $nextKode = Barang::generateKodeBarang();
        return view('barang.create', compact('kategoris', 'lokasis', 'nextKode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang'   => 'nullable|unique:barangs',
            'nama_barang'   => 'required',
            'kategori_id'   => 'required|exists:kategoris,id',
            'lokasi_id'     => 'required|exists:lokasis,id',
            'kondisi'       => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'jumlah'        => 'required|integer|min:0',
            'satuan'        => 'required',
            'tanggal_beli'  => 'nullable|date',
            'harga'         => 'nullable|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-generate kode_barang jika kosong
        if (empty($validated['kode_barang'])) {
            $validated['kode_barang'] = Barang::generateKodeBarang();
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('barang', 'public');
            $validated['foto'] = $path;
        }

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'lokasi', 'peminjaman']);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang'   => 'required|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'   => 'required',
            'kategori_id'   => 'required|exists:kategoris,id',
            'lokasi_id'     => 'required|exists:lokasis,id',
            'kondisi'       => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'jumlah'        => 'required|integer|min:0',
            'satuan'        => 'required',
            'tanggal_beli'  => 'nullable|date',
            'harga'         => 'nullable|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($barang->foto && \Storage::disk('public')->exists($barang->foto)) {
                \Storage::disk('public')->delete($barang->foto);
            }
            $path = $request->file('foto')->store('barang', 'public');
            $validated['foto'] = $path;
        }

        $barang->update($validated);

        return redirect()->route('barang.show', $barang->id)
            ->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        // Delete foto if exists
        if ($barang->foto && \Storage::disk('public')->exists($barang->foto)) {
            \Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus');
    }
}