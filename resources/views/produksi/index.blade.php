<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produksi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    @include('partials.sidebar', ['active' => 'produksi'])

    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Produksi</h2>
            <span class="text-sm bg-orange-100 text-orange-800 font-medium px-3 py-1 rounded-full">Divisi Produksi / Pabrik</span>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800 text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <!-- METRIK STATISTIK PRODUKSI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-amber-100 rounded-lg text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Dalam Proses</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $produksi->where('Status', 'Processing')->count() }} Jalur</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-emerald-100 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Selesai Bulan Ini</p>
                        <h4 class="text-2xl font-bold text-emerald-600">{{ $produksi->where('Status', 'Completed')->count() }} Batch</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-lg text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v6a2 2 0 012-2m14-8V7a2 2 0 00-2-2H5a2 2 0 00-2 2v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Antrean Rencana</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $produksi->where('Status', 'Pending')->count() }} Perencanaan</h4>
                    </div>
                </div>
            </div>

            <!-- TABEL MONITOR UTAMA -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Aktivitas Manufaktur & Produksi</h3>
                    
                    <button onclick="document.getElementById('modalTambahProduksi').showModal()" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Mulai Produksi Baru
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                            <th class="py-3 px-6 font-semibold">ID Produksi</th>
                            <th class="py-3 px-6 font-semibold">Produk Hasil</th>
                            <th class="py-3 px-6 font-semibold">Bahan Baku (Qty)</th>
                            <th class="py-3 px-6 font-semibold">Hasil Jadi (Qty)</th>
                            <th class="py-3 px-6 font-semibold">Status</th>
                            <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($produksi as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-6 font-medium text-gray-600">{{ $p->Produksi_ID }}</td>
                                <td class="py-3 px-6 text-gray-900 font-bold">{{ $p->Nama_Produk_Jadi }}</td>
                                <td class="py-3 px-6 text-gray-700">
                                    {{ $p->Item_Name ?? 'Tidak Diketahui' }} <span class="text-gray-400">({{ $p->Qty_Bahan_Dipakai }})</span>
                                </td>
                                <td class="py-3 px-6 text-gray-800 font-semibold">{{ $p->Qty_Hasil_Jadi ?? '-' }}</td>
                                <td class="py-3 px-6">
                                    @if($p->Status === 'Processing')
                                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full">Processing</span>
                                    @elseif($p->Status === 'Completed')
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">Completed</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($p->Status !== 'Completed')
                                        <!-- Form cepat selesaikan produksi -->
                                        <form method="POST" action="{{ route('produksi.complete', $p->Produksi_ID) }}" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="Qty_Hasil_Jadi" placeholder="Hasil Jadi" class="border rounded px-2 py-1 text-xs w-24 mr-2" required>
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold text-xs px-2.5 py-1 rounded cursor-pointer">
                                                Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Selesai & Terpembukuan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-400 font-semibold">Belum ada riwayat aktivitas produksi aktif.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- MODAL POPUP: FORM MULAI PRODUKSI BARU -->
<dialog id="modalTambahProduksi" class="rounded-xl shadow-xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rencanakan Produksi Baru</h3>
            <button onclick="document.getElementById('modalTambahProduksi').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('produksi.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Produksi</label>
                <input type="text" name="Produksi_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500" placeholder="Contoh: PRD-001" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Pilih Bahan Baku (Dari Gudang)</label>
                <select name="Item_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500" required>
                    <option value="" disabled selected>-- Pilih Bahan Baku Terstok --</option>
                    @foreach($gudang as $g)
                        <option value="{{ $g->Item_ID }}">{{ $g->Item_Name }} (Stok Tersisa: {{ $g->Stock_Qty }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah Bahan Digunakan</label>
                    <input type="number" name="Qty_Bahan_Dipakai" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500" placeholder="Berapa meter/unit" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Awal</label>
                    <select name="Status" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500">
                        <option value="Processing">Langsung Proses</option>
                        <option value="Pending">Antrean Jadwal</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Produk Yang Akan Dihasilkan</label>
                <input type="text" name="Nama_Produk_Jadi" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500" placeholder="Contoh: Sepatu Kulit Hitam Size 41" required>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahProduksi').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Mulai Manufaktur
                </button>
            </div>
        </form>
    </div>
</dialog>
</body>
</html>