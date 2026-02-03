@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Barang</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control"
                                value="{{ old('kode_barang', $nextKode ?? '') }}" readonly>
                            <small class="text-muted">Kode dibuat otomatis, bisa diubah jika perlu.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">Pilih kategori...</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <select name="lokasi_id" class="form-select" required>
                                <option value="">Pilih lokasi...</option>
                                @foreach($lokasis as $l)
                                    <option value="{{ $l->id }}" {{ old('lokasi_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', 0) }}" min="0"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Beli</label>
                        <input type="date" name="tanggal_beli" class="form-control" value="{{ old('tanggal_beli') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success">Simpan</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection