<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tabel_produksi', function (Blueprint $table) {
            $table->integer('Stok_Tersedia')->default(0)->after('Qty_Hasil_Jadi');
        });

        // Isi Stok_Tersedia untuk data produksi yang sudah Completed
        DB::statement("UPDATE tabel_produksi SET Stok_Tersedia = Qty_Hasil_Jadi WHERE Status = 'Completed' AND Qty_Hasil_Jadi IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel_produksi', function (Blueprint $table) {
            $table->dropColumn('Stok_Tersedia');
        });
    }
};

