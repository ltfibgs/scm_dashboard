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
        // Kita pakaihasTable dulu biar AMAN dan gak bakal eror "already exists" semisal tabelnya udah telanjur ada
        if (!Schema::hasTable('tabel_pengadaan_2025')) {
            Schema::create('tabel_pengadaan_2025', function (Blueprint $table) {
                // ID Pengadaan (Primary Key)
                $table->string('Pengadaan_ID', 50)->primary(); 
                
                // Relasi ke tabel data_stok_gudang (Collation disamakan biar gak bentrok pas JOIN)
                $table->string('Item_ID', 50)->collation('utf8mb4_unicode_ci'); 
                
                // Relasi ke Supplier
                $table->string('Supplier_ID', 50)->nullable(); 
                
                // Detail Jumlah dan Harga
                $table->integer('Qty_Diajukan');
                $table->decimal('Harga_Satuan', 15, 2); // Kolom Harga_Satuan yang dicari seeder
                $table->decimal('Total_Harga', 15, 2);
                
                // Status Pengadaan
                $table->string('Status', 50)->default('Pending'); 
                
                // Transaksi khusus tahun 2025
                $table->date('Tanggal_Pengajuan');
                $table->date('Tanggal_Diterima')->nullable(); 
                
                $table->timestamps(); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_pengadaan_2025');
    }
};