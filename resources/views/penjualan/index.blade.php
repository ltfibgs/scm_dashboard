<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LogiChain SCM - Manajemen Penjualan</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #fbf8fa; font-family: 'Inter', sans-serif; }
        /* Custom Scrollbar untuk area tabel */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c5c6cd; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9e9fa6; }
    </style>
</head>
<body class="bg-[#fbf8fa] text-[#1b1b1d]">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'penjualan'])

    <!-- Main Content Canvas -->
    <main class="flex-1 w-full min-h-screen p-4 md:p-6 pb-24 md:pb-6 ">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#091426]">Manajemen Penjualan</h2>
                <p class="text-sm text-[#45474c] mt-1">Catat transaksi, kelola invoice, dan pantau arus kas masuk.</p>
            </div>
            <button onclick="document.getElementById('modalTambahPenjualan').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-[#FF6D00] text-white rounded-xl font-semibold text-sm hover:brightness-110 transition-all shadow-md active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                Transaksi Baru
            </button>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-[#091426] bg-blue-100 p-2 rounded-lg">receipt_long</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Total</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Total Transaksi</p>
                <p class="text-[#091426] text-2xl font-bold mt-1">{{ $penjualan->count() }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-emerald-600 bg-emerald-100 p-2 rounded-lg">payments</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Pendapatan</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Total Terbayar (Lunas)</p>
                <p class="text-emerald-600 text-2xl font-bold mt-1">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Lunas')->sum('Total_Bayar'), 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-amber-600 bg-amber-100 p-2 rounded-lg">pending_actions</span>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Pending</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Piutang (Pending)</p>
                <p class="text-amber-600 text-2xl font-bold mt-1">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Pending')->sum('Total_Bayar'), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Card Tabel Daftar Penjualan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/80 overflow-hidden flex flex-col">
            
            <!-- Header Tabel & Search Filter -->
            <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#091426]">history</span>
                    <h3 class="text-base font-bold text-[#091426]">Riwayat Transaksi</h3>
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-semibold">{{ $penjualan->count() }}</span>
                </div>
                
                <!-- Pencarian Cepat -->
                <div class="relative w-full sm:w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input id="searchTable" type="text" class="w-full pl-9 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#091426] focus:border-[#091426] outline-none transition-all" placeholder="Cari ID atau pelanggan..."/>
                </div>
            </div>

            <!-- Area Tabel dengan Batas Tinggi & Scroll Internal (Max-Height) -->
            <div class="overflow-x-auto max-h-[420px] custom-scrollbar">
                <table class="w-full text-left border-collapse text-xs">
                    <thead class="sticky top-0 bg-gray-50/95 backdrop-blur-sm z-10 shadow-sm">
                        <tr class="text-[#45474c] font-bold uppercase tracking-wider border-b border-gray-200/60">
                            <th class="p-3.5 pl-4">ID Transaksi</th>
                            <th class="p-3.5">Pelanggan</th>
                            <th class="p-3.5 text-center">Qty</th>
                            <th class="p-3.5">Total Bayar</th>
                            <th class="p-3.5">Status</th>
                            <th class="p-3.5 pr-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transactionList" class="divide-y divide-gray-100">
                        @forelse($penjualan as $item)
                            <tr class="tr-row hover:bg-slate-50/80 transition-colors">
                                <td class="p-3.5 pl-4 font-bold text-[#091426] font-mono whitespace-nowrap">{{ $item->Penjualan_ID }}</td>
                                <td class="p-3.5 font-semibold text-gray-700 whitespace-nowrap">{{ $item->Nama_Pelanggan }}</td>
                                <td class="p-3.5 text-center font-medium text-gray-600">{{ $item->Qty_Jual }} pcs</td>
                                <td class="p-3.5 font-bold text-[#091426] whitespace-nowrap">Rp {{ number_format($item->Total_Bayar, 0, ',', '.') }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($item->Status_Bayar === 'Lunas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lunas
                                        </span>
                                    @elseif($item->Status_Bayar === 'Pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 pr-4 text-center whitespace-nowrap">
                                    @if($item->Status_Bayar === 'Pending')
                                        <form method="POST" action="{{ route('penjualan.updateStatus', $item->Penjualan_ID) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="Status_Bayar" value="Lunas">
                                            <button type="submit" class="text-[11px] px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold shadow-sm transition-all cursor-pointer">
                                                Tandai Lunas
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-medium">
                                    <span class="material-symbols-outlined text-3xl mb-1 text-gray-300 block">receipt</span>
                                    Belum ada data transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Tabel Tambahan -->
            <div class="p-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                <span>Menampilkan transaksi terbaru</span>
                <span class="font-semibold text-gray-600">Scroll ke bawah untuk melihat transaksi lainnya ↓</span>
            </div>
        </div>
    </main>
</div>

<!-- MODAL POPUP: FORM BUAT PENJUALAN BARU -->
<dialog id="modalTambahPenjualan" class="rounded-2xl shadow-2xl border-0 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
            <h3 class="text-lg font-bold text-[#091426]">Input Transaksi Penjualan</h3>
            <button onclick="document.getElementById('modalTambahPenjualan').close()" class="text-gray-400 hover:text-black cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('penjualan.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">No. Nota / ID Penjualan</label>
                <input type="text" name="Penjualan_ID" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="Contoh: TRX-2026-001" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Nama Pelanggan</label>
                <input type="text" name="Nama_Pelanggan" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="PT Jaya Bersama" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Pilih Produk</label>
                <select name="Produksi_ID" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" required>
                    <option value="" disabled selected>-- Pilih Produk --</option>
                    @foreach($produkSelesai as $prod)
                        <option value="{{ $prod->Produksi_ID }}">{{ $prod->Nama_Produk_Jadi ?? $prod->Produksi_ID }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Jumlah (Qty)</label>
                    <input type="number" name="Qty_Jual" min="1" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Harga Satuan (Rp)</label>
                    <input type="number" name="Harga_Satuan" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="150000" required>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahPenjualan').close()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-semibold text-xs hover:bg-gray-200 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#FF6D00] text-white font-semibold text-xs hover:brightness-110 cursor-pointer">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- JavaScript Filter Pencarian Sederhana -->
<script>
    document.getElementById('searchTable').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#transactionList .tr-row');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
</script>

</body>
</html>