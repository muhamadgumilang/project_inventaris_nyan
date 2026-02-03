@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Kategori</h5>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
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
                            @forelse($kategoris as $i => $k)
                                <tr>
                                    <td>{{ $kategoris->firstItem() + $i }}</td>
                                    <td>{{ $k->nama_kategori }}</td>
                                    <td>{{ Str::limit($k->deskripsi, 80) }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('kategori.show', $k->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('kategori.destroy', $k->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection