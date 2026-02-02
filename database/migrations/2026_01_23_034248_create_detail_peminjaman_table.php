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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peminjaman_id')
              ->constrained('peminjaman')
              ->cascadeOnDelete();
        $table->foreignId('barang_id')
              ->constrained('barang');
        $table->integer('jumlah');
        $table->string('kondisi_sebelum')->nullable();
        $table->string('kondisi_sesudah')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
