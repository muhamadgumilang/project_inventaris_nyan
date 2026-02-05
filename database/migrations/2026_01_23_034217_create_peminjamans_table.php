<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            $table->string('kode_peminjaman')->unique();
            $table->string('nama_peminjam');
            $table->enum('jenis_peminjam',['mahasiswa','dosen','guru','staf','luar']);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status',['dipinjam','dikembalikan','terlambat'])->default('dipinjam');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};