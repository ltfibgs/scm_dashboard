<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LogiChain SCM - Status Pengiriman</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- LEAFLET MAPS CSS & JS (Open Source Maps) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .status-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        body {
            background-color: #fbf8fa;
            font-family: 'Inter', sans-serif;
            min-height: max(884px, 100dvh);
        }
        #map {
            height: 380px;
            width: 100%;
            border-radius: 0.75rem;
            z-index: 10;
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
                        "on-tertiary-fixed": "#271902",
                        "on-surface": "#1b1b1d",
                        "tertiary-fixed": "#fadfb8",
                        "surface-container-low": "#f5f3f4",
                        "on-error-container": "#93000a",
                        "surface-bright": "#fbf8fa",
                        "tertiary-container": "#35260c",
                        "tertiary": "#1e1200",
                        "surface-dim": "#dcd9db",
                        "primary-fixed": "#d8e3fb",
                        "surface-container-high": "#eae7e9",
                        "surface-container": "#f0edef",
                        "tertiary-fixed-dim": "#ddc39d",
                        "secondary-container": "#d0e1fb",
                        "surface": "#fbf8fa",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-primary-container": "#8590a6",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed": "#111c2d",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#38485d",
                        "on-background": "#1b1b1d",
                        "inverse-primary": "#bcc7de",
                        "on-secondary-fixed": "#0b1c30",
                        "on-tertiary-container": "#a38c6a",
                        "surface-variant": "#e4e2e3",
                        "outline-variant": "#c5c6cd",
                        "on-primary": "#ffffff",
                        "surface-container-highest": "#e4e2e3",
                        "on-secondary": "#ffffff",
                        "inverse-surface": "#303032",
                        "inverse-on-surface": "#f3f0f2",
                        "on-tertiary-fixed-variant": "#564427",
                        "on-primary-fixed-variant": "#3c475a",
                        "secondary": "#505f76",
                        "secondary-fixed-dim": "#b7c8e1",
                        "primary-fixed-dim": "#bcc7de",
                        "background": "#fbf8fa",
                        "primary-container": "#1e293b",
                        "on-secondary-container": "#54647a"
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
<body class="bg-background text-on-surface">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'pengiriman'])

    <!-- Main Content Canvas -->
    <main class="flex-1 p-margin-mobile md:p-lg md:ml-64">
        
        <!-- Flash Message Alerts -->
        @if(session('success'))
            <div class="mb-md p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-sm">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-md p-4 rounded-xl bg-error-container border border-error/20 text-on-error-container text-sm font-semibold flex items-center gap-sm">
                <span class="material-symbols-outlined">error</span>
                {{ session('error') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <h2 class="text-3xl font-bold text-primary">Status Pengiriman</h2>
                <p class="text-on-surface-variant">Pantau pergerakan logistik real-time dan optimasi rute terpendek (TSP).</p>
            </div>
            <div class="flex flex-wrap gap-sm">
                <!-- Tombol Optimasi Rute TSP -->
                <button onclick="hitungRuteTSP()" class="flex items-center gap-sm px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all shadow-md active:scale-95 cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">map</span>
                    Optimasi Rute & Map TSP
                </button>

                <button onclick="document.getElementById('modalTambahPengiriman').showModal()" class="flex items-center gap-sm px-4 py-2 bg-[#FF6D00] text-white rounded-lg font-semibold hover:brightness-110 transition-all shadow-md active:scale-95 cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Pengiriman Baru
                </button>
            </div>
        </div>

        <!-- Dashboard Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-md mb-xl">
            <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/50">
                <div class="flex items-center justify-between mb-sm">
                    <span class="material-symbols-outlined text-primary bg-primary-fixed p-2 rounded-lg">local_shipping</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">+12%</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">Total Aktif</p>
                <p class="text-primary text-2xl font-bold">{{ $pengiriman->count() }}</p>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/50">
                <div class="flex items-center justify-between mb-sm">
                    <span class="material-symbols-outlined text-secondary bg-secondary-fixed p-2 rounded-lg">schedule</span>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Proses</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">Dalam Transit</p>
                <p class="text-primary text-2xl font-bold">{{ $pengiriman->where('Status_Kirim', 'Dalam Pengiriman')->count() }}</p>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/50">
                <div class="flex items-center justify-between mb-sm">
                    <span class="material-symbols-outlined text-error bg-error-container p-2 rounded-lg">warning</span>
                    <span class="text-xs font-bold text-error bg-error-container/20 px-2 py-1 rounded-full">Perhatian</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">Terhambat / Delay</p>
                <p class="text-primary text-2xl font-bold">{{ $pengiriman->where('Status_Kirim', 'Terhambat')->count() }}</p>
            </div>

            <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/50">
                <div class="flex items-center justify-between mb-sm">
                    <span class="material-symbols-outlined text-primary bg-secondary-container p-2 rounded-lg">task_alt</span>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Selesai</span>
                </div>
                <p class="text-on-surface-variant text-xs font-medium">Terkirim</p>
                <p class="text-primary text-2xl font-bold">{{ $pengiriman->where('Status_Kirim', 'Selesai')->count() }}</p>
            </div>
        </div>

        <!-- CONTAINER POPUP REKOMENDASI RUTE & INTEGRASI MAPS TSP -->
        <div id="sectionRuteTSP" class="hidden mb-xl p-lg bg-surface-container-lowest rounded-2xl border-2 border-emerald-500 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-sm">
                    <span class="material-symbols-outlined text-emerald-600 text-3xl">alt_route</span>
                    <div>
                        <h3 class="text-lg font-bold text-primary">Peta Rute & Detail Jarak Pengiriman (TSP Nearest Neighbor)</h3>
                        <p class="text-xs text-on-surface-variant">Menampilkan rute efisien beserta detail akumulasi dan jarak tiap segmen perjalanan.</p>
                    </div>
                </div>
                <button onclick="document.getElementById('sectionRuteTSP').classList.add('hidden')" class="text-on-surface-variant hover:text-primary">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Total Distance Metrics -->
            <div id="distanceBadge" class="mb-4 inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2 rounded-xl text-sm font-bold shadow-sm">
                <span class="material-symbols-outlined text-[20px]">straighten</span> Total Jarak Tempuh Rute: <span id="totalDistanceVal" class="text-emerald-700 font-extrabold text-base">0 KM</span>
            </div>
            
            <!-- Map Container -->
            <div id="map" class="mb-4 shadow-md border border-slate-200"></div>

            <!-- Rute Steps Visualizer -->
            <div id="hasilTSP" class="space-y-3 pt-2 border-t border-slate-200">
                <!-- Urutan Rute TSP akan digenerate otomatis oleh Javascript -->
            </div>
        </div>

        <!-- Active Tracking List -->
        <div class="space-y-md">
            <h3 class="text-xl font-semibold text-primary mb-md">Daftar Pengiriman</h3>

            @forelse($pengiriman as $p)
                <!-- Tracking Card -->
                <div class="card-pengiriman bg-white p-md md:p-lg rounded-xl shadow-sm border-l-4 {{ $p->Status_Kirim === 'Selesai' ? 'border-emerald-500' : ($p->Status_Kirim === 'Terhambat' ? 'border-error' : 'border-primary') }} hover:shadow-md transition-shadow group">
                    <div class="flex flex-col md:flex-row justify-between gap-md mb-lg">
                        <div class="flex gap-md">
                            <div class="w-12 h-12 rounded-lg {{ $p->Status_Kirim === 'Selesai' ? 'bg-emerald-50 text-emerald-600' : ($p->Status_Kirim === 'Terhambat' ? 'bg-error-container/20 text-error' : 'bg-surface-container text-primary') }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-[32px]">local_shipping</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-sm flex-wrap">
                                    <span class="font-bold text-primary">{{ $p->Pengiriman_ID }}</span>
                                    
                                    @if($p->Status_Kirim === 'Selesai')
                                        <span class="px-2 py-1 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase">Selesai</span>
                                    @elseif($p->Status_Kirim === 'Terhambat')
                                        <span class="px-2 py-1 rounded-md bg-error-container text-on-error-container text-[10px] font-bold uppercase">Terhambat</span>
                                    @else
                                        <span class="px-2 py-1 rounded-md bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase">Transit</span>
                                    @endif

                                    <!-- BADGE JARAK DARI GUDANG UTAMA -->
                                    <span class="badge-jarak-card inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-slate-700 text-[11px] font-bold">
                                        <span class="material-symbols-outlined text-[14px] text-emerald-600">straighten</span>
                                        <span class="val-jarak">Hitung jarak...</span>
                                    </span>
                                </div>
                                <!-- DIUBAH: Menampilkan Jenis Sepatu dan Order ID dari Relasi Penjualan -->
                                <p class="text-on-surface-variant text-sm mt-0.5">
                                    {{ $p->penjualan->Jenis_Sepatu ?? 'Order #' . $p->Order_ID }} (Qty: {{ $p->Qty_Kirim }})
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-xl">
                            <div class="text-right">
                                <p class="text-on-surface-variant text-[12px] font-bold uppercase tracking-wider">Kurir / Hub</p>
                                <p class="text-sm font-semibold text-primary">{{ $p->Kurir ?? 'Internal Logistik' }}</p>
                            </div>
                            <span class="material-symbols-outlined text-outline">trending_flat</span>
                            <div class="text-left">
                                <p class="text-on-surface-variant text-[12px] font-bold uppercase tracking-wider">Tujuan</p>
                                <p class="text-sm font-semibold text-primary item-tujuan">{{ $p->Tujuan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Progress & Action -->
                    <div class="space-y-sm">
                        <div class="flex justify-between text-[12px] font-semibold">
                            <span class="text-primary">Status Waktu: Real-Time</span>
                            <span class="{{ $p->Status_Kirim === 'Selesai' ? 'text-emerald-600' : 'text-on-surface-variant' }}">
                                {{ $p->Status_Kirim === 'Selesai' ? 'Barang Telah Diterima' : 'Dalam Proses Distribusi' }}
                            </span>
                        </div>

                        <div class="relative w-full h-2 bg-surface-container rounded-full overflow-hidden">
                            <div class="absolute top-0 left-0 h-full {{ $p->Status_Kirim === 'Selesai' ? 'bg-emerald-500' : ($p->Status_Kirim === 'Terhambat' ? 'bg-error' : 'bg-[#FF6D00]') }} transition-all duration-1000" style="width: {{ $p->Status_Kirim === 'Selesai' ? '100%' : ($p->Status_Kirim === 'Terhambat' ? '35%' : '65%') }};"></div>
                        </div>

                        <div class="flex justify-between items-center mt-2 pt-1">
                            <p class="text-sm text-on-surface-variant flex items-center gap-xs">
                                <span class="w-2 h-2 rounded-full {{ $p->Status_Kirim === 'Selesai' ? 'bg-emerald-500' : 'bg-amber-500 status-pulse' }}"></span>
                                Target Alamat: <span class="font-medium text-primary">{{ $p->Tujuan }}</span>
                            </p>

                            @if($p->Status_Kirim !== 'Selesai')
                                <form method="POST" action="{{ route('pengiriman.updateStatus', $p->Pengiriman_ID) }}" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="Status_Kirim" value="Selesai">
                                    <button type="submit" class="text-emerald-600 font-semibold text-sm flex items-center gap-xs hover:underline cursor-pointer">
                                        Selesaikan Pengiriman <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    </button>
                                </form>
                            @else
                                <span class="text-emerald-600 font-bold text-xs flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-[16px]">task_alt</span> Sampai Tujuan
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-xl border border-outline-variant text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">local_shipping</span>
                    <p class="font-medium">Belum ada data pengiriman barang.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>

<!-- MODAL POPUP: FORM BUAT PENGIRIMAN BARU -->
<dialog id="modalTambahPengiriman" class="rounded-2xl shadow-2xl border border-outline-variant p-0 w-full max-w-md backdrop:bg-black/50">
    <div class="bg-surface-container-lowest p-lg">
        <div class="flex justify-between items-center mb-md border-b border-outline-variant/50 pb-sm">
            <h3 class="text-lg font-bold text-primary">Pengiriman Baru</h3>
            <button onclick="document.getElementById('modalTambahPengiriman').close()" class="text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('pengiriman.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Kode Pengiriman (ID)</label>
                <input type="text" name="Pengiriman_ID" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:outline-none focus:border-primary" placeholder="Contoh: TRK-882910-ID" required>
            </div>

            <!-- DIUBAH: Menggunakan Order ID dari Penjualan Sepatu -->
            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Pilih Order Penjualan Sepatu</label>
                <select name="Order_ID" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:outline-none focus:border-primary" required>
                    <option value="" disabled selected>-- Pilih Order Penjualan --</option>
                    
                    {{-- Mengurutkan koleksi berdasarkan kolom Timestamp dari yang terbaru --}}
                    @foreach($penjualanSiapKirim->sortByDesc('Timestamp') as $penjualan)
                        <option value="{{ $penjualan->Order_ID }}">
                            Order #{{ $penjualan->Order_ID }} - {{ $penjualan->Product_Name ?? $penjualan->Jenis_Sepatu }} (Qty: {{ $penjualan->Qty ?? $penjualan->Jumlah_Terjual }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Tujuan / Alamat Pengiriman</label>
                <input type="text" name="Tujuan" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:outline-none focus:border-primary" placeholder="Contoh: Bandung, Surabaya, Semarang" required>
            </div>

            <div class="grid grid-cols-2 gap-md">
                <div>
                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Jumlah (Qty)</label>
                    <input type="number" name="Qty_Kirim" min="1" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:outline-none focus:border-primary" placeholder="0" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-primary mb-1 uppercase tracking-wider">Ekspedisi / Kurir</label>
                    <input type="text" name="Kurir" class="w-full rounded-lg border border-outline-variant px-3 py-2 text-sm focus:outline-none focus:border-primary" placeholder="JNE / Express">
                </div>
            </div>

            <div class="pt-md flex justify-end gap-sm border-t border-outline-variant/50 mt-md">
                <button type="button" onclick="document.getElementById('modalTambahPengiriman').close()" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant font-semibold text-sm hover:bg-surface-container-high cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-[#FF6D00] text-white font-semibold text-sm hover:brightness-110 cursor-pointer">
                    Simpan & Kirim
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- INTEGRASI MAPS & TSP ALGORITHM SCRIPT -->
<script>
    // Database Koordinat Kota-Kota Besar di Indonesia
    const geoDatabase = {
        "jakarta": { lat: -6.2088, lng: 106.8456, name: "Gudang Utama (Jakarta)" },
        "bandung": { lat: -6.9175, lng: 107.6191, name: "Bandung" },
        "semarang": { lat: -6.9666, lng: 110.4167, name: "Semarang" },
        "yogyakarta": { lat: -7.7956, lng: 110.3695, name: "Yogyakarta" },
        "surakarta": { lat: -7.5755, lng: 110.8243, name: "Solo / Surakarta" },
        "solo": { lat: -7.5755, lng: 110.8243, name: "Solo" },
        "surabaya": { lat: -7.2575, lng: 112.7521, name: "Surabaya" },
        "malang": { lat: -7.9666, lng: 112.6326, name: "Malang" },
        "cirebon": { lat: -6.7320, lng: 108.5523, name: "Cirebon" },
        "bogor": { lat: -6.5971, lng: 106.8060, name: "Bogor" },
        "bekasi": { lat: -6.2383, lng: 106.9756, name: "Bekasi" },
        "tangerang": { lat: -6.1783, lng: 106.6319, name: "Tangerang" }
    };

    let mapInstance = null;
    let mapMarkers = [];
    let polylineRoute = null;

    // Formula Haversine: Menghitung jarak presisi (KM) antara dua titik koordinat
    function calculateHaversineDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Jari-jari bumi dalam KM
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; 
    }

    // FUNGSI UNTUK MENGHITUNG JARAK LANGSUNG PADA CARD DAFTAR PENGIRIMAN
    function renderJarakOnCards() {
        const depot = { lat: -6.2088, lng: 106.8456 }; // Jakarta
        const cards = document.querySelectorAll('.card-pengiriman');

        cards.forEach(card => {
            const elTujuan = card.querySelector('.item-tujuan');
            const elBadgeVal = card.querySelector('.val-jarak');

            if (elTujuan && elBadgeVal) {
                let tujuanText = elTujuan.innerText.trim();
                let cleanKey = tujuanText.toLowerCase().replace(/[^a-z]/g, '');
                let matchedGeo = null;

                for (let key in geoDatabase) {
                    if (cleanKey.includes(key)) {
                        matchedGeo = geoDatabase[key];
                        break;
                    }
                }

                if (matchedGeo) {
                    let dist = calculateHaversineDistance(depot.lat, depot.lng, matchedGeo.lat, matchedGeo.lng);
                    elBadgeVal.innerText = dist.toFixed(1) + " KM (dari Gudang)";
                } else {
                    // Fallback estimasi acak terukur jika nama kota tidak terdaftar
                    elBadgeVal.innerText = "~120.5 KM (Est.)";
                }
            }
        });
    }

    function hitungRuteTSP() {
        const elements = document.querySelectorAll('.item-tujuan');
        let rawTujuan = [];
        
        elements.forEach((el) => {
            let val = el.innerText.trim();
            if(val && !rawTujuan.includes(val)) {
                rawTujuan.push(val);
            }
        });

        if (rawTujuan.length === 0) {
            alert('Belum ada data lokasi pengiriman aktif untuk dihitung.');
            return;
        }

        // 1. Inisialisasi Titik Depot/Gudang Utama
        let depot = { lat: -6.2088, lng: 106.8456, name: "Gudang Utama (Jakarta)" };
        
        // 2. Mapping Nama Tujuan ke Koordinat
        let destinationNodes = [];
        rawTujuan.forEach(tujuan => {
            let cleanKey = tujuan.toLowerCase().replace(/[^a-z]/g, '');
            let matchedGeo = null;

            for (let key in geoDatabase) {
                if (cleanKey.includes(key)) {
                    matchedGeo = geoDatabase[key];
                    break;
                }
            }

            if (!matchedGeo) {
                matchedGeo = {
                    lat: -6.5 + (Math.random() * -1.5),
                    lng: 107.0 + (Math.random() * 5.0),
                    name: tujuan
                };
            } else {
                matchedGeo = { ...matchedGeo, name: tujuan };
            }

            destinationNodes.push(matchedGeo);
        });

        // 3. Algoritma TSP Nearest Neighbor + Mencatat Jarak Antar Segmen
        let currentNode = depot;
        let unvisited = [...destinationNodes];
        let optimizedPath = [depot];
        let legDistances = [];
        let totalDistance = 0;

        while (unvisited.length > 0) {
            let nearestIndex = 0;
            let minDistance = Infinity;

            for (let i = 0; i < unvisited.length; i++) {
                let dist = calculateHaversineDistance(
                    currentNode.lat, currentNode.lng,
                    unvisited[i].lat, unvisited[i].lng
                );
                if (dist < minDistance) {
                    minDistance = dist;
                    nearestIndex = i;
                }
            }

            totalDistance += minDistance;
            legDistances.push(minDistance);
            currentNode = unvisited[nearestIndex];
            optimizedPath.push(currentNode);
            unvisited.splice(nearestIndex, 1);
        }

        // Render UI Total Jarak
        document.getElementById('sectionRuteTSP').classList.remove('hidden');
        document.getElementById('totalDistanceVal').innerText = totalDistance.toFixed(1) + " KM";

        // Render UI Urutan Rute beserta BADGE JARAK PER SEGMEN
        let htmlHasil = `<div class="flex items-center flex-wrap gap-2 text-sm font-semibold text-primary">`;
        optimizedPath.forEach((node, idx) => {
            if (idx === 0) {
                htmlHasil += `
                    <span class="bg-primary text-white px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">warehouse</span> ${node.name}
                    </span>`;
            } else {
                let segmentDist = legDistances[idx - 1].toFixed(1);
                htmlHasil += `
                    <div class="flex items-center gap-1 text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-1 rounded-md">
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        <span class="font-bold">${segmentDist} KM</span>
                    </div>
                    <span class="bg-emerald-100 text-emerald-900 border border-emerald-300 px-3 py-1.5 rounded-lg flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">location_on</span> Stop ${idx}: ${node.name}
                    </span>`;
            }
        });
        htmlHasil += `</div>`;
        document.getElementById('hasilTSP').innerHTML = htmlHasil;

        // 4. Render Maps dan Garis Polyline Rute
        setTimeout(() => {
            renderMapAndRoute(optimizedPath, legDistances);
        }, 100);
    }

    function renderMapAndRoute(pathNodes, legDistances) {
        if (!mapInstance) {
            mapInstance = L.map('map').setView([pathNodes[0].lat, pathNodes[0].lng], 7);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap'
            }).addTo(mapInstance);
        } else {
            mapMarkers.forEach(m => mapInstance.removeLayer(m));
            if (polylineRoute) mapInstance.removeLayer(polylineRoute);
            mapMarkers = [];
        }

        let latLngList = [];

        pathNodes.forEach((node, index) => {
            let point = [node.lat, node.lng];
            latLngList.push(point);

            let popupContent = "";
            if (index === 0) {
                popupContent = `<b>Depot Awal: ${node.name}</b><br><span style="color:#059669; font-size:12px;">Titik Keberangkatan Logistik</span>`;
            } else {
                let distFromPrev = legDistances[index - 1].toFixed(1);
                popupContent = `<b>Stop ${index}: ${node.name}</b><br><span style="color:#059669; font-weight:bold; font-size:12px;">+${distFromPrev} KM dari stop sebelumnya</span>`;
            }

            let marker = L.marker(point).addTo(mapInstance)
                .bindPopup(popupContent)
                .openPopup();
                
            mapMarkers.push(marker);
        });

        polylineRoute = L.polyline(latLngList, {
            color: '#10b981',
            weight: 4,
            opacity: 0.85,
            dashArray: '6, 8'
        }).addTo(mapInstance);

        mapInstance.fitBounds(polylineRoute.getBounds(), { padding: [30, 30] });
    }

    // Jalankan kalkulasi jarak card setelah dokumen selesai dimuat
    document.addEventListener("DOMContentLoaded", () => {
        renderJarakOnCards();
    });
</script>

</body>
</html>