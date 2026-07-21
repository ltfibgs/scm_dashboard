<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Gudang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar', ['active' => 'gudang'])

    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Stok Gudang</h2>
            <span class="text-sm bg-indigo-100 text-indigo-800 font-medium px-3 py-1 rounded-full">Logistik & Gudang</span>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- KARTU STATISTIK INDIKATOR -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Jenis Item</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ count($gudang) }} Item</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-emerald-100 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Kondisi Aman</p>
                        <h4 class="text-2xl font-bold text-gray-800">
                            {{ $gudang->where('Stock_Qty', '>=', 'Min_Stock')->count() }} Item
                        </h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-red-100 rounded-lg text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Kritis (Di Bawah Min)</p>
                        <h4 class="text-2xl font-bold text-red-600">
                            {{ $gudang->filter(fn($item) => $item->Stock_Qty < $item->Min_Stock)->count() }} Item
                        </h4>
                    </div>
                </div>
            </div>

            <!-- TABEL UTAMA STOK GUDANG -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Data Persediaan Bahan Baku</h3>
                    
                    <!-- TOMBOL TAMBAH DI KANAN ATAS TABEL -->
                    <button onclick="document.getElementById('modalTambahGudang').showModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Persediaan
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                            <th class="py-3 px-6 font-semibold">Item ID</th>
                            <th class="py-3 px-6 font-semibold">Nama Item</th>
                            <th class="py-3 px-6 font-semibold">Stok Aktual</th>
                            <th class="py-3 px-6 font-semibold">Batas Minimum</th>
                            <th class="py-3 px-6 font-semibold">Satuan</th>
                            <th class="py-3 px-6 font-semibold">Status</th>
                            <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($gudang as $g)
                            @php
                                $isKritis = $g->Stock_Qty < $g->Min_Stock;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 font-medium text-gray-600">{{ $g->Item_ID }}</td>
                                <td class="py-3 px-6 text-gray-900 font-bold text-base">{{ $g->Item_Name }}</td>
                                <td class="py-3 px-6 text-gray-800 font-semibold">{{ number_format($g->Stock_Qty, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-gray-500">{{ number_format($g->Min_Stock, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-gray-600 font-medium">{{ $g->Unit }}</td>
                                <td class="py-3 px-6">
                                    @if($isKritis)
                                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-600 rounded-full animate-ping"></span>
                                            Kritis (Butuh Restock)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                            Aman
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <button onclick="openOpnameModal('{{ $g->Item_ID }}', '{{ $g->Item_Name }}', '{{ $g->Stock_Qty }}')" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs px-3 py-1.5 rounded transition-colors cursor-pointer">
                                        Stock Opname
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-gray-400 font-semibold">Data stok gudang kosong.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ====================================================
     MODAL 1: DIALOG NATIVE TAMBAH BARANG GUDANG BARU 
     ==================================================== -->
<dialog id="modalTambahGudang" class="rounded-xl shadow-xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Bahan Baku Baru</h3>
            <button onclick="document.getElementById('modalTambahGudang').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('gudang.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Item ID</label>
                <input type="text" name="Item_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: RM017" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Item / Bahan Baku</label>
                <input type="text" name="Item_Name" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: Tali Sepatu Biru" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stok Awal</label>
                    <input type="number" name="Stock_Qty" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Satuan Unit</label>
                    <input type="text" name="Unit" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Pasang / Meter / Roll" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Batas Minimal Stock</label>
                    <input type="number" name="Min_Stock" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="100" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga Satuan (Cost)</label>
                    <input type="number" name="Unit_Cost" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Harga beli item" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Supplier ID (Opsional)</label>
                <input type="text" name="Supplier_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Contoh: SUP001">
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahGudang').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Simpan Item
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- ====================================================
     MODAL 2: DIALOG NATIVE STOCK OPNAME (EDIT STOK)
     ==================================================== -->
<dialog id="modalOpname" class="rounded-xl shadow-xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Stock Opname / Sesuaikan Stok</h3>
            <button onclick="document.getElementById('modalOpname').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" id="formOpname" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-500">Nama Item</label>
                <input type="text" id="modalItemNama" class="mt-1 w-full rounded border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-700" readonly>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah Stok Riil Fisik Sekarang</label>
                <input type="number" name="stok_aktual" id="modalStokAktual" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-500" required>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalOpname').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openOpnameModal(id, nama, stok) {
        document.getElementById('formOpname').action = `/gudang/${id}`;
        document.getElementById('modalItemNama').value = nama;
        document.getElementById('modalStokAktual').value = stok;
        document.getElementById('modalOpname').showModal();
    }
</script>
</body>
</html>