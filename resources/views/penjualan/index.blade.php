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
        body { background-color: #fbf8fa; font-family: 'Inter', sans-serif; min-height: 100vh; }
    </style>
</head>
<body class="bg-[#fbf8fa] text-[#1b1b1d]">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'penjualan'])

    <!-- Main Content Canvas (diberi margin md:ml-64 agar tidak tertutup sidebar fixed) -->
    <main class="flex-1  p-4 md:p-6 pb-24 md:pb-6">
        
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
                <h2 class="text-3xl font-bold text-[#091426]">Manajemen Penjualan</h2>
                <p class="text-[#45474c]">Catat transaksi, kelola invoice, dan pantau arus kas masuk.</p>
            </div>
            <button onclick="document.getElementById('modalTambahPenjualan').showModal()" class="flex items-center gap-2 px-4 py-2 bg-[#FF6D00] text-white rounded-lg font-semibold hover:brightness-110 transition-all shadow-md active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                Transaksi Baru
            </button>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-[#091426] bg-blue-100 p-2 rounded-lg">receipt_long</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Total</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Total Transaksi</p>
                <p class="text-[#091426] text-2xl font-bold">{{ $penjualan->count() }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-emerald-600 bg-emerald-100 p-2 rounded-lg">payments</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Pendapatan</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Total Terbayar (Lunas)</p>
                <p class="text-emerald-600 text-2xl font-bold">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Lunas')->sum('Total_Bayar'), 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-amber-600 bg-amber-100 p-2 rounded-lg">pending_actions</span>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Pending</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Piutang (Pending)</p>
                <p class="text-amber-600 text-2xl font-bold">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Pending')->sum('Total_Bayar'), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Tabel Daftar Penjualan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-[#091426]">Riwayat Transaksi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-[#45474c] font-semibold text-xs uppercase tracking-wider">
                            <th class="p-4">ID Transaksi</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Qty</th>
                            <th class="p-4">Total Bayar</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($penjualan as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="p-4 font-bold text-[#091426]">{{ $item->Penjualan_ID }}</td>
                                <td class="p-4 font-medium">{{ $item->Nama_Pelanggan }}</td>
                                <td class="p-4">{{ $item->Qty_Jual }} pcs</td>
                                <td class="p-4 font-semibold text-[#091426]">Rp {{ number_format($item->Total_Bayar, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if($item->Status_Bayar === 'Lunas')
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Lunas</span>
                                    @elseif($item->Status_Bayar === 'Pending')
                                        <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">Pending</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">Batal</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($item->Status_Bayar === 'Pending')
                                        <form method="POST" action="{{ route('penjualan.updateStatus', $item->Penjualan_ID) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="Status_Bayar" value="Lunas">
                                            <button type="submit" class="text-xs px-3 py-1 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700 cursor-pointer">
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
                                    Belum ada data transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- MODAL POPUP: FORM BUAT PENJUALAN BARU -->
<dialog id="modalTambahPenjualan" class="rounded-2xl shadow-2xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-bold text-[#091426]">Input Transaksi Penjualan</h3>
            <button onclick="document.getElementById('modalTambahPenjualan').close()" class="text-gray-400 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('penjualan.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">No. Nota / ID Penjualan</label>
                <input type="text" name="Penjualan_ID" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-[#091426]" placeholder="Contoh: TRX-2026-001" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Nama Pelanggan</label>
                <input type="text" name="Nama_Pelanggan" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-[#091426]" placeholder="PT Jaya Bersama" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Pilih Produk</label>
                <select name="Produksi_ID" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-[#091426]" required>
                    <option value="" disabled selected>-- Pilih Produk --</option>
                    @foreach($produkSelesai as $prod)
                        <option value="{{ $prod->Produksi_ID }}">{{ $prod->Nama_Produk_Jadi ?? $prod->Produksi_ID }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Jumlah (Qty)</label>
                    <input type="number" name="Qty_Jual" min="1" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-[#091426]" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Harga Satuan (Rp)</label>
                    <input type="number" name="Harga_Satuan" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-[#091426]" placeholder="150000" required>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t mt-4">
                <button type="button" onclick="document.getElementById('modalTambahPenjualan').close()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-semibold text-sm hover:bg-gray-200 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#FF6D00] text-white font-semibold text-sm hover:brightness-110 cursor-pointer">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>