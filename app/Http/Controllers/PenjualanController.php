<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produksi; // Sesuaikan dengan model stok/produksi kamu jika ada
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    /**
     * Tampilkan Halaman Utama & Daftar Penjualan
     */
    public function index()
    {
        // Mengambil daftar penjualan terbaru dengan pagination
        $penjualan = Penjualan::orderBy('Timestamp', 'desc')->paginate(10);

        // Ambil data produk yang sudah selesai diproduksi / siap dijual untuk dropdown modal
        // Jika belum ada model Produksi, variabel ini bisa diisi array static atau query yang sesuai
        $produkSelesai = class_exists(Produksi::class) 
            ? Produksi::all() 
            : collect([]);

        return view('penjualan.index', compact('penjualan', 'produkSelesai'));
    }

    /**
     * Simpan Transaksi Penjualan Baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'Product_Name'   => 'required|string|max:255',
            'Category'       => 'required|string|max:100',
            'Qty'            => 'required|integer|min:1',
            'Unit_Price'     => 'required|numeric|min:0',
            'Payment_Method' => 'required|string|in:CASH,QRIS,TRANSFER',
        ], [
            'Product_Name.required'   => 'Pilih atau isi nama produk terlebih dahulu.',
            'Category.required'       => 'Kategori produk wajib diisi.',
            'Qty.required'            => 'Jumlah produk (Qty) wajib diisi.',
            'Qty.min'                 => 'Minimal pembelian adalah 1.',
            'Unit_Price.required'     => 'Harga satuan wajib diisi.',
            'Payment_Method.required' => 'Pilih metode pembayaran.',
        ]);

        // 2. Generate Order ID unik (Format: ORD-YYYYMMDD-XXXX)
        $orderId = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // 3. Hitung Total Harga
        $totalPrice = $validated['Qty'] * $validated['Unit_Price'];

        // 4. Simpan ke Database
        Penjualan::create([
            'Order_ID'       => $orderId,
            'Timestamp'      => now(),
            'Product_Name'   => $validated['Product_Name'],
            'Category'       => $validated['Category'],
            'Qty'            => $validated['Qty'],
            'Unit_Price'     => $validated['Unit_Price'],
            'Total_Price'    => $totalPrice,
            'Payment_Method' => $validated['Payment_Method'],
        ]);

        return redirect()->back()->with('success', 'Transaksi penjualan berhasil disimpan! Order ID: ' . $orderId);
    }
}