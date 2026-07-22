<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Manajemen Supplier</title>
    
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
    @include('partials.sidebar', ['active' => 'supplier'])

    <!-- Main Content Area -->
    <main class="flex-1 p-margin-mobile md:p-lg">
        
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-md p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
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
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-900 text-xs font-bold uppercase tracking-wider">Mitra & Pengadaan</span>
                </div>
                <h2 class="text-3xl font-bold text-primary">Manajemen Supplier</h2>
                <p class="text-on-surface-variant text-sm mt-1">Kelola direktori mitra penyedia bahan baku dan informasi kontak operasional.</p>
            </div>
            
            <button onclick="document.getElementById('modalTambahSupplier').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all shadow-md hover:shadow-indigo-200 active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Tambah Supplier
            </button>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mb-xl">
            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">handshake</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Total Supplier</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $suppliers->count() }} <span class="text-xs font-normal text-on-surface-variant">Mitra</span>
                    </p>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">category</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Variasi Kategori</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $suppliers->pluck('Category')->unique()->count() }} <span class="text-xs font-normal text-on-surface-variant">Sektor</span>
                    </p>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-2xl shadow-sm border border-outline-variant/50 flex items-center gap-md">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">location_city</span>
                </div>
                <div>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-wider">Jangkauan Kota</p>
                    <p class="text-primary text-2xl font-extrabold mt-0.5">
                        {{ $suppliers->pluck('City')->unique()->count() }} <span class="text-xs font-normal text-on-surface-variant">Wilayah</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Supplier -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
            <div class="px-lg py-md border-b border-outline-variant/40 bg-surface-container-low/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">domain</span>
                    <h3 class="text-base font-bold text-primary">Daftar Partner & Supplier Resmi</h3>
                </div>
                <span class="text-xs font-semibold text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant/30">
                    Verified Suppliers
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                            <th class="py-3.5 px-lg font-bold">ID Supplier</th>
                            <th class="py-3.5 px-lg font-bold">Nama Perusahaan</th>
                            <th class="py-3.5 px-lg font-bold">Kategori</th>
                            <th class="py-3.5 px-lg font-bold">Kontak / Person</th>
                            <th class="py-3.5 px-lg font-bold">Kota / Lokasi</th>
                            <th class="py-3.5 px-lg font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-sm">
                        @forelse($suppliers as $s)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-lg font-bold text-primary">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-surface-container text-xs font-mono font-bold">
                                        {{ $s->Supplier_ID }}
                                    </span>
                                </td>
                                <td class="py-4 px-lg font-bold text-primary">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        {{ $s->Supplier_Name }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200">
                                        {{ $s->Category ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-4 px-lg text-on-surface font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-outline">call</span>
                                        {{ $s->Contact_Person ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg text-on-surface font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-outline">pin_drop</span>
                                        {{ $s->City ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Modal Trigger -->
                                        <button onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').showModal()" class="inline-flex items-center gap-1 text-indigo-700 hover:text-indigo-900 font-bold text-xs bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                            Edit
                                        </button>

                                        <!-- Form Delete -->
                                        <form method="POST" action="{{ route('supplier.destroy', $s->Supplier_ID) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-rose-700 hover:text-rose-900 font-bold text-xs bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- MODAL EDIT INDIVIDUAL SUPPLIER -->
                                    <dialog id="modalEditSupplier_{{ $s->Supplier_ID }}" class="rounded-2xl shadow-2xl border border-outline-variant/60 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm text-left">
                                        <div class="bg-surface-container-lowest p-lg">
                                            <div class="flex justify-between items-center mb-md border-b border-outline-variant/40 pb-sm">
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-indigo-600">edit_square</span>
                                                    <h3 class="text-lg font-bold text-primary">Edit Supplier: {{ $s->Supplier_ID }}</h3>
                                                </div>
                                                <button onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').close()" class="text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>

                                            <form method="POST" action="{{ route('supplier.update', $s->Supplier_ID) }}" class="space-y-4">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div>
                                                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Nama Perusahaan</label>
                                                    <input type="text" name="Supplier_Name" value="{{ $s->Supplier_Name }}" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" required>
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kategori</label>
                                                    <input type="text" name="Category" value="{{ $s->Category }}" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kontak / Person</label>
                                                    <input type="text" name="Contact_Person" value="{{ $s->Contact_Person }}" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                                                </div>

                                                <div>
                                                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kota / Lokasi</label>
                                                    <input type="text" name="City" value="{{ $s->City }}" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                                                </div>

                                                <div class="pt-md flex justify-end gap-2 border-t border-outline-variant/40 mt-md">
                                                    <button type="button" onclick="document.getElementById('modalEditSupplier_{{ $s->Supplier_ID }}').close()" class="px-4 py-2 rounded-xl bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors cursor-pointer">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition-colors shadow-md cursor-pointer">
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
                                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">person_off</span>
                                        <p class="font-semibold text-primary">Belum Ada Data Supplier</p>
                                        <p class="text-xs text-on-surface-variant mt-0.5">Klik tombol "Tambah Supplier" untuk mendaftarkan mitra baru.</p>
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
<dialog id="modalTambahSupplier" class="rounded-2xl shadow-2xl border border-outline-variant/60 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-surface-container-lowest p-lg">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant/40 pb-sm">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">domain_add</span>
                <h3 class="text-lg font-bold text-primary">Tambah Supplier Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahSupplier').close()" class="text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('supplier.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kode / ID Supplier</label>
                <input type="text" name="Supplier_ID" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: SUP-001" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Nama Perusahaan</label>
                <input type="text" name="Supplier_Name" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: PT Sumber Utama" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kategori Supplier</label>
                <input type="text" name="Category" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: Bahan Tekstil / Elektronik">
            </div>
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kontak / No. Telepon</label>
                <input type="text" name="Contact_Person" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: 08123456789 (Bpk. Budi)">
            </div>
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kota / Lokasi</label>
                <input type="text" name="City" class="w-full rounded-xl border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none" placeholder="Contoh: Bandung">
            </div>

            <div class="pt-md flex justify-end gap-2 border-t border-outline-variant/40 mt-md">
                <button type="button" onclick="document.getElementById('modalTambahSupplier').close()" class="px-4 py-2 rounded-xl bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-700 transition-colors shadow-md cursor-pointer">
                    Simpan Supplier
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>