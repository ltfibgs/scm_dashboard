<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Total Revenue (Pendapatan) dari tabel penjualan Anda
        $totalRevenue = DB::table('3__dataset_penjualan_sepatu')->sum('Total_Price');

        // 2. Menghitung Total Units Sold (Jumlah Produk Terjual)
        $totalUnitsSold = DB::table('3__dataset_penjualan_sepatu')->sum('Qty');

        // ==========================================
        // TAMBAHAN: MENGAMBIL DATA UNTUK SALES TREND (GRAFIK)
        // ==========================================
        // Mengambil seluruh data mentah untuk dikelompokkan di sisi PHP agar aman dari error perbedaan format string di database
        $rawSales = DB::table('3__dataset_penjualan_sepatu')
            ->select('Timestamp', 'Total_Price', 'Qty')
            ->get();

        $groupedSales = $rawSales->groupBy(function($item) {
            // Jika menggunakan pemisah tanda hubung YYYY-MM-DD
            if (strpos($item->Timestamp, '-') !== false) {
                return substr($item->Timestamp, 0, 7);
            }
            // Jika menggunakan pemisah garis miring DD/MM/YYYY
            elseif (strpos($item->Timestamp, '/') !== false) {
                $parts = explode('/', $item->Timestamp);
                if (count($parts) >= 3) {
                    return $parts[2] . '-' . $parts[1]; // Ubah ke format YYYY-MM agar terurut secara kronologis
                }
            }
            // Jika format teks tidak dikenal, ambil 7 karakter terdepan
            return substr($item->Timestamp, 0, 7);
        });

        // Menyusun data array untuk dilempar ke Chart.js
        $chartLabels = [];
        $chartValues = [];
        $chartQty = [];

        // Mengurutkan bulan secara naik (dari bulan terlama ke terbaru)
        $sortedKeys = $groupedSales->keys()->sort();

        foreach ($sortedKeys as $key) {
            $chartLabels[] = $key;
            $chartValues[] = $groupedSales[$key]->sum('Total_Price');
            $chartQty[] = $groupedSales[$key]->sum('Qty');
        }
        // ==========================================

        // 3. Deteksi otomatis tabel inventaris/bahan baku di database Anda
        // Kode ini akan mencari tabel yang kemungkinan Anda buat (misal: 'bahan_baku', 'inventoris', 'inventory', atau 'products')
        $daftarPilihanTabel = ['bahan_baku', 'inventoris', 'inventory', 'barang', 'produk', 'products'];
        $namaTabelBahanBaku = null;

        foreach ($daftarPilihanTabel as $tabel) {
            if (Schema::hasTable($tabel)) {
                $namaTabelBahanBaku = $tabel;
                break;
            }
        }

        // Jika salah satu tabel di atas ditemukan di database Anda
        if ($namaTabelBahanBaku) {
            $materials = DB::table($namaTabelBahanBaku)->get();

            // Cek ketersediaan kolom 'stok' dan 'min_stok' untuk kalkulasi
            if (Schema::hasColumn($namaTabelBahanBaku, 'stok') && Schema::hasColumn($namaTabelBahanBaku, 'min_stok')) {
                $lowStockCount = DB::table($namaTabelBahanBaku)->whereRaw('stok <= min_stok')->count();
                $criticalItems = DB::table($namaTabelBahanBaku)->whereRaw('stok <= min_stok')->get();
            } else {
                $lowStockCount = 0;
                $criticalItems = collect();
            }
        } else {
            // BACKUP PLAN: Jika Anda belum membuat tabel inventaris terpisah, 
            // kita buat data tiruan (dummy) otomatis dari daftar produk unik yang ada di tabel penjualan Anda agar web tidak error.
            $produkUnik = DB::table('3__dataset_penjualan_sepatu')
                ->select('Product_Name')
                ->distinct()
                ->get();

            $materials = [];
            $lowStockCount = 0;
            $criticalItems = collect();

            // Membuat visualisasi inventory sementara berdasarkan nama produk unik Anda
            foreach ($produkUnik as $index => $p) {
                // Membuat data simulasi stok
                $stokSisa = ($index == 0) ? 45 : 120 + ($index * 15); 
                $minStok = 50;
                
                $item = (object)[
                    'id' => $index + 1,
                    'nama_bahan' => $p->Product_Name,
                    'stok' => $stokSisa,
                    'min_stok' => $minStok,
                    'supplier' => 'PT Pemasok Sepatu Utama'
                ];

                $materials[] = $item;

                if ($stokSisa <= $minStok) {
                    $lowStockCount++;
                    $criticalItems->push($item);
                }
            }
            $materials = collect($materials);
        }

        // Mengirimkan data ke halaman view dashboard (termasuk variabel grafik baru)
        return view('dashboard', compact(
            'totalRevenue', 
            'totalUnitsSold', 
            'lowStockCount', 
            'materials', 
            'criticalItems',
            'chartLabels',
            'chartValues',
            'chartQty'
        ));
    }
}