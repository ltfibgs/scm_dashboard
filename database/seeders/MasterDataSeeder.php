<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data lama jika tabelnya ada (disesuaikan ke tabel_pengadaan_2025)
        if (Schema::hasTable('data_stok_gudang')) DB::table('data_stok_gudang')->delete();
        if (Schema::hasTable('tabel_pengadaan_2025')) DB::table('tabel_pengadaan_2025')->delete();

        // 1. Isi Data Gudang
        DB::table('data_stok_gudang')->insert([
            ['Item_ID' => 'RM001', 'Item_Name' => 'Kulit Sintetis Hitam', 'Stock_Qty' => 850, 'Unit' => 'Meter', 'Min_Stock' => 200, 'Supplier_ID' => 'SUP001', 'Unit_Cost' => 45000],
            ['Item_ID' => 'RM002', 'Item_Name' => 'Kulit Sintetis Putih', 'Stock_Qty' => 720, 'Unit' => 'Meter', 'Min_Stock' => 180, 'Supplier_ID' => 'SUP001', 'Unit_Cost' => 45000],
            ['Item_ID' => 'RM003', 'Item_Name' => 'Sol Karet Ukuran 38', 'Stock_Qty' => 500, 'Unit' => 'Pasang', 'Min_Stock' => 100, 'Supplier_ID' => 'SUP002', 'Unit_Cost' => 25000]
        ]);

        // 2. Isi Data Pengadaan 2025 (disesuaikan ke tabel_pengadaan_2025)
        DB::table('tabel_pengadaan_2025')->insert([
            ['Pengadaan_ID' => 'PO-2025-001', 'Item_ID' => 'RM001', 'Supplier_ID' => 'SUP001', 'Qty_Diajukan' => 1000, 'Harga_Satuan' => 45000, 'Total_Harga' => 45000000, 'Status' => 'Received', 'Tanggal_Pengajuan' => '2025-03-15', 'Tanggal_Diterima' => '2025-03-20'],
            ['Pengadaan_ID' => 'PO-2025-002', 'Item_ID' => 'RM003', 'Supplier_ID' => 'SUP002', 'Qty_Diajukan' => 500, 'Harga_Satuan' => 25000, 'Total_Harga' => 12500000, 'Status' => 'Received', 'Tanggal_Pengajuan' => '2025-06-10', 'Tanggal_Diterima' => '2025-06-14']
        ]);
    }
}