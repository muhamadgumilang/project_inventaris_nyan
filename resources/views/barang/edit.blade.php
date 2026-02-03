
@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Barang</h5>
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

                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode_barang" class="form-control"
                                value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control"
                                value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">Pilih kategori...</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id', $barang->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            <select name="lokasi_id" class="form-select" required>
                                <option value="">Pilih lokasi...</option>
                                @foreach($lokasis as $l)
                                    <option value="{{ $l->id }}" {{ old('lokasi_id', $barang->lokasi_id) == $l->id ? 'selected' : '' }}>{{ $l->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik
                                </option>
                                <option value="rusak_ringan" {{ old('kondisi', $barang->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak_berat" {{ old('kondisi', $barang->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                <option value="hilang" {{ old('kondisi', $barang->kondisi) == 'hilang' ? 'selected' : '' }}>
                                    Hilang</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control"
                                value="{{ old('jumlah', $barang->jumlah) }}" min="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" class="form-control"
                                value="{{ old('satuan', $barang->satuan) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Beli</label>
                        <input type="date" name="tanggal_beli" class="form-control"
                            value="{{ old('tanggal_beli', $barang->tanggal_beli) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" step="0.01" name="harga" class="form-control"
                            value="{{ old('harga', $barang->harga) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"
                            rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto (kosongkan jika tidak ingin mengganti)</label>
                        @if($barang->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="" class="img-fluid rounded"
                                    style="max-width:150px" />
                            </div>
                        @endif
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
