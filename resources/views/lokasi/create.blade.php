@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Lokasi</h5>
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

                <form action="{{ route('lokasi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="nama_lokasi" class="form-control" value="{{ old('nama_lokasi') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success">Simpan</button>
                        <a href="{{ route('lokasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection