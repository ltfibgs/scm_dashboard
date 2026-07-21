<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengadaan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<div class="min-h-screen flex">
    @include('partials.sidebar', ['active' => 'pengadaan'])

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Pengadaan</h2>
            <span class="text-sm bg-indigo-100 text-indigo-800 font-medium px-3 py-1 rounded-full">Administrator</span>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6">
                <!-- Tabel Daftar Pengadaan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengadaan</h3>
                        
                        <!-- Tombol Tambah Pengadaan di Kanan Atas Tabel -->
                        <button onclick="document.getElementById('modalTambahPengadaan').showModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Pengadaan
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold">No</th>
                                <th class="py-3 px-6 font-semibold">Bahan Baku</th>
                                <th class="py-3 px-6 font-semibold">Supplier Terpilih</th>
                                <th class="py-3 px-6 font-semibold">Jumlah Dibeli</th>
                                <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($pengadaan as $p)
                                @php
                                    $pId = $p->No ?? '-';
                                    $pItem = $p->{"Bahan Baku"} ?? '-';
                                    $pSupId = $p->{"Supplier Terpilih (WP)"} ?? '-';
                                    $pQty = $p->{"Jumlah Yg Harus Dibeli"} ?? 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-6 font-medium text-gray-700">{{ $pId }}</td>
                                    <td class="py-3 px-6 text-gray-900 font-semibold">{{ $pItem }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $pSupId }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ number_format($pQty, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Fitur Edit Popover -->
                                            <details class="relative">
                                                <summary class="cursor-pointer text-indigo-700 font-semibold text-xs">Edit</summary>
                                                <form method="POST" action="{{ route('pengadaan.update', $pId) }}" class="mt-2 text-left bg-white border border-gray-200 rounded p-3 absolute right-0 z-10 shadow-lg w-64">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="space-y-2">
                                                        <label class="block text-xs font-medium text-gray-600">Supplier</label>
                                                        <select name="Supplier_ID" class="w-full rounded border-gray-300 text-xs px-2 py-1 border" required>
                                                            @foreach($suppliers as $sp)
                                                                @php 
                                                                    $spIdLoop = $sp->Supplier_ID ?? $sp->supplier_id ?? $sp->id ?? ''; 
                                                                    $spNameLoop = $sp->Supplier_Name ?? $sp->supplier_name ?? $sp->nama ?? $spIdLoop;
                                                                @endphp
                                                                <option value="{{ $spIdLoop }}" {{ $spIdLoop === $pSupId ? 'selected' : '' }}>
                                                                    {{ $spIdLoop }} - {{ $spNameLoop }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <label class="block text-xs font-medium text-gray-600">Nama Bahan Baku</label>
                                                        <input type="text" name="Item_Nama" value="{{ $pItem }}" class="w-full rounded border-gray-300 text-xs px-2 py-1 border" required>
                                                        
                                                        <label class="block text-xs font-medium text-gray-600">Jumlah Dibeli</label>
                                                        <input type="number" name="Qty_Masuk" value="{{ $pQty }}" class="w-full rounded border-gray-300 text-xs px-2 py-1 border" required>
                                                        
                                                        <input type="hidden" name="Harga_Beli_Satuan" value="0">
                                                        <input type="hidden" name="Tanggal_Waktu_Transaksi_Masuk" value="{{ now()->format('Y-m-d\TH:i') }}">

                                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1 rounded cursor-pointer mt-1">Update</button>
                                                    </div>
                                                </form>
                                            </details>

                                            <!-- Tombol Hapus -->
                                            <form method="POST" action="{{ route('pengadaan.destroy', $pId) }}" onsubmit="return confirm('Hapus pengadaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 hover:text-red-800 font-semibold text-xs cursor-pointer">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-400 font-semibold">Belum ada data.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- MODAL TAMBAH PENGADAAN (NATIVE DIALOG) -->
<dialog id="modalTambahPengadaan" class="rounded-xl shadow-xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Data Pengadaan</h3>
            <button onclick="document.getElementById('modalTambahPengadaan').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('pengadaan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">No Urut / ID Pengadaan (Angka)</label>
                <input type="number" name="Pengadaan_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: 15" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Supplier Terpilih</label>
                <select name="Supplier_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                    <option value="" disabled selected>-- Pilih Supplier --</option>
                    @foreach($suppliers as $sp)
                        @php 
                            $spId = $sp->Supplier_ID ?? $sp->supplier_id ?? $sp->id ?? ''; 
                            $spName = $sp->Supplier_Name ?? $sp->supplier_name ?? $sp->nama ?? $spId;
                        @endphp
                        <option value="{{ $spId }}">{{ $spId }} - {{ $spName }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Bahan Baku / Nama Barang</label>
                <input type="text" name="Item_Nama" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: Kulit Sapi" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah Yg Harus Dibeli (Qty)</label>
                <input type="number" name="Qty_Masuk" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: 500" required>
            </div>

            <input type="hidden" name="Harga_Beli_Satuan" value="0">
            <input type="hidden" name="Tanggal_Waktu_Transaksi_Masuk" value="{{ now()->format('Y-m-d\TH:i') }}">

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahPengadaan').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>