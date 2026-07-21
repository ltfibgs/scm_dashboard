<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index()
    {
        // Mengambil data pengiriman beserta info produk dari tabel produksi
        $pengiriman = DB::table('tabel_pengiriman')
            ->leftJoin('tabel_produksi', 'tabel_pengiriman.Produksi_ID', '=', 'tabel_produksi.Produksi_ID')
            ->select('tabel_pengiriman.*', 'tabel_produksi.Nama_Produk_Jadi')
            ->orderBy('tabel_pengiriman.Pengiriman_ID', 'desc')
            ->get();

        // Mengambil data produksi yang statusnya 'Completed' untuk pilihan dropdown kirim
        $produksiSelesai = DB::table('tabel_produksi')
            ->where('Status', 'Completed')
            ->get();

        return view('pengiriman.index', compact('pengiriman', 'produksiSelesai'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Pengiriman_ID' => 'required|string|max:50|unique:tabel_pengiriman,Pengiriman_ID',
            'Produksi_ID'   => 'required|string',
            'Tujuan'        => 'required|string|max:255',
            'Qty_Kirim'     => 'required|integer|min:1',
            'Kurir'         => 'nullable|string|max:100',
        ]);

        DB::table('tabel_pengiriman')->insert([
            'Pengiriman_ID'   => $data['Pengiriman_ID'],
            'Produksi_ID'     => $data['Produksi_ID'],
            'Tujuan'          => $data['Tujuan'],
            'Qty_Kirim'       => $data['Qty_Kirim'],
            'Kurir'           => $data['Kurir'] ?? '-',
            'Status_Kirim'    => 'Dalam Pengiriman',
            'Tanggal_Kirim'   => now(),
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Data pengiriman berhasil dibuat!');
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'Status_Kirim' => 'required|string'
        ]);

        DB::table('tabel_pengiriman')
            ->where('Pengiriman_ID', $id)
            ->update([
                'Status_Kirim' => $data['Status_Kirim']
            ]);

        return redirect()->route('pengiriman.index')->with('success', 'Status pengiriman berhasil diperbarui!');
    }
}