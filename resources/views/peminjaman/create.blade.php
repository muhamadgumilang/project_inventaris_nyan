@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Peminjaman</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Peminjam</label>
                        <select name="jenis_peminjam" class="form-select" required>
                            <option value="">Pilih jenis...</option>
                            <option value="Mahasiswa" {{ old('jenis_peminjam') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa
                            </option>
                            <option value="Dosen" {{ old('jenis_peminjam') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Staf" {{ old('jenis_peminjam') == 'Staf' ? 'selected' : '' }}>Staf</option>
                            <option value="Lainnya" {{ old('jenis_peminjam') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control"
                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                    </div>

                    <hr>

                    <h6>Barang yang Dipinjam</h6>
                    <div class="table-responsive">
                        <table class="table" id="items-table">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th style="width:1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="barang_id[]" class="form-select" required>
                                            <option value="">Pilih barang...</option>
                                            @foreach($barang as $b)
                                                <option value="{{ $b->id }}">{{ $b->nama_barang }} ({{ $b->jumlah }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control" min="1" value="1"
                                            required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="addRow()">+</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success">Simpan</button>
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
                            <option value="{{ $b->id }}">{{ addslashes($b->nama_barang) }} ({{ $b->jumlah }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">-</button>
                </td>
            `;
                tbody.appendChild(row);
            }
        </script>
    @endpush

@endsection