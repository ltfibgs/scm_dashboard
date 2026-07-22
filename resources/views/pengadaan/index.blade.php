<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Pengadaan Bahan Baku</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #fbf8fa;
            font-family: 'Inter', sans-serif;
            min-height: max(884px, 100dvh);
        }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#091426",
                        "error": "#ba1a1a",
                        "outline": "#75777d",
                        "secondary-fixed": "#d3e4fe",
                        "on-surface-variant": "#45474c",
                        "surface-tint": "#545f73",
                        "on-surface": "#1b1b1d",
                        "surface-container-low": "#f5f3f4",
                        "on-error-container": "#93000a",
                        "surface-bright": "#fbf8fa",
                        "surface-dim": "#dcd9db",
                        "primary-fixed": "#d8e3fb",
                        "surface-container-high": "#eae7e9",
                        "surface-container": "#f0edef",
                        "secondary-container": "#d0e1fb",
                        "surface": "#fbf8fa",
                        "error-container": "#ffdad6",
                        "on-primary-container": "#8590a6",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#111c2d",
                        "on-secondary-fixed-variant": "#38485d",
                        "on-background": "#1b1b1d",
                        "outline-variant": "#c5c6cd",
                        "background": "#fbf8fa",
                        "primary-container": "#1e293b",
                    },
                    "spacing": {
                        "gutter-mobile": "12px",
                        "margin-mobile": "16px",
                        "lg": "24px",
                        "base": "4px",
                        "xs": "4px",
                        "xl": "32px",
                        "md": "16px",
                        "sm": "8px"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-on-surface antialiased">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'pengadaan'])

    <!-- Main Content Area -->
    <main class="flex-1 p-margin-mobile md:p-lg">
        
        <!-- Flash Alert Message -->
        @if(session('success'))
            <div class="mb-md p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                
                <h2 class="text-3xl font-bold text-primary">Pengadaan Bahan Baku</h2>
                <p class="text-on-surface-variant text-sm mt-1">Kelola kebutuhan barang masuk dan alokasi pemasok terpilih secara efisien.</p>
            </div>
            
            <button onclick="document.getElementById('modalTambahPengadaan').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all shadow-md hover:shadow-indigo-200 active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Tambah Pengadaan Baru
            </button>
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mb-xl">
            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Total Item Pengadaan</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">{{ $pengadaan->count() }} Item</p>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">shopping_bag</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Total Volume Pembelian</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ number_format($pengadaan->sum(fn($i) => $i->{"Jumlah Yg Harus Dibeli"} ?? 0), 0, ',', '.') }} Qty
                    </p>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">storefront</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Pemasok Aktif</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">{{ count($suppliers) }} Supplier</p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Pengadaan -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
            <div class="px-lg py-md border-b border-outline-variant/40 bg-surface-container-low/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">format_list_bulleted</span>
                    <h3 class="text-base font-bold text-primary">Daftar Rencana Pengadaan</h3>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant/30">
                    Real-time Data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                            <th class="py-3.5 px-lg font-bold">No / ID</th>
                            <th class="py-3.5 px-lg font-bold">Bahan Baku</th>
                            <th class="py-3.5 px-lg font-bold">Supplier Terpilih</th>
                            <th class="py-3.5 px-lg font-bold text-right">Jumlah Dibeli</th>
                            <th class="py-3.5 px-lg font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-sm">
                        @forelse($pengadaan as $p)
                            @php
                                $pId = $p->No ?? '-';
                                $pItem = $p->{"Bahan Baku"} ?? '-';
                                $pSupId = $p->{"Supplier Terpilih (WP)"} ?? '-';
                                $pQty = $p->{"Jumlah Yg Harus Dibeli"} ?? 0;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-lg font-bold text-primary">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-xs font-mono font-bold">
                                        #{{ $pId }}
                                    </span>
                                </td>
                                <td class="py-4 px-lg font-semibold text-primary">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        {{ $pItem }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg text-on-surface">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                        <span class="material-symbols-outlined text-[14px]">local_shipping</span>
                                        {{ $pSupId }}
                                    </span>
                                </td>
                                <td class="py-4 px-lg text-right font-bold text-indigo-900">
                                    {{ number_format($pQty, 0, ',', '.') }} <span class="text-xs font-normal text-on-surface-variant">Unit</span>
                                </td>
                                <td class="py-4 px-lg text-center">
                                    <div class="flex items-center justify-center gap-sm">
                                        
                                        <!-- Edit Popover Button & Panel -->
                                        <details class="relative group/popover">
                                            <summary class="list-none cursor-pointer p-1.5 rounded-lg text-indigo-600 hover:bg-indigo-50 transition-colors inline-flex items-center justify-center" title="Edit Data">
                                                <span class="material-symbols-outlined text-[20px]">edit_square</span>
                                            </summary>
                                            
                                            <div class="mt-2 text-left bg-white border border-outline-variant/60 rounded-2xl p-4 absolute right-0 z-30 shadow-xl w-72 backdrop-blur-sm">
                                                <div class="flex justify-between items-center mb-3 pb-2 border-b border-slate-100">
                                                    <h4 class="font-bold text-xs text-primary uppercase tracking-wider">Edit Pengadaan #{{ $pId }}</h4>
                                                </div>
                                                
                                                <form method="POST" action="{{ route('pengadaan.update', $pId) }}" class="space-y-3">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-primary mb-1 uppercase">Supplier</label>
                                                        <select name="Supplier_ID" class="w-full rounded-lg border border-outline-variant px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" required>
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
                                                    </div>

                                                    <div>
                                                        <label class="block text-[11px] font-bold text-primary mb-1 uppercase">Nama Bahan Baku</label>
                                                        <input type="text" name="Item_Nama" value="{{ $pItem }}" class="w-full rounded-lg border border-outline-variant px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" required>
                                                    </div>

                                                    <div>
                                                        <label class="block text-[11px] font-bold text-primary mb-1 uppercase">Jumlah Dibeli</label>
                                                        <input type="number" name="Qty_Masuk" value="{{ $pQty }}" class="w-full rounded-lg border border-outline-variant px-2.5 py-1.5 text-xs focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" required>
                                                    </div>

                                                    <input type="hidden" name="Harga_Beli_Satuan" value="0">
                                                    <input type="hidden" name="Tanggal_Waktu_Transaksi_Masuk" value="{{ now()->format('Y-m-d\TH:i') }}">

                                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-2 rounded-lg transition-colors cursor-pointer mt-1 shadow-sm">
                                                        Simpan Perubahan
                                                    </button>
                                                </form>
                                            </div>
                                        </details>

                                        <!-- Hapus Button -->
                                        <form method="POST" action="{{ route('pengadaan.destroy', $pId) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengadaan ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-error hover:bg-error-container/30 transition-colors inline-flex items-center justify-center cursor-pointer" title="Hapus Data">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">inbox</span>
                                        <p class="font-semibold text-primary">Belum Ada Data Pengadaan</p>
                                        <p class="text-xs text-on-surface-variant mt-0.5">Klik tombol "Tambah Pengadaan Baru" di atas untuk menambahkan data.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Tambah Pengadaan -->
<dialog id="modalTambahPengadaan" class="rounded-2xl shadow-2xl border border-outline-variant/60 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-surface-container-lowest p-lg">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant/40 pb-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">add_box</span>
                <h3 class="text-lg font-bold text-primary">Tambah Data Pengadaan</h3>
            </div>
            <button onclick="document.getElementById('modalTambahPengadaan').close()" class="text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('pengadaan.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">No / ID Pengadaan (Angka)</label>
                <input type="number" name="Pengadaan_ID" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: 15" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Supplier Terpilih</label>
                <select name="Supplier_ID" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" required>
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
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Bahan Baku / Nama Barang</label>
                <input type="text" name="Item_Nama" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: Kulit Sapi Premium" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Jumlah Dibeli (Qty)</label>
                <input type="number" name="Qty_Masuk" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: 500" required>
            </div>

            <input type="hidden" name="Harga_Beli_Satuan" value="0">
            <input type="hidden" name="Tanggal_Waktu_Transaksi_Masuk" value="{{ now()->format('Y-m-d\TH:i') }}">

            <div class="pt-md flex justify-end gap-2 border-t border-outline-variant/40 mt-md">
                <button type="button" onclick="document.getElementById('modalTambahPengadaan').close()" class="px-4 py-2 rounded-xl bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition-colors shadow-md cursor-pointer">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>