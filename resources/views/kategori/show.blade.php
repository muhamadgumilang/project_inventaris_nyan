@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Main Info -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class='bx bx-category me-2'></i>Detail Kategori</h5>
                        <div>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">
                                <i class='bx bx-edit'></i> Edit
                            </a>
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class='bx bx-arrow-back'></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" style="width: 30%"><i class='bx bx-category-alt me-2'></i>Nama Kategori</td>
                                <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-detail me-2'></i>Deskripsi</td>
                                <td>{{ $kategori->deskripsi ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-package me-2'></i>Jumlah Barang</td>
                                <td><span class="badge bg-label-primary">{{ $kategori->barang->count() }} barang</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-calendar me-2'></i>Dibuat</td>
                                <td><small>{{ $kategori->created_at->format('d M Y H:i') }}</small></td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-calendar-edit me-2'></i>Diperbarui</td>
                                <td><small>{{ $kategori->updated_at->format('d M Y H:i') }}</small></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Barang dalam Kategori -->
                @if($kategori->barang->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class='bx bx-package me-2'></i>Barang dalam Kategori Ini</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th>Kondisi</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kategori->barang as $b)
                                            <tr>
                                                <td><span class="badge bg-label-dark">{{ $b->kode_barang }}</span></td>
                                                <td><strong>{{ $b->nama_barang }}</strong></td>
                                                <td>
                                                    @if($b->kondisi == 'baik')
                                                        <span class="badge bg-success">Baik</span>
                                                    @elseif($b->kondisi == 'rusak_ringan')
                                                        <span class="badge bg-warning">Rusak Ringan</span>
                                                    @elseif($b->kondisi == 'rusak_berat')
                                                        <span class="badge bg-danger">Rusak Berat</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($b->kondisi) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $b->jumlah }} {{ $b->satuan }}</td>
                                                <td>
                                                    <a href="{{ route('barang.show', $b->id) }}" class="btn btn-sm btn-info">
                                                        <i class='bx bx-show'></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Statistics -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-bar-chart me-2'></i>Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Barang</span>
                            <h4 class="mb-0">{{ $kategori->barang->count() }}</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Kondisi Baik</span>
                            <h5 class="mb-0 text-success">{{ $kategori->barang->where('kondisi', 'baik')->count() }}</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Perlu Perbaikan</span>
                            <h5 class="mb-0 text-warning">{{ $kategori->barang->whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count() }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-cog me-2'></i>Aksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">
                                <i class='bx bx-edit'></i> Edit Kategori
                            </a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger w-100">
                                    <i class='bx bx-trash'></i> Hapus Kategori
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection