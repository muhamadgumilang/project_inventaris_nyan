@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Notifications -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class='bx bx-check-circle me-2'></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class='bx bx-error-circle me-2'></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- User Hero Section -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card bg-label-primary border-0">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <h4 class="fw-bold mb-1 text-primary text-uppercase">Pusat Peminjaman Barang</h4>
                            <p class="mb-0 text-muted">Halo, <strong>{{ Auth::user()->name }}</strong>. Cari dan pinjam barang yang Anda butuhkan di sini.</p>
                        </div>
                        <div class="d-none d-md-block">
                            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
                                <i class='bx bx-plus-circle me-1'></i> Mulai Peminjaman Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats & Overview -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-light-warning p-2 me-3">
                            <i class='bx bx-time fs-3 text-warning'></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Pinjaman Aktif Anda</h6>
                            <h4 class="mb-0 fw-bold">{{ $myActiveLoans ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-light-success p-2 me-3">
                            <i class='bx bx-check-double fs-3 text-success'></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Barang Tersedia</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalItemsAvailable ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar bg-light-info p-2 me-3">
                            <i class='bx bx-grid-alt fs-3 text-info'></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-muted small">Kategori Aset</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalCategories ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Available Items to Borrow -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between bg-white border-bottom py-3">
                        <h5 class="m-0 fw-bold text-dark"><i class='bx bx-package me-2 text-primary'></i>Barang Tersedia</h5>
                        <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary">Lihat Katalog</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($availableBarang as $barang)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($barang->foto)
                                                    <img src="{{ asset('storage/' . $barang->foto) }}" class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                                @else
                                                    <div class="avatar avatar-sm bg-label-secondary me-3">
                                                        <span class="avatar-initial rounded"><i class='bx bx-box'></i></span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-semibold d-block text-dark">{{ $barang->nama_barang }}</span>
                                                    <small class="text-muted">{{ $barang->kode_barang }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-label-info">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                        <td>
                                            <span class="text-dark fw-bold">{{ $barang->jumlah }}</span> 
                                            <small class="text-muted">{{ $barang->satuan }}</small>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('peminjaman.create', ['barang_id' => $barang->id]) }}" class="btn btn-sm btn-primary">
                                                Pinjam
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="{{ asset('assets/img/illustrations/empty-state.png') }}" class="mb-3" alt="Empty" width="120">
                                            <p class="text-muted">Tidak ada barang tersedia saat ini.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Borrowings History -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="m-0 fw-bold text-dark"><i class='bx bx-history me-2 text-warning'></i>Pinjaman Saya</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="list-group list-group-flush">
                            @forelse($myPeminjaman as $p)
                            <div class="list-group-item px-0 py-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-bold text-dark">{{ $p->kode_peminjaman }}</h6>
                                    <span class="badge bg-label-{{ $p->status == 'dipinjam' ? 'warning' : 'success' }} px-2 py-1">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </div>
                                <div class="small text-muted mb-2">
                                    <i class='bx bx-calendar-event me-1 text-primary'></i> {{ $p->tanggal_pinjam }}
                                </div>
                                <div class="bg-light p-2 rounded">
                                    <p class="mb-0 small fw-semibold text-dark">
                                        @foreach($p->barang as $b)
                                            {{ $b->nama_barang }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class='bx bx-archive text-muted mb-2 display-6'></i>
                                <p class="text-muted small">Anda belum pernah meminjam barang.</p>
                            </div>
                            @endforelse
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-light text-primary w-100">
                                Lihat Semua Riwayat <i class='bx bx-chevron-right'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .bg-light-warning { background-color: #fff8e1; }
        .bg-light-success { background-color: #e8f5e9; }
        .bg-light-info { background-color: #e3f2fd; }
        .avatar {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
    </style>
@endpush