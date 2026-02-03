<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->foreignId('lokasi_id')->constrained('lokasis')->cascadeOnDelete();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->date('tanggal_beli')->nullable();
            $table->decimal('harga', 12, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};