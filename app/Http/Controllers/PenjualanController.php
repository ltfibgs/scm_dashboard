<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query();

        // 1. Filter Tab (Hari Ini vs Historis)
        if ($request->filter === 'today') {
            $query->whereDate('Timestamp', Carbon::today());
        } elseif ($request->filter === 'history') {
            $query->whereDate('Timestamp', '<', Carbon::today());
        }

        // 2. Pencarian (Search Bar)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Order_ID', 'LIKE', "%{$search}%")
                  ->orWhere('Product_Name', 'LIKE', "%{$search}%")
                  ->orWhere('Category', 'LIKE', "%{$search}%")
                  ->orWhere('Payment_Method', 'LIKE', "%{$search}%");
            });
        }

        // 3. Pengurutan Data (Urutan Paling Baru di Atas)
        $penjualan = $query->orderBy('Timestamp', 'desc')
                           ->orderBy('Order_ID', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        // 4. Ambil Daftar Produk Selesai dari DB (yang masih punya stok)
        $produkSelesai = DB::table('tabel_produksi')
            ->whereIn('Status', ['Completed', 'Selesai'])
            ->where('Stok_Tersedia', '>', 0)
            ->get();

        return view('penjualan.index', compact('penjualan', 'produkSelesai'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'Produksi_ID'    => 'required|string|max:50',
            'Product_Name'   => 'required|string|max:100',
            'Category'       => 'required|string|max:50',
            'Qty'            => 'required|numeric|min:1',
            'Unit_Price'     => 'required|numeric|min:0',
            'Payment_Method' => 'required|string',
        ], [
            'Produksi_ID.required' => 'Pilih produk terlebih dahulu.',
        ]);

        // 2. Cek stok tersedia
        $produk = DB::table('tabel_produksi')
            ->where('Produksi_ID', $request->Produksi_ID)
            ->whereIn('Status', ['Completed', 'Selesai'])
            ->first();

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan atau belum selesai diproduksi.');
        }

        if ($produk->Stok_Tersedia < $request->Qty) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi! Tersisa: ' . $produk->Stok_Tersedia . ' unit.');
        }

        // 3. Transaksi DB & Locking
        $autoOrderId = DB::transaction(function () use ($request) {
            $todayDate = date('Ymd');
            $prefix = "ORD-{$todayDate}-";

            $lastOrder = Penjualan::where('Order_ID', 'LIKE', "{$prefix}%")
                ->orderBy('Order_ID', 'desc')
                ->lockForUpdate()
                ->first();

            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder->Order_ID, -4);
                $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '4001';
            }

            $orderId = $prefix . $nextNumber;
            $totalPrice = $request->Qty * $request->Unit_Price;

            // Simpan Data Penjualan
            Penjualan::create([
                'Order_ID'       => $orderId,
                'Timestamp'      => now(),
                'Product_Name'   => $request->Product_Name,
                'Category'       => $request->Category,
                'Qty'            => $request->Qty,
                'Unit_Price'     => $request->Unit_Price,
                'Total_Price'    => $totalPrice,
                'Payment_Method' => $request->Payment_Method,
            ]);

            // Kurangi stok produk jadi
            DB::table('tabel_produksi')
                ->where('Produksi_ID', $request->Produksi_ID)
                ->decrement('Stok_Tersedia', $request->Qty);

            return $orderId;
        });

        return redirect()->route('penjualan.index')
            ->with('success', "Transaksi berhasil dibuat secara otomatis dengan ID: {$autoOrderId}")
            ->with('new_order_id', $autoOrderId);
    }

    public function updateStatus(Request $request, $id)
    {
        $penjualan = Penjualan::where('Order_ID', $id)->firstOrFail();

        if ($request->has('Payment_Method')) {
            $penjualan->update(['Payment_Method' => $request->Payment_Method]);
        }

        return redirect()->back()->with('success', 'Data penjualan berhasil diperbarui!');
    }
}