<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Ringkasan Performa & Rantai Pasok</title>
    
    <!-- Tailwind CSS v3 / Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    @include('partials.sidebar', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <main class="flex-1 p-margin-mobile md:p-lg">
        
        <!-- Top Header Section -->
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md border-b border-outline-variant/40 pb-md">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-900 text-xs font-bold uppercase tracking-wider">Executive Overview</span>
                </div>
                <h2 class="text-3xl font-bold text-primary">Ringkasan Performa & Rantai Pasok</h2>
                <p class="text-on-surface-variant text-sm mt-1">Pantau tren pendapatan, penjualan unit, dan kontrol stok bahan baku secara real-time.</p>
            </div>

            <div class="flex items-center gap-3 self-start md:self-auto">
                <div class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant/50 px-3.5 py-2 rounded-xl shadow-sm text-xs font-semibold text-primary">
                    <span class="material-symbols-outlined text-indigo-600 text-[18px]">admin_panel_settings</span>
                    <span>Administrator</span>
                </div>
            </div>
        </div>

        <!-- KPI Metric Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mb-xl">
            <!-- Revenue Card -->
            <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/50 flex justify-between items-start transition-all hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-primary mt-2">
                        Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-emerald-600 font-medium mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span>
                        Akumulasi Transaksi
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">payments</span>
                </div>
            </div>

            <!-- Units Sold Card -->
            <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/50 flex justify-between items-start transition-all hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Total Unit Terjual</p>
                    <h3 class="text-2xl lg:text-3xl font-extrabold text-primary mt-2">
                        {{ number_format($totalUnitsSold ?? 0, 0, ',', '.') }} <span class="text-sm font-normal text-on-surface-variant">Pcs</span>
                    </h3>
                    <p class="text-xs text-indigo-600 font-medium mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">shopping_bag</span>
                        Volume Penjualan
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                </div>
            </div>

            <!-- Low Stock Alert Card -->
            <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/50 flex justify-between items-start transition-all hover:shadow-md">
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Peringatan Stok Kritis</p>
                    <h3 class="text-2xl lg:text-3xl font-extrabold mt-2 {{ ($lowStockCount ?? 0) > 0 ? 'text-rose-600' : 'text-primary' }}">
                        {{ $lowStockCount ?? 0 }} <span class="text-sm font-normal text-on-surface-variant">Item</span>
                    </h3>
                    @if(($lowStockCount ?? 0) > 0)
                        <p class="text-xs text-rose-600 font-bold mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">warning</span>
                            Membutuhkan Restock
                        </p>
                    @else
                        <p class="text-xs text-emerald-600 font-medium mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            Stok Aman
                        </p>
                    @endif
                </div>
                <div class="w-12 h-12 rounded-xl {{ ($lowStockCount ?? 0) > 0 ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">notifications_active</span>
                </div>
            </div>
        </div>

        <!-- Sales Trend Line Chart Card dengan Filter -->
        <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/50 mb-xl">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-lg">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">show_chart</span>
                        <h3 class="text-lg font-bold text-primary">Grafik Tren Penjualan</h3>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-0.5">Visualisasi pertumbuhan pendapatan dari transaksi produk sepatu secara berkala.</p>
                </div>
                
                <!-- Filter Periode (Harian, Mingguan, Bulanan, Tahunan) -->
                <div class="flex items-center gap-2 bg-surface-container p-1 rounded-xl border border-outline-variant/40 self-start lg:self-auto">
                    <button onclick="updateChartFilter('daily')" id="btn-daily" class="filter-btn text-xs font-bold px-3 py-1.5 rounded-lg transition-all cursor-pointer bg-white text-indigo-600 shadow-sm">
                        Harian
                    </button>
                    <button onclick="updateChartFilter('weekly')" id="btn-weekly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-lg transition-all cursor-pointer text-on-surface-variant hover:text-primary">
                        Mingguan
                    </button>
                    <button onclick="updateChartFilter('monthly')" id="btn-monthly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-lg transition-all cursor-pointer text-on-surface-variant hover:text-primary">
                        Bulanan
                    </button>
                    <button onclick="updateChartFilter('yearly')" id="btn-yearly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-lg transition-all cursor-pointer text-on-surface-variant hover:text-primary">
                        Tahunan
                    </button>
                </div>
            </div>
            
            <div class="relative w-full h-80">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <!-- Inventory Control Table -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
            <div class="px-lg py-md border-b border-outline-variant/40 bg-surface-container-low/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">inventory</span>
                    <h3 class="text-base font-bold text-primary">Status Kontrol Inventaris</h3>
                </div>
                @if(($lowStockCount ?? 0) > 0)
                    <span class="inline-flex items-center gap-1 text-xs bg-rose-50 text-rose-700 border border-rose-200 px-3 py-1 rounded-full font-bold">
                        <span class="material-symbols-outlined text-[16px]">priority_high</span>
                        Perlu Restock Segera
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full font-semibold">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Semua Stok Optimal
                    </span>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface-variant uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                            <th class="py-3.5 px-lg font-bold">No</th>
                            <th class="py-3.5 px-lg font-bold">Nama Item / Bahan Baku</th>
                            <th class="py-3.5 px-lg font-bold text-center">Stok Saat Ini</th>
                            <th class="py-3.5 px-lg font-bold text-center">Batas Minimum</th>
                            <th class="py-3.5 px-lg font-bold">Pemasok / Supplier</th>
                            <th class="py-3.5 px-lg font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-sm">
                        @forelse($materials as $index => $item)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-lg font-medium text-on-surface-variant">{{ $index + 1 }}</td>
                                <td class="py-4 px-lg font-bold text-primary">
                                    {{ $item->nama_bahan ?? $item->Product_Name ?? 'Tidak Diketahui' }}
                                </td>
                                <td class="py-4 px-lg text-center font-extrabold text-primary">
                                    {{ $item->stok }}
                                </td>
                                <td class="py-4 px-lg text-center text-on-surface-variant font-medium">
                                    {{ $item->min_stok }}
                                </td>
                                <td class="py-4 px-lg text-on-surface-variant font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-outline">store</span>
                                        {{ $item->supplier ?? 'Belum Ditentukan' }}
                                    </div>
                                </td>
                                <td class="py-4 px-lg text-center">
                                    @if($item->stok <= $item->min_stok)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-rose-700 bg-rose-50 border border-rose-200 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                            Kritis
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Aman
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-outline mb-2">inbox</span>
                                        <p class="font-semibold text-primary">Belum Ada Data Rantai Pasok</p>
                                        <p class="text-xs text-on-surface-variant mt-0.5">Data inventaris akan ditampilkan di sini setelah ditambahkan.</p>
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

<!-- Chart.js Logic dengan Dynamic Filter -->
<script>
    let salesChart;

    // Data set dummy / fallback sesuai filter periode
    const rawChartData = {
        daily: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            values: [2500000, 3100000, 1800000, 4200000, 5600000, 7800000, 6400000]
        },
        weekly: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            values: [18500000, 22400000, 19800000, 27100000]
        },
        monthly: {
            labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']) !!},
            values: {!! json_encode($chartValues ?? [12000000, 19000000, 15000000, 25000000, 22000000, 30000000, 28000000, 35000000, 40000000, 38000000, 45000000, 50000000]) !!}
        },
        yearly: {
            labels: ['2023', '2024', '2025', '2026'],
            values: [180000000, 240000000, 310000000, 390000000]
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        
        // Gradient area fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

        salesChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: rawChartData.daily.labels,
                datasets: [{
                    label: 'Total Pendapatan (IDR)',
                    data: rawChartData.daily.values,
                    borderColor: '#4f46e5',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#4f46e5',
                    pointHoverBackgroundColor: '#4338ca',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        backgroundColor: '#091426',
                        titleFont: { size: 13, family: 'Inter' },
                        bodyFont: { size: 13, weight: 'bold', family: 'Inter' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y || 0;
                                return 'Pendapatan: ' + new Intl.NumberFormat('id-ID', { 
                                    style: 'currency', 
                                    currency: 'IDR', 
                                    maximumFractionDigits: 0 
                                }).format(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#75777d', font: { size: 12, family: 'Inter' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#eae7e9' },
                        ticks: {
                            color: '#75777d',
                            font: { size: 12, family: 'Inter' },
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);
                            }
                        }
                    }
                }
            }
        });
    });

    // Fungsi Switch/Filter Data Grafik
    function updateChartFilter(period) {
        if (!salesChart || !rawChartData[period]) return;

        // Update Data Grafik
        salesChart.data.labels = rawChartData[period].labels;
        salesChart.data.datasets[0].data = rawChartData[period].values;
        salesChart.update();

        // Update Tampilan Tombol Active / Inactive
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-white', 'text-indigo-600', 'shadow-sm', 'font-bold');
            btn.classList.add('text-on-surface-variant', 'font-medium');
        });

        const activeBtn = document.getElementById(`btn-${period}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-on-surface-variant', 'font-medium');
            activeBtn.classList.add('bg-white', 'text-indigo-600', 'shadow-sm', 'font-bold');
        }
    }
</script>

</body>
</html>