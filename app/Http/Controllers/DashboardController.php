<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. TOTAL REVENUE & UNITS SOLD
        // ==========================================
        $totalRevenue = DB::table('3__dataset_penjualan_sepatu')->sum('Total_Price');
        $totalUnitsSold = DB::table('3__dataset_penjualan_sepatu')->sum('Qty');

        // ==========================================
        // 2. DATA GRAFIK TREND PENJUALAN (REAL)
        // ==========================================
        $rawSales = DB::table('3__dataset_penjualan_sepatu')
            ->select('Timestamp', 'Total_Price', 'Qty')
            ->get();

        // --- Bulanan (Monthly) ---
        $groupedMonthly = $rawSales->groupBy(function($item) {
            if (strpos($item->Timestamp, '-') !== false) {
                return substr($item->Timestamp, 0, 7);
            } elseif (strpos($item->Timestamp, '/') !== false) {
                $parts = explode('/', $item->Timestamp);
                if (count($parts) >= 3) {
                    return $parts[2] . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT);
                }
            }
            return substr($item->Timestamp, 0, 7);
        });

        $sortedMonthly = $groupedMonthly->keys()->sort();
        $chartLabels = [];
        $chartValues = [];
        foreach ($sortedMonthly as $key) {
            $chartLabels[] = $key;
            $chartValues[] = $groupedMonthly[$key]->sum('Total_Price');
        }

        // --- Harian (Daily) - 7 hari terakhir ---
        $dailyLabels = [];
        $dailyValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('D');
            $daySales = $rawSales->filter(function($item) use ($date) {
                $itemDate = substr($item->Timestamp, 0, 10);
                return $itemDate === $date;
            });
            $dailyLabels[] = $label;
            $dailyValues[] = $daySales->sum('Total_Price');
        }

        // --- Mingguan (Weekly) - 4 minggu terakhir ---
        $weeklyLabels = [];
        $weeklyValues = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
            $endOfWeek = now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
            $label = 'Minggu ' . (4 - $i);
            $weekSales = $rawSales->filter(function($item) use ($startOfWeek, $endOfWeek) {
                $itemDate = substr($item->Timestamp, 0, 10);
                return $itemDate >= $startOfWeek && $itemDate <= $endOfWeek;
            });
            $weeklyLabels[] = $label;
            $weeklyValues[] = $weekSales->sum('Total_Price');
        }

        // --- Tahunan (Yearly) ---
        $yearlyLabels = [];
        $yearlyValues = [];
        $groupedYearly = $rawSales->groupBy(function($item) {
            if (strpos($item->Timestamp, '-') !== false) {
                return substr($item->Timestamp, 0, 4);
            } elseif (strpos($item->Timestamp, '/') !== false) {
                $parts = explode('/', $item->Timestamp);
                return $parts[2] ?? 'Unknown';
            }
            return substr($item->Timestamp, 0, 4);
        });
        $sortedYearly = $groupedYearly->keys()->sort();
        foreach ($sortedYearly as $key) {
            $yearlyLabels[] = $key;
            $yearlyValues[] = $groupedYearly[$key]->sum('Total_Price');
        }

        // ==========================================
        // 3. STATUS KONTROL INVENTARIS (PRODUK JADI)
        // ==========================================
        // Ambil data produk jadi dari tabel_produksi yang sudah Completed
        $produkJadi = DB::table('tabel_produksi')
            ->where('Status', 'Completed')
            ->where('Stok_Tersedia', '>', 0)
            ->select('Produksi_ID', 'Nama_Produk_Jadi', 'Stok_Tersedia')
            ->get();

        $materials = [];
        $lowStockCount = 0;

        foreach ($produkJadi as $p) {
            $minStok = 5; // Batas minimal stok produk jadi
            $item = (object)[
                'id'         => $p->Produksi_ID,
                'nama_bahan' => $p->Nama_Produk_Jadi,
                'stok'       => $p->Stok_Tersedia,
                'min_stok'   => $minStok,
                'supplier'   => 'Produksi Internal'
            ];
            $materials[] = $item;

            if ($p->Stok_Tersedia <= $minStok) {
                $lowStockCount++;
            }
        }

        $materials = collect($materials);

        // ==========================================
        // KIRIM KE VIEW
        // ==========================================
        return view('dashboard', compact(
            'totalRevenue',
            'totalUnitsSold',
            'lowStockCount',
            'materials',
            'chartLabels',
            'chartValues',
            'dailyLabels',
            'dailyValues',
            'weeklyLabels',
            'weeklyValues',
            'yearlyLabels',
            'yearlyValues'
        ));
    }
}
