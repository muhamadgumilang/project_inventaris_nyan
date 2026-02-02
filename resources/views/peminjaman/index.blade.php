@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Peminjaman</h5>
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $i => $p)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $p->kode_peminjaman }}</td>
                                    <td>{{ $p->nama_peminjam }}</td>
                                    <td>{{ $p->tanggal_pinjam }}</td>
                                    <td>{{ ucfirst($p->status) }}</td>
                                    <td>{{ optional($p->user)->name }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus peminjaman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection