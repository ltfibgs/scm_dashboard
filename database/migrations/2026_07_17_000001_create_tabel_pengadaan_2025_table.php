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
            $table->string('Pengadaan_ID', 50)->primary();

            // One-to-Many: supplier -> pengadaan
            $table->string('Supplier_ID', 50);

            // Item / nama barang
            $table->string('Item_Nama', 100);

            // Qty masuk
            $table->integer('Qty_Masuk');

            // Harga beli satuan
            $table->decimal('Harga_Beli_Satuan', 12, 2);

            // Total harga pengadaan
            $table->decimal('Total_Harga_Pengadaan', 15, 2);

            // Tanggal / waktu transaksi masuk
            $table->dateTime('Tanggal_Waktu_Transaksi_Masuk');

            $table->timestamps();

            $table->foreign('Supplier_ID')
                ->references('Supplier_ID')
                ->on('supplier')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_pengadaan_2025');
    }
};

