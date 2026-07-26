@extends('layouts.app')

@section('title', 'LogiChain SCM - Manajemen Penjualan')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'penjualan'])

    <!-- Main Content Canvas -->
    <main class="flex-1 w-full min-h-screen p-4 md:p-6 pb-24 md:pb-6 md:ml-64">
        
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
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
                <p class="text-[#091426] text-2xl font-bold mt-1">{{ $penjualan->total() ?? $penjualan->count() }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-emerald-600 bg-emerald-100 p-2 rounded-lg">payments</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Pendapatan</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Total Terbayar (Lunas)</p>
                <p class="text-emerald-600 text-2xl font-bold mt-1">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Lunas')->sum('Total_Price'), 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200/80">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined text-amber-600 bg-amber-100 p-2 rounded-lg">pending_actions</span>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Pending</span>
                </div>
                <p class="text-xs text-[#45474c] font-medium">Piutang (Pending)</p>
                <p class="text-amber-600 text-2xl font-bold mt-1">
                    Rp {{ number_format($penjualan->where('Status_Bayar', 'Pending')->sum('Total_Price'), 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Card Tabel Daftar Penjualan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/80 overflow-hidden flex flex-col">
            
            <!-- Header Tabel, Filter Tab & Search Bar -->
            <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
                
                <!-- FILTER TAB (Semua, Hari Ini, Riwayat Lama) -->
                <div class="flex items-center bg-gray-100 p-1 rounded-xl w-fit">
                    <a href="{{ route('penjualan.index', ['filter' => 'semua']) }}" 
                       class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ request('filter', 'semua') === 'semua' ? 'bg-white text-[#091426] shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                       Semua
                    </a>
                    <a href="{{ route('penjualan.index', ['filter' => 'today']) }}" 
                       class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ request('filter') === 'today' ? 'bg-white text-[#091426] shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                       Hari Ini (Today)
                    </a>
                    <a href="{{ route('penjualan.index', ['filter' => 'history']) }}" 
                       class="px-3.5 py-1.5 text-xs font-bold rounded-lg transition-all {{ request('filter') === 'history' ? 'bg-white text-[#091426] shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                       Riwayat Lama
                    </a>
                </div>
                
                <!-- Pencarian Cepat Real-time -->
                <div class="relative w-full md:w-72">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
                    <input id="searchTable" type="text" class="w-full pl-9 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-[#091426] focus:border-[#091426] outline-none transition-all" placeholder="Cari Order ID, Produk, Kategori..."/>
                </div>
            </div>

            <!-- Area Tabel dengan Scrollbar Custom & Sticky Header -->
            <div class="space-y-4">
                <div class="max-h-[550px] overflow-y-auto overflow-x-auto rounded-xl border border-gray-200/80 shadow-sm bg-white relative custom-scrollbar">
                    <table class="w-full text-left text-xs border-collapse">
                        <!-- HEADER TABEL -->
                        <thead class="sticky top-0 z-10 bg-slate-100 border-b border-gray-200 text-slate-700 font-bold uppercase tracking-wider shadow-sm">
                            <tr>
                                <th class="p-3.5 pl-4 whitespace-nowrap bg-slate-100">Order ID</th>
                                <th class="p-3.5 whitespace-nowrap bg-slate-100">Timestamp</th>
                                <th class="p-3.5 whitespace-nowrap bg-slate-100">Product Name</th>
                                <th class="p-3.5 whitespace-nowrap bg-slate-100">Category</th>
                                <th class="p-3.5 text-center whitespace-nowrap bg-slate-100">Qty</th>
                                <th class="p-3.5 whitespace-nowrap bg-slate-100">Unit Price</th>
                                <th class="p-3.5 whitespace-nowrap bg-slate-100">Total Price</th>
                                <th class="p-3.5 pr-4 whitespace-nowrap bg-slate-100">Payment Method</th>
                            </tr>
                        </thead>

                        <!-- BODY TABEL -->
                        <tbody id="transactionList" class="divide-y divide-gray-100">
                            @forelse($penjualan as $item)
                                @php
                                    // Pengecekan apakah baris ini baru ditambahkan dari Session Flash
                                    $isNew = session('new_order_id') === $item->Order_ID;
                                @endphp
                                <tr class="tr-row transition-colors {{ $isNew ? 'bg-emerald-50/80 font-medium' : 'hover:bg-slate-50/80' }}">
                                    <!-- 1. Order ID -->
                                    <td class="p-3.5 pl-4 font-bold text-[#091426] font-mono whitespace-nowrap flex items-center gap-2">
                                        {{ $item->Order_ID }}
                                        @if($isNew)
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-bold tracking-wide animate-pulse">
                                                BARU
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 2. Timestamp -->
                                    <td class="p-3.5 text-gray-600 font-mono whitespace-nowrap">
                                        {{ $item->Timestamp }}
                                    </td>

                                    <!-- 3. Product Name -->
                                    <td class="p-3.5 font-semibold text-gray-800 whitespace-nowrap">
                                        {{ $item->Product_Name }}
                                    </td>

                                    <!-- 4. Category -->
                                    <td class="p-3.5 text-gray-600 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200/60">
                                            {{ $item->Category ?? 'Sepatu' }}
                                        </span>
                                    </td>

                                    <!-- 5. Qty -->
                                    <td class="p-3.5 text-center font-bold text-gray-700">
                                        {{ $item->Qty }}
                                    </td>

                                    <!-- 6. Unit Price -->
                                    <td class="p-3.5 font-medium text-gray-600 whitespace-nowrap">
                                        Rp {{ number_format($item->Unit_Price, 0, ',', '.') }}
                                    </td>

                                    <!-- 7. Total Price -->
                                    <td class="p-3.5 font-bold text-[#091426] whitespace-nowrap">
                                        Rp {{ number_format($item->Total_Price, 0, ',', '.') }}
                                    </td>

                                    <!-- 8. Payment Method -->
                                    <td class="p-3.5 pr-4 whitespace-nowrap">
                                        @php
                                            $badgeStyle = match(strtoupper($item->Payment_Method ?? '')) {
                                                'QRIS' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'CASH' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                default => 'bg-blue-50 text-blue-700 border-blue-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $badgeStyle }}">
                                            {{ $item->Payment_Method ?? 'CASH' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-400 font-medium">
                                        <span class="material-symbols-outlined text-3xl mb-1 text-gray-300 block">receipt</span>
                                        Belum ada data transaksi penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- FOOTER & PAGINATION -->
                <div class="px-4 py-3 bg-white border border-gray-200/80 rounded-xl shadow-sm flex flex-col md:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-slate-500 font-medium">
                        Menampilkan 
                        <span class="font-bold text-slate-700">{{ method_exists($penjualan, 'firstItem') ? ($penjualan->firstItem() ?? 0) : 1 }}</span> 
                        sampai 
                        <span class="font-bold text-slate-700">{{ method_exists($penjualan, 'lastItem') ? ($penjualan->lastItem() ?? 0) : $penjualan->count() }}</span> 
                        dari 
                        <span class="font-bold text-slate-700">{{ method_exists($penjualan, 'total') ? $penjualan->total() : $penjualan->count() }}</span> total transaksi
                    </div>

                    @if(method_exists($penjualan, 'links'))
                        <div class="text-xs">
                            {{ $penjualan->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-3 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                <span>Diurutkan otomatis dari transaksi **terbaru**</span>
                <span class="font-semibold text-gray-600">Scroll ke bawah untuk melihat riwayat lanjutan ↓</span>
            </div>
        </div>
    </main>
</div>

<!-- MODAL POPUP: FORM PENJUALAN BARU (INTEGRASI ALPINE.JS REAL-TIME) -->
<dialog id="modalTambahPenjualan" class="rounded-2xl shadow-2xl border-0 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6" x-data="penjualanForm()">
        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
            <div>
                <h3 class="text-lg font-bold text-[#091426]">Input Transaksi Penjualan</h3>
                <p class="text-xs text-gray-500">Auto-Generate Order ID & Kalkulasi otomatis</p>
            </div>
            <button onclick="document.getElementById('modalTambahPenjualan').close()" class="text-gray-400 hover:text-black cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('penjualan.store') }}" class="space-y-4">
            @csrf

            <!-- Informasi Auto-Generated Order ID -->
            <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Order ID (Otomatis)</span>
                <span class="text-xs font-mono font-bold text-[#FF6D00] bg-orange-50 px-2 py-1 rounded border border-orange-200">
                    Auto-Generated
                </span>
            </div>

            <!-- Dropdown Integrasi Produk Selesai -->
            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Pilih Produk</label>
                <select name="produksi_id" x-model="selectedProdukId" @change="updateProdukInfo()" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" required>
                    <option value="" disabled selected>-- Pilih Produk dari Stok --</option>
                    @foreach($produkSelesai as $prod)
                        <option value="{{ $prod->Produksi_ID }}" 
                                data-nama="{{ $prod->Nama_Produk_Jadi ?? $prod->nama_produk ?? $prod->Produksi_ID }}"
                                data-kategori="{{ $prod->kategori ?? 'Sepatu' }}" 
                                data-harga="{{ $prod->harga_jual ?? 150000 }}">
                            {{ $prod->Nama_Produk_Jadi ?? $prod->nama_produk ?? $prod->Produksi_ID }} (Stok: {{ $prod->Stok_Tersedia ?? 0 }})
                        </option>
                    @endforeach
                </select>
                <!-- Hidden inputs untuk dikirim ke controller -->
                <input type="hidden" name="Produksi_ID" x-model="selectedProdukId">
                <input type="hidden" name="Product_Name" x-model="namaProduk">
                <input type="hidden" name="Category" x-model="kategori">
            </div>

            <!-- Kategori Auto-Filled -->
            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Kategori</label>
                <input type="text" x-model="kategori" readonly class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-600 focus:outline-none cursor-not-allowed" placeholder="Terisi otomatis...">
            </div>

            <!-- Grid Qty & Harga Satuan -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Jumlah (Qty)</label>
                    <input type="number" name="Qty" x-model.number="qty" min="1" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="1" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Harga Satuan (Rp)</label>
                    <input type="number" name="Unit_Price" x-model.number="hargaSatuan" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" placeholder="150000" required>
                </div>
            </div>

            <!-- Total Pembayaran Real-Time -->
            <div class="p-3 bg-slate-900 text-white rounded-xl flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-300">Total Pembayaran:</span>
                <span class="text-base font-bold text-[#FF6D00]" x-text="formatRupiah(totalBayar)">Rp 0</span>
            </div>

            <!-- Metode Pembayaran -->
            <div>
                <label class="block text-xs font-bold text-[#091426] mb-1 uppercase tracking-wider">Metode Pembayaran</label>
                <select name="Payment_Method" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#091426]" required>
                    <option value="CASH">CASH</option>
                    <option value="QRIS">QRIS</option>
                    <option value="TRANSFER">TRANSFER</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahPenjualan').close()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-semibold text-xs hover:bg-gray-200 cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#FF6D00] text-white font-semibold text-xs hover:brightness-110 cursor-pointer shadow-md">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- SCRIPT ALPINE.JS & SEARCH FILTER -->
<script>
    function penjualanForm() {
        return {
            selectedProdukId: '',
            namaProduk: '',
            kategori: '',
            qty: 1,
            hargaSatuan: 0,
            
            get totalBayar() {
                return (this.qty || 0) * (this.hargaSatuan || 0);
            },
            
            updateProdukInfo() {
                const selectEl = event.target;
                const selectedOption = selectEl.options[selectEl.selectedIndex];
                this.namaProduk = selectedOption.getAttribute('data-nama') || '';
                this.kategori = selectedOption.getAttribute('data-kategori') || 'Sepatu';
                this.hargaSatuan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
            }
        }
    }

    // Filter Pencarian Client-Side Realtime
    document.getElementById('searchTable').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#transactionList .tr-row');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
</script>
@endsection