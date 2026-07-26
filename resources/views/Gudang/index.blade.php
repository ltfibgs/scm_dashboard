<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Stok Gudang</title>
    <!-- Tailwind CSS with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0..1,0&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .filled-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fbf8fa;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .bg-safety-orange { background-color: #FF6D00; }
        .hover\:bg-safety-orange-dark:hover { background-color: #E66200; }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#091426",
                        "error": "#ba1a1a",
                        "outline": "#75777d",
                        "secondary-fixed": "#d3e4fe",
                        "on-surface-variant": "#45474c",
                        "on-surface": "#1b1b1d",
                        "surface-container-low": "#f5f3f4",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#eae7e9",
                        "surface-container": "#f0edef",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "secondary-container": "#d0e1fb",
                        "on-secondary-container": "#54647a",
                        "background": "#fbf8fa",
                        "outline-variant": "#c5c6cd"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background font-sans antialiased text-on-surface min-h-screen">

<div class="min-h-screen flex flex-col md:flex-row w-full">
    <!-- Sidebar -->
    @include('partials.sidebar', ['active' => 'gudang'])

    <!-- Main Content Area (Ditambahkan flex-1, w-full, dan md:pl-72 agar tampilan penuh) -->
    <main class="flex-1 w-full min-h-screen pt-6 pb-24 md:pb-8 md:ml-64">
        <div class="max-w-7xl mx-auto px-4 md:px-6 space-y-6">

            <!-- Notifikasi Session Laravel -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-green-100 border border-green-200 text-green-900 text-sm font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-700">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-error-container border border-error/20 text-on-error-container text-sm space-y-1">
                    <p class="font-bold">Terjadi Kesalahan:</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header Halaman & Action Button -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-primary">Manajemen Gudang</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Kelola inventaris, monitor stok, dan optimalkan penyimpanan.</p>
                </div>
                <button type="button" onclick="document.getElementById('modalTambahGudang').showModal()" class="bg-safety-orange hover:bg-safety-orange-dark text-white px-6 py-3 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 shadow-md active:scale-95 transition-all cursor-pointer">
                    <span class="material-symbols-outlined">add</span>
                    <span>Tambah Barang</span>
                </button>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-outline-variant/30 flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input id="searchInput" type="text" class="w-full pl-12 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm" placeholder="Cari nama barang, ID, atau satuan..."/>
                </div>
                <div class="flex gap-2 overflow-x-auto hide-scrollbar">
                    <button type="button" class="px-4 py-2 border border-outline-variant rounded-lg flex items-center gap-1.5 text-xs font-semibold hover:bg-surface-container cursor-pointer whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span> Filter
                    </button>
                    <button type="button" class="px-4 py-2 border border-outline-variant rounded-lg flex items-center gap-1.5 text-xs font-semibold hover:bg-surface-container cursor-pointer whitespace-nowrap">
                        <span class="material-symbols-outlined text-[18px]">sort</span> Urutkan
                    </button>
                </div>
            </div>

            <!-- Metric Stat Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-primary">
                    <p class="text-xs text-on-surface-variant font-medium">Total Item</p>
                    <p class="text-2xl font-bold text-primary tracking-wide mt-1">{{ count($gudang) }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-error">
                    <p class="text-xs text-on-surface-variant font-medium">Stok Menipis / Kritis</p>
                    <p class="text-2xl font-bold text-error tracking-wide mt-1">
                        {{ $gudang->filter(fn($item) => $item->Stock_Qty < $item->Min_Stock)->count() }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-green-600">
                    <p class="text-xs text-on-surface-variant font-medium">Kondisi Aman</p>
                    <p class="text-2xl font-bold text-green-600 tracking-wide mt-1">
                        {{ $gudang->filter(fn($item) => $item->Stock_Qty >= $item->Min_Stock)->count() }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-amber-500">
                    <p class="text-xs text-on-surface-variant font-medium">Aktivitas Opname</p>
                    <p class="text-2xl font-bold text-amber-500 tracking-wide mt-1">Aktif</p>
                </div>
            </div>

            <!-- Grid Kartu Inventaris Gudang -->
            <div id="itemGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
                
                @forelse($gudang as $g)
                    @php $isKritis = $g->Stock_Qty < $g->Min_Stock; @endphp
                    
                    <div class="item-card group bg-white rounded-xl overflow-hidden shadow-sm border {{ $isKritis ? 'border-error/40 ring-1 ring-error/20' : 'border-outline-variant/30' }} hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Visual Header Card -->
                            <div class="h-32 w-full bg-slate-800 p-4 relative flex flex-col justify-between overflow-hidden">
                                <div class="absolute -right-4 -bottom-4 text-white/5 font-black text-7xl select-none pointer-events-none">
                                    {{ $g->Item_ID }}
                                </div>
                                
                                <div class="flex justify-between items-center z-10">
                                    <span class="bg-white/10 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-md tracking-wider">
                                        ID: {{ $g->Item_ID }}
                                    </span>

                                    @if($isKritis)
                                        <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-error animate-ping"></span> Kritis
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-green-600"></span> Aman
                                        </span>
                                    @endif
                                </div>

                                <div class="z-10">
                                    <h3 class="text-lg font-bold text-white group-hover:text-safety-orange transition-colors truncate" title="{{ $g->Item_Name }}">
                                        {{ $g->Item_Name }}
                                    </h3>
                                    <p class="text-xs text-gray-300">Satuan: <span class="font-semibold">{{ $g->Unit }}</span></p>
                                </div>
                            </div>

                            <!-- Card Detail Body -->
                            <div class="p-5 space-y-4">
                                <div class="flex justify-between items-end border-b border-outline-variant/20 pb-3">
                                    <div>
                                        <p class="text-xs text-on-surface-variant font-medium">Stok Aktual</p>
                                        <p class="text-xl font-bold {{ $isKritis ? 'text-error' : 'text-primary' }}">
                                            {{ number_format($g->Stock_Qty, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">{{ $g->Unit }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-on-surface-variant font-medium">Batas Minimal</p>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ number_format($g->Min_Stock, 0, ',', '.') }} {{ $g->Unit }}
                                        </p>
                                    </div>
                                </div>

                                @if($isKritis)
                                    <div class="bg-error-container/20 p-2.5 rounded-lg text-xs text-on-error-container flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px]">priority_high</span>
                                        <span>Stok berada di bawah ambang batas minimum.</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="p-5 pt-0">
                            <button type="button" onclick="openOpnameModal('{{ addslashes($g->Item_ID) }}', '{{ addslashes($g->Item_Name) }}', '{{ $g->Stock_Qty }}')" class="w-full bg-surface-container-high hover:bg-amber-500 hover:text-white text-primary font-semibold text-xs py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">edit_note</span> Stock Opname
                            </button>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-xl border border-dashed border-outline-variant">
                        <span class="material-symbols-outlined text-4xl text-gray-400">inventory_2</span>
                        <p class="text-gray-500 font-semibold mt-2">Belum ada data persediaan barang.</p>
                    </div>
                @endforelse

                <!-- Add Item Ghost Card -->
                <button type="button" onclick="document.getElementById('modalTambahGudang').showModal()" class="h-full min-h-[260px] border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center gap-3 group hover:bg-surface-container transition-all cursor-pointer">
                    <div class="w-14 h-14 rounded-full bg-surface-container-high flex items-center justify-center group-hover:bg-safety-orange transition-colors">
                        <span class="material-symbols-outlined text-outline group-hover:text-white text-[28px]">add_circle</span>
                    </div>
                    <p class="text-sm font-bold text-on-surface-variant">Tambah Item Baru</p>
                </button>

            </div>
        </div>
    </main>
</div>

<!-- Bottom Nav (Mobile Navigation) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-outline-variant/30 z-50 flex items-center justify-around h-16 px-4">
    <a class="flex flex-col items-center gap-0.5 text-on-surface-variant text-[10px]" href="#">
        <span class="material-symbols-outlined">dashboard</span> Panel
    </a>
    <a class="flex flex-col items-center gap-0.5 text-primary font-bold text-[10px]" href="{{ route('gudang.index') }}">
        <span class="material-symbols-outlined filled-icon">warehouse</span> Gudang
    </a>
    <a class="flex flex-col items-center gap-0.5 text-on-surface-variant text-[10px]" href="#">
        <span class="material-symbols-outlined">local_shipping</span> Kirim
    </a>
</nav>

<!-- Floating Action Button (Mobile) -->
<button type="button" onclick="document.getElementById('modalTambahGudang').showModal()" class="md:hidden fixed bottom-20 right-6 w-14 h-14 bg-safety-orange text-white rounded-full shadow-lg flex items-center justify-center active:scale-90 transition-transform z-40 cursor-pointer">
    <span class="material-symbols-outlined text-[28px]">add</span>
</button>

<!-- MODAL 1: TAMBAH BARANG BARU -->
<dialog id="modalTambahGudang" class="rounded-2xl shadow-2xl border-0 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-primary">Tambah Barang Baru</h3>
            <button type="button" onclick="document.getElementById('modalTambahGudang').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('gudang.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Item ID / SKU</label>
                <input type="text" name="Item_ID" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Contoh: IND-4022-X" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Nama Barang / Bahan Baku</label>
                <input type="text" name="Item_Name" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Contoh: Motor Listrik AC 5HP" required>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Stok Awal</label>
                    <input type="number" name="Stock_Qty" min="0" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Satuan</label>
                    <input type="text" name="Unit" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Unit / Roll / Kg" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Batas Minimal</label>
                    <input type="number" name="Min_Stock" min="0" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="20" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Harga Satuan (Cost)</label>
                    <input type="number" step="0.01" min="0" name="Unit_Cost" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="0" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Supplier ID (Opsional)</label>
                <input type="text" name="Supplier_ID" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none" placeholder="Contoh: SUP-001">
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modalTambahGudang').close()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-safety-orange hover:bg-safety-orange-dark text-white text-xs font-semibold rounded-lg cursor-pointer">Simpan Barang</button>
            </div>
        </form>
    </div>
</dialog>

<!-- MODAL 2: STOCK OPNAME -->
<dialog id="modalOpname" class="rounded-2xl shadow-2xl border-0 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-primary">Stock Opname</h3>
            <button type="button" onclick="document.getElementById('modalOpname').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" id="formOpname" action="" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Barang</label>
                <input type="text" id="modalItemNama" class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-700 outline-none" readonly>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Jumlah Stok Fisik Riil</label>
                <input type="number" min="0" name="stok_aktual" id="modalStokAktual" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-amber-500 outline-none" required>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modalOpname').close()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg cursor-pointer">Simpan Opname</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openOpnameModal(id, nama, stok) {
        document.getElementById('formOpname').action = `/gudang/${encodeURIComponent(id)}`;
        document.getElementById('modalItemNama').value = nama;
        document.getElementById('modalStokAktual').value = stok;
        document.getElementById('modalOpname').showModal();
    }

    document.getElementById('searchInput').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.item-card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(query) ? 'flex' : 'none';
        });
    });
</script>
    
</body>
</html>