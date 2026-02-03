@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Barang</h5>
                <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah Barang</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang as $i => $b)
                                <tr>
                                    <td>{{ $barang->firstItem() + $i }}</td>
                                    <td style="width:70px">
                                        @if($b->foto)
                                            <img src="{{ asset('storage/' . $b->foto) }}" alt="" class="img-fluid rounded" />
                                        @else
                                            <div class="text-muted">-</div>
                                        @endif
                                    </td>
                                    <td>{{ $b->kode_barang }}</td>
                                    <td>{{ $b->nama_barang }}</td>
                                    <td>{{ optional($b->kategori)->nama_kategori ?? '-' }}</td>
                                    <td>{{ optional($b->lokasi)->nama_lokasi ?? '-' }}</td>
                                    <td>{{ $b->jumlah }} {{ $b->satuan }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('barang.show', $b->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                        <a href="{{ route('barang.edit', $b->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('barang.destroy', $b->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $barang->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection