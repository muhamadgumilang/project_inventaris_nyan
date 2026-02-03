@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Lokasi</h5>
                <a href="{{ route('lokasi.create') }}" class="btn btn-primary">Tambah Lokasi</a>
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
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lokasis as $i => $l)
                                <tr>
                                    <td>{{ $lokasis->firstItem() + $i }}</td>
                                    <td>{{ $l->nama_lokasi }}</td>
                                    <td>{{ Str::limit($l->deskripsi, 80) }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('lokasi.show', $l->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('lokasi.edit', $l->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('lokasi.destroy', $l->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus lokasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada lokasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $lokasis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection