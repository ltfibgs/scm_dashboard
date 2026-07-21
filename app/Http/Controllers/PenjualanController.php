<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        // 1. Ambil data penjualan dari tabel dataset (diurutkan berdasarkan Timestamp)
        $penjualan = Penjualan::orderBy('Timestamp', 'desc')->get();

        // 2. Ambil daftar produk yang status produksinya 'Completed' atau 'Selesai' dari DB::table
        $produkSelesai = DB::table('tabel_produksi')
            ->whereIn('Status', ['Completed', 'Selesai'])
            ->get();

        return view('penjualan.index', compact('penjualan', 'produkSelesai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Order_ID'       => 'required|unique:3__dataset_penjualan_sepatu,Order_ID',
            'Product_Name'   => 'required|string|max:100',
            'Category'       => 'required|string|max:50',
            'Qty'            => 'required|numeric|min:1',
            'Unit_Price'     => 'required|numeric|min:0',
            'Payment_Method' => 'required|string',
        ]);

        $totalPrice = $request->Qty * $request->Unit_Price;

        Penjualan::create([
            'Order_ID'       => $request->Order_ID,
            'Timestamp'      => now(),
            'Product_Name'   => $request->Product_Name,
            'Category'       => $request->Category,
            'Qty'            => $request->Qty,
            'Unit_Price'     => $request->Unit_Price,
            'Total_Price'    => $totalPrice,
            'Payment_Method' => $request->Payment_Method,
        ]);

        return redirect()->back()->with('success', 'Transaksi penjualan berhasil dicatat!');
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