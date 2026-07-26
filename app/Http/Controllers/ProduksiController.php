<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    public function index()
    {
        // Menggabungkan data tabel produksi dengan tabel gudang dengan menyamakan kolasi secara paksa
        $produksi = DB::table('tabel_produksi')
            ->leftJoin('data_stok_gudang', function ($join) {
                $join->on(
                    'tabel_produksi.Item_ID', 
                    '=', 
                    DB::raw('data_stok_gudang.Item_ID COLLATE utf8mb4_unicode_ci')
                );
            })
            ->select('tabel_produksi.*', 'data_stok_gudang.Item_Name')
            ->get();

        $gudang = DB::table('data_stok_gudang')->get();

        return view('produksi.index', compact('produksi', 'gudang'));
    }

    // Method store() dan complete() tidak perlu diubah
    public function store(Request $request)
    {
        $data = $request->validate([
            'Produksi_ID'       => 'required|string|max:50',
            'Item_ID'           => 'required|string',
            'Qty_Bahan_Dipakai' => 'required|integer|min:1',
            'Nama_Produk_Jadi'  => 'required|string|max:255',
            'Status'            => 'required|string',
        ]);

        $itemGudang = DB::table('data_stok_gudang')->where('Item_ID', $data['Item_ID'])->first();
        if (!$itemGudang || $itemGudang->Stock_Qty < $data['Qty_Bahan_Dipakai']) {
            return redirect()->back()->with('error', 'Stok di gudang tidak mencukupi untuk melakukan produksi ini.');
        }

        DB::transaction(function () use ($data) {
            DB::table('data_stok_gudang')
                ->where('Item_ID', $data['Item_ID'])
                ->decrement('Stock_Qty', $data['Qty_Bahan_Dipakai']);

            DB::table('tabel_produksi')->insert([
                'Produksi_ID'       => $data['Produksi_ID'],
                'Item_ID'           => $data['Item_ID'],
                'Nama_Produk_Jadi'  => $data['Nama_Produk_Jadi'],
                'Qty_Bahan_Dipakai' => $data['Qty_Bahan_Dipakai'],
                'Status'            => $data['Status'],
                'Tanggal_Mulai'     => now(),
            ]);
        });

        return redirect()->route('produksi.index')->with('success', 'Rencana produksi dimulai & stok gudang otomatis terpotong!');
    }

    public function complete(Request $request, $id)
    {
        $data = $request->validate([
            'Qty_Hasil_Jadi' => 'required|integer|min:1'
        ]);

        DB::table('tabel_produksi')
            ->where('Produksi_ID', $id)
            ->update([
                'Qty_Hasil_Jadi' => $data['Qty_Hasil_Jadi'],
                'Stok_Tersedia'  => $data['Qty_Hasil_Jadi'],
                'Status'         => 'Completed'
            ]);

        return redirect()->route('produksi.index')->with('success', 'Batch produksi berhasil diselesaikan!');
    }
}