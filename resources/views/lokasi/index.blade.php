@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-map bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Total Lokasi</span>
                                <h4 class="card-title mb-0">{{ $lokasis->total() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-package bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Total Barang</span>
                                <h4 class="card-title mb-0">{{ \App\Models\Barang::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-bar-chart bx-sm'></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <span class="d-block mb-1">Rata-rata per Lokasi</span>
                                <h4 class="card-title mb-0">{{ $lokasis->total() > 0 ? round(\App\Models\Barang::count() / $lokasis->total()) : 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class='bx bx-map me-2'></i>Daftar Lokasi</h5>
                <a href="{{ route('lokasi.create') }}" class="btn btn-primary">
                    <i class='bx bx-plus me-1'></i>Tambah Lokasi
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-search'></i></span>
                            <input type="text" class="form-control" id="searchLokasi" placeholder="Cari nama lokasi...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tableLokasi">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>Nama Lokasi</th>
                                <th>Deskripsi</th>
                                <th style="width: 120px">Jumlah Barang</th>
                                <th style="width: 180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lokasis as $i => $l)
                                <tr>
                                    <td>{{ $lokasis->firstItem() + $i }}</td>
                                    <td>
                                        <strong><i class='bx bx-map-pin me-2'></i>{{ $l->nama_lokasi }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ Str::limit($l->deskripsi, 80) ?: '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">
                                            {{ $l->barang->count() }} barang
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('lokasi.show', $l->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class='bx bx-show'></i>
                                            </a>
                                            <a href="{{ route('lokasi.edit', $l->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                            <form action="{{ route('lokasi.destroy', $l->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?');" class="mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class='bx bx-map bx-lg text-muted mb-2 d-block'></i>
                                        <p class="text-muted mb-2">Belum ada data lokasi.</p>
                                        <a href="{{ route('lokasi.create') }}" class="btn btn-sm btn-primary">
                                            <i class='bx bx-plus me-1'></i>Tambah Lokasi Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $lokasis->firstItem() ?? 0 }} - {{ $lokasis->lastItem() ?? 0 }} dari {{ $lokasis->total() }} data
                    </div>
                    <div>
                        {{ $lokasis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchLokasi');
            const table = document.getElementById('tableLokasi');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();

                for (let row of rows) {
                    if (row.cells.length === 1) continue;

                    const nama = row.cells[1].textContent.toLowerCase();
                    const deskripsi = row.cells[2].textContent.toLowerCase();

                    const match = nama.includes(searchTerm) || deskripsi.includes(searchTerm);
                    row.style.display = match ? '' : 'none';
                }
            });
        });
    </script>
@endsection