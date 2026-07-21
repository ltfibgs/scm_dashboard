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
        Schema::create('tabel_produksi', function (Blueprint $table) {
            // Menggunakan string karena format ID-nya kustom seperti 'PRD-001'
            $table->string('Produksi_ID', 50)->primary(); 
            $table->string('Item_ID', 50);
            $table->string('Nama_Produk_Jadi', 255);
            $table->integer('Qty_Bahan_Dipakai');
            $table->integer('Qty_Hasil_Jadi')->nullable(); // Nullable karena diisi belakangan saat selesai
            $table->string('Status', 50)->default('Pending'); // Nilai: Pending, Processing, Completed
            $table->dateTime('Tanggal_Mulai')->useCurrent();
            
            // Opsional: Membuat foreign key ke tabel data_stok_gudang jika diperlukan kestabilan relasi
            // $table->foreign('Item_ID')->references('Item_ID')->on('data_stok_gudang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_produksi');
    }
};