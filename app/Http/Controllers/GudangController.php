<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = DB::table('data_stok_gudang')
            ->orderBy('Item_ID')
            ->get();

        return view('gudang.index', compact('gudang'));
    }

    // FUNGSI BARU UNTUK MENYIMPAN ITEM BARU
    public function store(Request $request)
    {
        $data = $request->validate([
            'Item_ID'      => 'required|string|max:50|unique:data_stok_gudang,Item_ID',
            'Item_Name'    => 'required|string|max:255',
            'Stock_Qty'    => 'required|numeric|min:0',
            'Unit'         => 'required|string|max:50',
            'Min_Stock'    => 'required|numeric|min:0',
            'Supplier_ID'  => 'nullable|string|max:50',
            'Unit_Cost'    => 'required|numeric|min:0',
        ]);

        DB::table('data_stok_gudang')->insert([
            'Item_ID'     => $data['Item_ID'],
            'Item_Name'   => $data['Item_Name'],
            'Stock_Qty'   => $data['Stock_Qty'],
            'Unit'        => $data['Unit'],
            'Min_Stock'   => $data['Min_Stock'],
            'Supplier_ID' => $data['Supplier_ID'] ?? '-',
            'Unit_Cost'   => $data['Unit_Cost'],
        ]);

        return redirect()->route('gudang.index')->with('success', 'Bahan baku baru berhasil ditambahkan ke gudang!');
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'stok_aktual' => 'required|numeric|min:0',
        ]);

        DB::table('data_stok_gudang')
            ->where('Item_ID', $id)
            ->update([
                'Stock_Qty' => $data['stok_aktual'],
            ]);

        return redirect()->route('gudang.index')->with('success', 'Stok berhasil diperbarui melalui Stock Opname.');
    }
}