@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Main Info -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class='bx bx-list-check me-2'></i>Detail Peminjaman</h5>
                        <div>
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class='bx bx-arrow-back'></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class='bx bx-error-circle me-2'></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <!-- Informasi Peminjaman -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class='bx bx-info-circle me-2'></i>Informasi Peminjaman</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 45%">Kode Peminjaman</td>
                                        <td><span class="badge bg-label-dark">{{ $peminjaman->kode_peminjaman }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status</td>
                                        <td>
                                            @if($peminjaman->status === 'dipinjam')
                                                <span class="badge bg-warning"><i class='bx bx-time'></i> Dipinjam</span>
                                            @elseif($peminjaman->status === 'dikembalikan')
                                                <span class="badge bg-success"><i class='bx bx-check-circle'></i> Dikembalikan</span>
                                            @elseif($peminjaman->status === 'terlambat')
                                                <span class="badge bg-danger"><i class='bx bx-error-circle'></i> Terlambat</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Petugas</td>
                                        <td><i class='bx bx-user'></i> {{ optional($peminjaman->user)->name ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"><i class='bx bx-user me-2'></i>Informasi Peminjam</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="text-muted" style="width: 45%">Nama Peminjam</td>
                                        <td><strong>{{ $peminjaman->nama_peminjam }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jenis Peminjam</td>
                                        <td><span class="badge bg-label-info">{{ $peminjaman->jenis_peminjam }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Pinjam</td>
                                        <td>
                                            <i class='bx bx-calendar'></i> 
                                            {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Kembali</td>
                                        <td>
                                            @if($peminjaman->tanggal_kembali)
                                                <i class='bx bx-calendar-check'></i> {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">Belum dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Barang yang Dipinjam -->
                        <h6 class="mb-3"><i class='bx bx-package me-2'></i>Barang yang Dipinjam</h6>
                        @if($peminjaman->barang->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Kondisi Sebelum</th>
                                            <th>Kondisi Sesudah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($peminjaman->barang as $i => $b)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><strong>{{ $b->nama_barang }}</strong></td>
                                                <td><span class="badge bg-label-primary">{{ $b->pivot->jumlah }}</span></td>
                                                <td>
                                                    @if($b->pivot->kondisi_sebelum)
                                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $b->pivot->kondisi_sebelum)) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($b->pivot->kondisi_sesudah)
                                                        <span class="badge bg-success">{{ ucfirst(str_replace('_', ' ', $b->pivot->kondisi_sesudah)) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
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
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-package bx-lg text-muted mb-2 d-block'></i>
                                <p class="text-muted mb-0">Belum ada barang yang terkait</p>
                            </div>
                        @endif

                        <hr>

                        <!-- Timestamps -->
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class='bx bx-calendar'></i> Dibuat: {{ $peminjaman->created_at ? $peminjaman->created_at->format('d M Y H:i') : '-' }}
                                </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class='bx bx-calendar-edit'></i> Diperbarui: {{ $peminjaman->updated_at ? $peminjaman->updated_at->format('d M Y H:i') : '-' }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-info-circle me-2'></i>Ringkasan</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Barang</span>
                            <h4 class="mb-0">{{ $peminjaman->barang->count() }}</h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Jumlah</span>
                            <h4 class="mb-0">{{ $peminjaman->barang->sum('pivot.jumlah') }}</h4>
                        </div>
                        @if($peminjaman->tanggal_pinjam && $peminjaman->tanggal_kembali)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Durasi</span>
                                <h5 class="mb-0">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)) }} hari
                                </h5>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class='bx bx-cog me-2'></i>Aksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if($peminjaman->status === 'dipinjam')
                                <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan semua barang ini?');">
                                    @csrf
                                    <button class="btn btn-primary w-100 mb-2">
                                        <i class='bx bx-check-double me-1'></i> Kembalikan Barang
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger w-100">
                                    <i class='bx bx-trash me-1'></i> Hapus Peminjaman
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection