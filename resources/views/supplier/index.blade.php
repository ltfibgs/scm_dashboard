<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Manajemen Supplier</title>
    
    <!-- Tailwind CSS v3 / Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: max(884px, 100dvh);
        }
        /* Custom Scrollbar for Table */
        ::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0b1329",
                        "brand-primary": "#f97316", // Orange-600 Accent
                        "outline-variant": "#e2e8f0",
                        "surface-container-low": "#f8fafc",
                        "surface-container-lowest": "#ffffff",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'supplier'])

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 max-w-[1600px] mx-auto w-full">
        
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[11px] font-bold uppercase tracking-wider border border-orange-200/60 flex items-center gap-1.5 w-fit">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Mitra & Pengadaan
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Supplier</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola direktori mitra penyedia bahan baku dan informasi kontak operasional.</p>
            </div>
            
            <button onclick="document.getElementById('modalTambahSupplier').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-bold text-sm transition-all shadow-md shadow-orange-600/20 active:scale-95 cursor-pointer shrink-0">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Tambah Supplier
            </button>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Supplier -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4 transition-all hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">handshake</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Supplier</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">
                        {{ $suppliers->count() }} <span class="text-xs font-semibold text-slate-400">Mitra</span>
                    </p>
                </div>
            </div>

            <!-- Variasi Kategori -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4 transition-all hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">category</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Variasi Kategori</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">
                        {{ $suppliers->pluck('Category')->unique()->count() }} <span class="text-xs font-semibold text-slate-400">Sektor</span>
                    </p>
                </div>
            </div>

            <!-- Jangkauan Kota -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4 transition-all hover:shadow-md">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">location_city</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Jangkauan Kota</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">
                        {{ $suppliers->pluck('City')->unique()->count() }} <span class="text-xs font-semibold text-slate-400">Wilayah</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Supplier -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-600">domain</span>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Partner & Supplier Resmi</h3>
                </div>
                <span class="text-xs font-bold text-orange-700 bg-orange-50 px-3 py-1 rounded-full border border-orange-200/60">
                    Verified Suppliers
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <th class="py-4 px-6 font-bold">ID Supplier</th>
                            <th class="py-4 px-6 font-bold">Nama Perusahaan</th>
                            <th class="py-4 px-6 font-bold">Kategori</th>
                            <th class="py-4 px-6 font-bold">Kontak / Person</th>
                            <th class="py-4 px-6 font-bold">Kota / Lokasi</th>
                            <th class="py-4 px-6 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($suppliers as $s)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-slate-100 text-xs font-mono font-bold text-slate-700 border border-slate-200/60">
                                        {{ $s->Supplier_ID }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-slate-900 group-hover:text-orange-600 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                        {{ $s->Supplier_Name }}
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 text-xs font-semibold border border-orange-200/60">
                                        {{ $s->Category ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-700 font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-slate-400">call</span>
                                        {{ $s->Contact_Person ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-700 font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-slate-400">pin_drop</span>
                                        {{ $s->City ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Modal Trigger -->
                                        <button onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').showModal()" class="inline-flex items-center gap-1 text-orange-600 hover:text-orange-800 font-bold text-xs bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-xl border border-orange-200/60 transition-colors cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                            Edit
                                        </button>

                                        <!-- Form Delete -->
                                        <form method="POST" action="{{ route('supplier.destroy', $s->Supplier_ID) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-800 font-bold text-xs bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl border border-rose-200/60 transition-colors cursor-pointer">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- MODAL EDIT INDIVIDUAL SUPPLIER -->
                                    <dialog id="modalEditSupplier_{{ $s->Supplier_ID }}" class="rounded-3xl shadow-2xl border border-slate-200/80 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm text-left">
                                        <div class="bg-white p-6">
                                            <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-orange-600">edit_square</span>
                                                    <h3 class="text-lg font-extrabold text-slate-900">Edit Supplier: {{ $s->Supplier_ID }}</h3>
                                                </div>
                                                <button onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').close()" class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('supplier.update', $s->Supplier_ID) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Nama Perusahaan</label>
                                                    <input type="text" name="Supplier_Name" value="{{ $s->Supplier_Name }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" required>
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kategori</label>
                                                    <input type="text" name="Category" value="{{ $s->Category }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all">
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kontak / Person</label>
                                                    <input type="text" name="Contact_Person" value="{{ $s->Contact_Person }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all">
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kota / Lokasi</label>
                                                    <input type="text" name="City" value="{{ $s->City }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all">
                                                </div>

                                                <div class="pt-4 flex justify-end gap-2 border-t border-slate-100 mt-6">
                                                    <button type="button" onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').close()" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors cursor-pointer">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs transition-colors shadow-md shadow-orange-600/20 cursor-pointer">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">person_off</span>
                                        <p class="font-bold text-slate-700">Belum Ada Data Supplier</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Klik tombol "Tambah Supplier" untuk mendaftarkan mitra baru.</p>
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

<!-- MODAL TAMBAH SUPPLIER BARU -->
<dialog id="modalTambahSupplier" class="rounded-3xl shadow-2xl border border-slate-200/80 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-600">domain_add</span>
                <h3 class="text-lg font-extrabold text-slate-900">Tambah Supplier Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahSupplier').close()" class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('supplier.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kode / ID Supplier</label>
                <input type="text" name="Supplier_ID" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: SUP-001" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Nama Perusahaan</label>
                <input type="text" name="Supplier_Name" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: PT Sumber Utama" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kategori Supplier</label>
                <input type="text" name="Category" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: Bahan Kulit / Tekstil">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kontak / No. Telepon</label>
                <input type="text" name="Contact_Person" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: 08123456789 (Bpk. Budi)">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kota / Lokasi</label>
                <input type="text" name="City" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: Bandung">
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100 mt-6">
                <button type="button" onclick="document.getElementById('modalTambahSupplier').close()" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs transition-colors shadow-md shadow-orange-600/20 cursor-pointer">
                    Simpan Supplier
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>