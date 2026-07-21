<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika tabel sudah ada (karena import SQL / data awal), jangan bikin ulang.
        // Ini memastikan migration bisa dianggap berhasil tanpa mengubah struktur.
        if (Schema::hasTable('tabel_pengadaan_2025')) {
            return;
        }

        Schema::create('tabel_pengadaan_2025', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Kolom sesuai kebutuhan tampilan pengadaan
            $table->integer('No')->unique();
            $table->string('Bahan Baku', 255);
            $table->integer('Jml Peramalan 2025')->nullable();
            $table->string('Supplier Terpilih (WP)', 255);
            $table->integer('Minimal Supplier')->nullable();
            $table->integer('Stok Sisa 2024')->nullable();
            $table->integer('Safety Stock Bahan')->nullable();
            $table->integer('Jumlah Yg Harus Dibeli')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_pengadaan_2025');
    }
};

