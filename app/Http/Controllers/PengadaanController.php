<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel 'supplier' tanpa klausa order kolom yang berisiko error
        $suppliers = DB::table('supplier')->get();
        
        $pengadaan = DB::table('tabel_pengadaan_2025')
            ->orderBy('No')
            ->get();

        return view('pengadaan.index', compact('pengadaan', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Pengadaan_ID' => 'required|integer', 
            'Supplier_ID' => 'required|string|max:100', 
            'Item_Nama' => 'required|string|max:100', 
            'Qty_Masuk' => 'required|numeric|min:0', 
            'Harga_Beli_Satuan' => 'required|numeric|min:0',
            'Total_Harga_Pengadaan' => 'nullable|numeric|min:0',
            'Tanggal_Waktu_Transaksi_Masuk' => 'required|date',
        ]);

        DB::table('tabel_pengadaan_2025')->updateOrInsert(
            ['No' => $data['Pengadaan_ID']], 
            [
                'Bahan Baku' => $data['Item_Nama'],
                'Supplier Terpilih (WP)' => $data['Supplier_ID'],
                'Jumlah Yg Harus Dibeli' => $data['Qty_Masuk'],
                'Jml Peramalan 2025' => $data['Qty_Masuk'], 
                'Stok Sisa 2024' => 0,
                'Safety Stock Bahan' => 0,
                'Minimal Supplier' => 0,
            ]
        );

        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan tersimpan.');
    }

    public function update(Request $request, string $pengadaanId)
    {
        $data = $request->validate([
            'Supplier_ID' => 'required|string|max:100',
            'Item_Nama' => 'required|string|max:100',
            'Qty_Masuk' => 'required|numeric|min:0',
            'Harga_Beli_Satuan' => 'required|numeric|min:0',
            'Total_Harga_Pengadaan' => 'nullable|numeric|min:0',
            'Tanggal_Waktu_Transaksi_Masuk' => 'required|date',
        ]);

        DB::table('tabel_pengadaan_2025')
            ->where('No', $pengadaanId) 
            ->update([
                'Bahan Baku' => $data['Item_Nama'],
                'Supplier Terpilih (WP)' => $data['Supplier_ID'],
                'Jumlah Yg Harus Dibeli' => $data['Qty_Masuk'],
            ]);

        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan diperbarui.');
    }

    public function destroy(string $pengadaanId)
    {
        DB::table('tabel_pengadaan_2025')->where('No', $pengadaanId)->delete();
        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan dihapus.');
    }
}