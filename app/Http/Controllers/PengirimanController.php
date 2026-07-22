<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        // 1. Mengambil data pengiriman beserta detail produk & order dari model Penjualan
        $pengiriman = Pengiriman::with('penjualan')
            ->orderBy('Pengiriman_ID', 'desc')
            ->get();

        // 2. Mengambil data Penjualan Sepatu yang BELUM pernah dibuatkan pengiriman
        $penjualanSiapKirim = Penjualan::doesntHave('pengiriman')->get();

        return view('pengiriman.index', compact('pengiriman', 'penjualanSiapKirim'));
    }

    public function store(Request $request)
    {
        // Validation disesuaikan dengan tabel 'pengiriman' dan kolom 'Order_ID'
        $data = $request->validate([
            'Pengiriman_ID' => 'required|string|max:50|unique:pengiriman,Pengiriman_ID',
            'Order_ID'      => 'required|string|exists:3__dataset_penjualan_sepatu,Order_ID',
            'Tujuan'        => 'required|string|max:255',
            'Qty_Kirim'     => 'required|integer|min:1',
            'Kurir'         => 'nullable|string|max:100',
        ]);

        // Menyimpan data menggunakan Model Eloquent Pengiriman
        Pengiriman::create([
            'Pengiriman_ID' => $data['Pengiriman_ID'],
            'Order_ID'      => $data['Order_ID'],
            'Tujuan'        => $data['Tujuan'],
            'Qty_Kirim'     => $data['Qty_Kirim'],
            'Kurir'         => $data['Kurir'] ?? '-',
            'Status_Kirim'  => 'Dalam Pengiriman',
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman untuk Order #' . $data['Order_ID'] . ' berhasil dibuat!');
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'Status_Kirim' => 'required|string'
        ]);

        // Mengubah status pengiriman menggunakan Eloquent
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->update([
            'Status_Kirim' => $data['Status_Kirim']
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui!');
    }
}