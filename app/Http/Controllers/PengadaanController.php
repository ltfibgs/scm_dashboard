<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        $suppliers = DB::table('supplier')->orderBy('Supplier_ID')->get();
        $pengadaan = DB::table('tabel_pengadaan_2025')
            ->orderByDesc('Pengadaan_ID')
            ->get();

        return view('pengadaan.index', compact('pengadaan', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Pengadaan_ID' => 'required|string|max:50',
            'Supplier_ID' => 'required|string|max:50',
            'Item_Nama' => 'required|string|max:100',
            'Qty_Masuk' => 'required|integer|min:1',
            'Harga_Beli_Satuan' => 'required|numeric|min:0',
            'Total_Harga_Pengadaan' => 'nullable|numeric|min:0',
            'Tanggal_Waktu_Transaksi_Masuk' => 'required|date',
        ]);

        $total = $data['Total_Harga_Pengadaan'] ?? ((float)$data['Qty_Masuk'] * (float)$data['Harga_Beli_Satuan']);

        DB::table('tabel_pengadaan_2025')->updateOrInsert(
            ['Pengadaan_ID' => $data['Pengadaan_ID']],
            [
                'Supplier_ID' => $data['Supplier_ID'],
                'Item_Nama' => $data['Item_Nama'],
                'Qty_Masuk' => $data['Qty_Masuk'],
                'Harga_Beli_Satuan' => $data['Harga_Beli_Satuan'],
                'Total_Harga_Pengadaan' => $total,
                'Tanggal_Waktu_Transaksi_Masuk' => $data['Tanggal_Waktu_Transaksi_Masuk'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan tersimpan.');
    }

    public function update(Request $request, string $pengadaanId)
    {
        $data = $request->validate([
            'Supplier_ID' => 'required|string|max:50',
            'Item_Nama' => 'required|string|max:100',
            'Qty_Masuk' => 'required|integer|min:1',
            'Harga_Beli_Satuan' => 'required|numeric|min:0',
            'Total_Harga_Pengadaan' => 'nullable|numeric|min:0',
            'Tanggal_Waktu_Transaksi_Masuk' => 'required|date',
        ]);

        $total = $data['Total_Harga_Pengadaan'] ?? ((float)$data['Qty_Masuk'] * (float)$data['Harga_Beli_Satuan']);

        DB::table('tabel_pengadaan_2025')
            ->where('Pengadaan_ID', $pengadaanId)
            ->update([
                'Supplier_ID' => $data['Supplier_ID'],
                'Item_Nama' => $data['Item_Nama'],
                'Qty_Masuk' => $data['Qty_Masuk'],
                'Harga_Beli_Satuan' => $data['Harga_Beli_Satuan'],
                'Total_Harga_Pengadaan' => $total,
                'Tanggal_Waktu_Transaksi_Masuk' => $data['Tanggal_Waktu_Transaksi_Masuk'],
                'updated_at' => now(),
            ]);

        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan diperbarui.');
    }

    public function destroy(string $pengadaanId)
    {
        DB::table('tabel_pengadaan_2025')->where('Pengadaan_ID', $pengadaanId)->delete();
        return redirect()->route('pengadaan.index')->with('success', 'Data pengadaan dihapus.');
    }
}

