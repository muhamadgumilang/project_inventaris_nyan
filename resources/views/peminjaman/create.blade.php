@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class='bx bx-plus me-2'></i>Tambah Peminjaman</h5>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading"><i class='bx bx-error-circle me-2'></i>Terdapat kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <!-- Informasi Peminjam -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class='bx bx-user me-2'></i>Informasi Peminjam</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_peminjam" class="form-control @error('nama_peminjam') is-invalid @enderror" 
                                        value="{{ old('nama_peminjam') }}" placeholder="Masukkan nama lengkap" required autofocus>
                                    @error('nama_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Peminjam <span class="text-danger">*</span></label>
                                    <select name="jenis_peminjam" class="form-select @error('jenis_peminjam') is-invalid @enderror" required>
                                        <option value="">Pilih jenis peminjam...</option>
                                        <option value="Mahasiswa" {{ old('jenis_peminjam') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="Dosen" {{ old('jenis_peminjam') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="Staf" {{ old('jenis_peminjam') == 'Staf' ? 'selected' : '' }}>Staf</option>
                                        <option value="Lainnya" {{ old('jenis_peminjam') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenis_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_pinjam" class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                @error('tanggal_pinjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Barang yang Dipinjam -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class='bx bx-package me-2'></i>Barang yang Dipinjam</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">
                                <i class='bx bx-plus'></i> Tambah Barang
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="items-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60%">Barang <span class="text-danger">*</span></th>
                                            <th style="width: 30%">Jumlah <span class="text-danger">*</span></th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="barang_id[]" class="form-select" required>
                                                    <option value="">Pilih barang...</option>
                                                    @foreach($barang as $b)
                                                        <option value="{{ $b->id }}">{{ $b->nama_barang }} (Stok: {{ $b->jumlah }} {{ $b->satuan }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-success" onclick="addRow()" title="Tambah Baris">
                                                    <i class='bx bx-plus'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted"><i class='bx bx-info-circle'></i> Pastikan jumlah yang dipinjam tidak melebihi stok tersedia</small>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i> Simpan Peminjaman
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function addRow() {
                const tbody = document.querySelector('#items-table tbody');
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>
                    <select name="barang_id[]" class="form-select" required>
                        <option value="">Pilih barang...</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}">{{ addslashes($b->nama_barang) }} (Stok: {{ $b->jumlah }} {{ $b->satuan }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()" title="Hapus Baris">
                        <i class='bx bx-trash'></i>
                    </button>
                </td>
            `;
                tbody.appendChild(row);
            }
        </script>
    @endpush

@endsection