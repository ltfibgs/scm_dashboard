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
        // Gunakan Schema::create, BUKAN Schema::table
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->string('Pengiriman_ID')->primary();
            $table->string('Order_ID'); // Relasi ke tabel penjualan
            $table->string('Tujuan');
            $table->integer('Qty_Kirim');
            $table->string('Kurir')->nullable();
            $table->string('Status_Kirim')->default('Dalam Pengiriman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};