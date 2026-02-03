@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Peminjaman</h5>
                <div>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus peminjaman ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Kode</dt>
                            <dd class="col-sm-8"><strong>{{ $peminjaman->kode_peminjaman }}</strong></dd>

                            <dt class="col-sm-4">Nama Peminjam</dt>
                            <dd class="col-sm-8">{{ $peminjaman->nama_peminjam }}</dd>

                            <dt class="col-sm-4">Jenis</dt>
                            <dd class="col-sm-8">{{ $peminjaman->jenis_peminjam }}</dd>

                            <dt class="col-sm-4">Tanggal Pinjam</dt>
                            <dd class="col-sm-8">
                                @if($peminjaman->tanggal_pinjam)
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-4">Tanggal Kembali</dt>
                            <dd class="col-sm-8">
                                @if($peminjaman->tanggal_kembali)
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                <span
                                    class="badge bg-{{ $peminjaman->status === 'dipinjam' ? 'warning' : 'success' }}">{{ ucfirst($peminjaman->status) }}</span>
                            </dd>

                            <dt class="col-sm-4">Petugas</dt>
                            <dd class="col-sm-8">{{ optional($peminjaman->user)->name ?? '-' }}</dd>
                        </dl>
                    </div>

                    <div class="col-md-6">
                        <h6>Barang yang dipinjam</h6>
                        @if($peminjaman->barang->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Kondisi Sebelum</th>
                                            <th>Kondisi Sesudah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($peminjaman->barang as $i => $b)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $b->nama_barang }}</td>
                                                <td>{{ $b->pivot->jumlah }}</td>
                                                <td>{{ $b->pivot->kondisi_sebelum ?? '-' }}</td>
                                                <td>{{ $b->pivot->kondisi_sesudah ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada barang yang terkait.</p>
                        @endif
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Dibuat</strong></p>
                        <small
                            class="text-muted">{{ $peminjaman->created_at ? $peminjaman->created_at->format('d M Y H:i') : '-' }}</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-1"><strong>Diperbarui</strong></p>
                        <small
                            class="text-muted">{{ $peminjaman->updated_at ? $peminjaman->updated_at->format('d M Y H:i') : '-' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection