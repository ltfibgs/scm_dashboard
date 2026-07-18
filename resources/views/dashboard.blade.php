<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoes SCM - Dashboard & Sales Trend</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">
        <aside id="appSidebar" class="w-64 bg-gray-900 text-white flex flex-col justify-between transition-all duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between gap-3">
                    <h1 id="sidebarTitle" class="text-2xl font-bold tracking-wider text-indigo-400 transition-all duration-300">
                        SHOES SCM
                    </h1>
                    <button id="sidebarToggle" type="button" aria-label="Toggle sidebar" class="text-white/90 hover:text-white p-2 rounded bg-gray-800 hover:bg-gray-700 transition duration-200">
                        <!-- ikon burger -->
                        <span class="block text-lg leading-none">&#9776;</span>
                    </button>
                </div>

                <nav class="mt-10 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="menu-link block py-2.5 px-4 rounded transition duration-200 bg-gray-800 text-white font-semibold">

                        <span class="menu-icon">🏠</span>
                        <span class="menu-text ml-3">Dashboard</span>
                    </a>
                    <!-- Manajemen Supplier -->
                    <a href="{{ route('supplier.index') }}" class="menu-link block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800 hover:text-white">
                        <span class="menu-icon">🤝</span>
                        <span class="menu-text ml-3">Manajemen Supplier</span>
                    </a>

                    <!-- Inventaris / Gudang -->
                    <a href="{{ route('pengadaan.index') }}" class="menu-link block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-800 hover:text-white">
                        <span class="menu-icon">📦</span>
                        <span class="menu-text ml-3">Inventaris / Gudang</span>
                    </a>

                </nav>
            </div>

            <div class="p-4 border-t border-gray-800 text-sm text-gray-400">
                <span id="sidebarFooterText" class="transition-opacity duration-200">v1.1 - Dashboard Update</span>
            </div>
        </aside>


        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Ringkasan Performa & Rantai Pasok</h2>
                <span class="text-sm bg-indigo-100 text-indigo-800 font-medium px-3 py-1 rounded-full">
                    Administrator
                </span>
            </header>

            <main class="p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Revenue</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Units Sold</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ number_format($totalUnitsSold, 0, ',', '.') }} Pcs
                        </h3>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Low Stock Alerts</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2 {{ $lowStockCount > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $lowStockCount }} Items
                        </h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Grafik Sales Trend</h3>
                            <p class="text-sm text-gray-500">Visualisasi pertumbuhan pendapatan berkala dari transaksi penjualan sepatu</p>
                        </div>
                        <span class="text-xs bg-green-100 text-green-800 px-2.5 py-1 rounded-full font-medium shadow-2xs">
                            Database Connected
                        </span>
                    </div>
                    <div class="relative w-full" style="height: 350px;">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h4 class="font-semibold text-gray-800">Status Kontrol Inventaris</h4>
                        @if($lowStockCount > 0)
                            <span class="text-xs bg-amber-100 text-amber-800 px-2 py-0.5 rounded font-medium animate-pulse">
                                Butuh Restock Segera
                            </span>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                    <th class="py-3 px-6 font-semibold">No</th>
                                    <th class="py-3 px-6 font-semibold">Nama Item / Bahan Baku</th>
                                    <th class="py-3 px-6 font-semibold text-center">Stok Saat Ini</th>
                                    <th class="py-3 px-6 font-semibold text-center">Batas Minimum</th>
                                    <th class="py-3 px-6 font-semibold">Pemasok / Supplier</th>
                                    <th class="py-3 px-6 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm">
                                @forelse($materials as $index => $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6 font-medium text-gray-600">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6 font-semibold text-gray-900">
                                            {{ $item->nama_bahan ?? $item->Product_Name ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="py-4 px-6 text-center font-medium">
                                            {{ $item->stok }}
                                        </td>
                                        <td class="py-4 px-6 text-center text-gray-500">
                                            {{ $item->min_stok }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">
                                            {{ $item->supplier ?? 'Belum Ditentukan' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($item->stok <= $item->min_stok)
                                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                                    Kritis
                                                </span>
                                            @else
                                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    Aman
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-400 font-medium">
                                            Belum ada data rantai pasok yang tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <style>
        /* Sidebar collapsed: hanya ikon yang terlihat */
        #appSidebar.collapsed { width: 4rem; }
        #appSidebar.collapsed .menu-text { display: none; }
        #appSidebar.collapsed #sidebarTitle { opacity: 0; width: 0; overflow: hidden; }
        #appSidebar.collapsed #sidebarFooterText { opacity: 0; }
        .menu-icon { font-size: 1.05rem; line-height: 1; }
        /* Supaya padding tetap pas saat collapsed */
        #appSidebar.collapsed .menu-link { padding-left: 1rem; padding-right: 1rem; text-align: center; }
    </style>

    <script>
        const sidebar = document.getElementById('appSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        // default: expanded (bisa diganti localStorage kalau dibutuhkan)
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            // Ubah ikon burger jadi panah saat collapsed (opsional)
            const isCollapsed = sidebar.classList.contains('collapsed');
            toggleBtn.innerHTML = isCollapsed ? '<span class="block text-lg leading-none">&#187;</span>' : '<span class="block text-lg leading-none">&#9776;</span>';
        });

        // Membaca array dari Controller PHP ke struktur JSON JavaScript secara aman
        const labelsData = {!! json_encode($chartLabels) !!};
        const salesValues = {!! json_encode($chartValues) !!};


        // Inisialisasi Chart.js Tipe Line Chart
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: labelsData, // Data waktu/periode (Sumbu X)
                datasets: [{
                    label: 'Total Pendapatan (IDR)',
                    data: salesValues, // Angka penjualan (Sumbu Y)
                    borderColor: 'rgba(79, 70, 229, 1)', // Warna Garis Utama (Indigo)
                    backgroundColor: 'rgba(79, 70, 229, 0.08)', // Warna Transparansi Area Bawah Garis
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35, // Membuat lekukan tren tampak halus melengkung
                    pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            font: { size: 12, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        callbacks: {
                            // Mengubah visualisasi angka teks melayang (tooltip) ke format Rupiah standar
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { 
                                        style: 'currency', 
                                        currency: 'IDR', 
                                        maximumFractionDigits: 0 
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#4b5563' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#4b5563',
                            // Mengubah label nilai angka vertikal (Sumbu Y) ke label Ringkas Rupiah
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>