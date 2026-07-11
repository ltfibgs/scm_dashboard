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
        Schema::create('stok_gudang', function (Blueprint $table) {
            $table->string('Item_ID', 50)->primary();
            $table->string('Item_Name', 100);
            $table->integer('Stock_Qty');
            $table->string('Unit', 20);
            $table->integer('Min_Stock');
            $table->string('Supplier_ID', 50);
            $table->decimal('Unit_Cost', 12, 2);
            $table->timestamps();

            $table->foreign('Supplier_ID')->references('Supplier_ID')->on('supplier')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_gudang');
    }
};
