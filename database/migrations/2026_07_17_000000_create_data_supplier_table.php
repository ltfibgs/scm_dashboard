<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // sesuai request: gunakan existing table saja, jadi migrasi ini tidak membuat tabel baru.
        // data_supplier tidak dibuat karena aturan kamu: jangan mengganti tabel yang sudah ada.
        // Namun, tetap tersedia untuk dokumentasi skema yang diinginkan.
    }

    public function down(): void
    {
        // tidak ada perubahan yang bisa dibatalkan.
    }
};

