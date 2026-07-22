<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Manajemen Produksi</title>
    
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
                        "on-surface-variant": "#45474c",
                        "on-surface": "#1b1b1d",
                        "surface-container-low": "#f5f3f4",
                        "surface-bright": "#fbf8fa",
                        "surface-container-high": "#eae7e9",
                        "surface-container": "#f0edef",
                        "surface": "#fbf8fa",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#c5c6cd",
                        "background": "#fbf8fa",
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
    @include('partials.sidebar', ['active' => 'produksi'])

    <!-- Main Content Area -->
    <main class="flex-1 p-margin-mobile md:p-lg">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-md p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-md p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900 text-xs font-bold uppercase tracking-wider">Divisi Manufaktur</span>
                </div>
                <h2 class="text-3xl font-bold text-primary">Manajemen Produksi</h2>
                <p class="text-on-surface-variant text-sm mt-1">Pantau penggunaan bahan baku, jadwal perakitan, dan penyelesaian produk jadi.</p>
            </div>
            
            <button onclick="document.getElementById('modalTambahProduksi').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-600 text-white rounded-xl font-semibold hover:bg-amber-700 transition-all shadow-md hover:shadow-amber-200 active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">precision_manufacturing</span>
                Mulai Produksi Baru
            </button>
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mb-xl">
            <!-- Dalam Proses -->
            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">pending_actions</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Dalam Proses</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $produksi->where('Status', 'Processing')->count() }} <span class="text-xs font-normal text-on-surface-variant">Jalur</span>
                    </p>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">task_alt</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Selesai Produksi</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $produksi->where('Status', 'Completed')->count() }} <span class="text-xs font-normal text-on-surface-variant">Batch</span>
                    </p>
                </div>
            </div>

            <!-- Antrean Rencana -->
            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">update</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Antrean Perencanaan</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $produksi->where('Status', 'Pending')->count() }} <span class="text-xs font-normal text-on-surface-variant">Rencana</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Monitor Utama -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
            <div class="px-lg py-md border-b border-outline-variant/40 bg-surface-container-low/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">factory</span>
                    <h3 class="text-base font-bold text-primary">Daftar Aktivitas Manufaktur & Produksi</h3>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant/30">
                    Live Production Line
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                            <th class="py-3.5 px-lg font-bold">ID Produksi</th>
                            <th class="py-3.5 px-lg font-bold">Produk Hasil</th>
                            <th class="py-3.5 px-lg font-bold">Bahan Baku (Qty Dipakai)</th>
                            <th class="py-3.5 px-lg font-bold">Hasil Jadi (Qty)</th>
                            <th class="py-3.5 px-lg font-bold">Status</th>
                            <th class="py-3.5 px-lg font-bold text-center">Aksi Penyelesaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-sm">
                        @forelse($produksi as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-lg font-bold text-primary">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-surface-container text-xs font-mono font-bold">
                                        {{ $p->Produksi_ID }}
                                    </span>
                                </td>
                                <td class="py-4 px-lg font-semibold text-primary">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        {{ $p->Nama_Produk_Jadi }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg text-on-surface">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                        <span class="material-symbols-outlined text-[14px]">inventory</span>
                                        {{ $p->Item_Name ?? 'Tidak Diketahui' }}
                                    </span>
                                    <span class="text-xs font-semibold text-amber-700 ml-1">({{ number_format($p->Qty_Bahan_Dipakai, 0, ',', '.') }})</span>
                                </td>
                                <td class="py-4 px-lg font-bold text-slate-800">
                                    @if($p->Qty_Hasil_Jadi)
                                        <span class="text-emerald-700">{{ number_format($p->Qty_Hasil_Jadi, 0, ',', '.') }} Unit</span>
                                    @else
                                        <span class="text-slate-400 font-normal italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-lg">
                                    @if($p->Status === 'Processing')
                                        <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                                            Processing
                                        </span>
                                    @elseif($p->Status === 'Completed')
                                        <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-full border border-emerald-200">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-full border border-slate-200">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-lg text-center">
                                    @if($p->Status !== 'Completed')
                                        <!-- Form penyelesaian cepat -->
                                        <form method="POST" action="{{ route('produksi.complete', $p->Produksi_ID) }}" class="flex items-center justify-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="Qty_Hasil_Jadi" placeholder="Qty Jadi" class="w-24 rounded-lg border border-outline-variant px-2.5 py-1 text-xs focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none" required>
                                            <button type="submit" class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-3 py-1.5 rounded-lg transition-colors cursor-pointer shadow-sm">
                                                <span class="material-symbols-outlined text-[16px]">done</span>
                                                Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-slate-400 text-xs italic">
                                            <span class="material-symbols-outlined text-[16px]">verified</span>
                                            Terpembukuan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">precision_manufacturing</span>
                                        <p class="font-semibold text-primary">Belum Ada Aktivitas Produksi</p>
                                        <p class="text-xs text-on-surface-variant mt-0.5">Tekan tombol "Mulai Produksi Baru" di atas untuk mendaftarkan batch baru.</p>
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

<!-- Modal Tambah Produksi Baru -->
<dialog id="modalTambahProduksi" class="rounded-2xl shadow-2xl border border-outline-variant/60 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-surface-container-lowest p-lg">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant/40 pb-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-600">settings_suggest</span>
                <h3 class="text-lg font-bold text-primary">Rencanakan Produksi Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahProduksi').close()" class="text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('produksi.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kode / ID Produksi</label>
                <input type="text" name="Produksi_ID" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none" placeholder="Contoh: PRD-001" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Pilih Bahan Baku (Dari Gudang)</label>
                <select name="Item_ID" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none" required>
                    <option value="" disabled selected>-- Pilih Bahan Baku Terstok --</option>
                    @foreach($gudang as $g)
                        <option value="{{ $g->Item_ID }}">{{ $g->Item_Name }} (Stok Tersisa: {{ number_format($g->Stock_Qty, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Jumlah Bahan</label>
                    <input type="number" name="Qty_Bahan_Dipakai" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none" placeholder="Qty dipakai" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Status Awal</label>
                    <select name="Status" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none">
                        <option value="Processing">Langsung Proses</option>
                        <option value="Pending">Antrean Jadwal</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Nama Produk Yang Dihasilkan</label>
                <input type="text" name="Nama_Produk_Jadi" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 outline-none" placeholder="Contoh: Sepatu Kulit Hitam Size 41" required>
            </div>

            <div class="pt-md flex justify-end gap-2 border-t border-outline-variant/40 mt-md">
                <button type="button" onclick="document.getElementById('modalTambahProduksi').close()" class="px-4 py-2 rounded-xl bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 text-white font-semibold text-sm hover:bg-amber-700 transition-colors shadow-md cursor-pointer">
                    Mulai Manufaktur
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>