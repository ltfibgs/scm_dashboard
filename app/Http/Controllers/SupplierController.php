<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = DB::table('supplier')->orderBy('Supplier_ID')->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Supplier_ID' => 'required|string|max:50',
            'Supplier_Name' => 'nullable|string|max:100',
            'Category' => 'nullable|string|max:50',
            'Contact_Person' => 'nullable|string|max:100',
            'City' => 'nullable|string|max:50',
        ]);

        DB::table('supplier')->updateOrInsert(
            ['Supplier_ID' => $data['Supplier_ID']],
            [
                'Supplier_Name' => $data['Supplier_Name'] ?? null,
                'Category' => $data['Category'] ?? null,
                'Contact_Person' => $data['Contact_Person'] ?? null,
                'City' => $data['City'] ?? null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()->route('supplier.index')->with('success', 'Data supplier tersimpan.');
    }

    public function update(Request $request, string $supplierId)
    {
        $data = $request->validate([
            'Supplier_Name' => 'nullable|string|max:100',
            'Category' => 'nullable|string|max:50',
            'Contact_Person' => 'nullable|string|max:100',
            'City' => 'nullable|string|max:50',
        ]);

        DB::table('supplier')
            ->where('Supplier_ID', $supplierId)
            ->update([
                'Supplier_Name' => $data['Supplier_Name'] ?? null,
                'Category' => $data['Category'] ?? null,
                'Contact_Person' => $data['Contact_Person'] ?? null,
                'City' => $data['City'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('supplier.index')->with('success', 'Data supplier diperbarui.');
    }

    public function destroy(string $supplierId)
    {
        DB::table('supplier')->where('Supplier_ID', $supplierId)->delete();
        return redirect()->route('supplier.index')->with('success', 'Data supplier dihapus.');
    }
}

