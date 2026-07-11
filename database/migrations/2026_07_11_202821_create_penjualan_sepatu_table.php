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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('Order_ID', 50)->primary();
            $table->dateTime('Timestamp');
            $table->string('Product_Name', 100);
            $table->string('Category', 50);
            $table->integer('Qty');
            $table->decimal('Unit_Price', 12, 2);
            $table->decimal('Total_Price', 15, 2);
            $table->string('Payment_Method', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_sepatu');
    }
};
