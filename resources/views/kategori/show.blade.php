@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Kategori</h5>
                <div>
                    <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ $kategori->nama }}</dd>

                    <dt class="col-sm-3">Deskripsi</dt>
                    <dd class="col-sm-9">{{ $kategori->deskripsi ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection