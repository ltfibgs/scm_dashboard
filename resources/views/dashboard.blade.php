<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Analytics & Executive Dashboard</title>
    
    <!-- Tailwind CSS v3 / Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        "brand-dark": "#0b1329",
                        "brand-primary": "#f97316", // Vibrant Orange Accent
                        "brand-accent": "#4f46e5",  // Indigo
                        "surface-card": "#ffffff",
                        "border-light": "#e2e8f0"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

<div class="flex min-h-screen">
    <!-- Sidebar Include -->
    @include('partials.sidebar', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <main class="flex-1 p-4 md:p-8 max-w-[1600px] mx-auto w-full">
        
        <!-- Top Executive Header Section -->
        <div class="mb-8 flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm backdrop-blur-md">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[11px] font-bold uppercase tracking-wider border border-orange-200/60 flex items-center gap-1.5 w-fit">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Real-Time Analytics
                    </span>
                    <span class="text-xs text-slate-400 font-medium">• Update Otomatis</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Performa & Rantai Pasok</h1>
                <p class="text-slate-500 text-sm mt-1">Pantau indikator kinerja utama, aliran penjualan produk sepatu, dan ketersediaan stok produk jadi.</p>
            </div>

           
        </div>

        <!-- 3 KPI Metric Highlight Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Revenue Card -->
            <div class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 transition-all hover:shadow-lg hover:-translate-y-0.5 group">
                <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">payments</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                    Rp {{ number_format($totalRevenue ?? 128500000, 0, ',', '.') }}
                </h3>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span> +14.2%
                    </span>
                    <span class="text-slate-400">vs Bulan Lalu</span>
                </div>
            </div>

            <!-- Units Sold Card -->
            <div class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 transition-all hover:shadow-lg hover:-translate-y-0.5 group">
                <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-orange-500/5 rounded-full blur-2xl group-hover:bg-orange-500/10 transition-all"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Unit Terjual</span>
                    <div class="w-11 h-11 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">shopping_bag</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ number_format($totalUnitsSold ?? 1420, 0, ',', '.') }} <span class="text-base font-medium text-slate-400">Pasang</span>
                </h3>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center gap-1 font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span> +8.5%
                    </span>
                    <span class="text-slate-400">Volume Penjualan</span>
                </div>
            </div>

            <!-- Low Stock Alert Card -->
            <div class="relative overflow-hidden bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 transition-all hover:shadow-lg hover:-translate-y-0.5 group">
                <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/10 transition-all"></div>
                <div class="flex justify-between items-start mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Produk Kritis</span>
                    <div class="w-11 h-11 rounded-2xl {{ ($lowStockCount ?? 2) > 0 ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }} flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">warning</span>
                    </div>
                </div>
                <h3 class="text-3xl font-black {{ ($lowStockCount ?? 2) > 0 ? 'text-rose-600' : 'text-slate-900' }} tracking-tight">
                    {{ $lowStockCount ?? 2 }} <span class="text-base font-normal text-slate-400">Model</span>
                </h3>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    @if(($lowStockCount ?? 2) > 0)
                        <span class="inline-flex items-center gap-1 font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md">
                            <span class="material-symbols-outlined text-[16px]">priority_high</span> Perlu Re-order
                        </span>
                        <span class="text-slate-400">Batas Stok &lt; 10 Pcs</span>
                    @else
                        <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span> Aman
                        </span>
                        <span class="text-slate-400">Semua Stok Optimal</span>
                    @endif
                </div>
            </div>

        </div>

        <!-- Charts Section (Grid Split 2 Columns: Main Chart + Category Breakdown) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Main Line Chart Card (2 Cols) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 rounded-xl bg-orange-50 text-orange-600">
                                <span class="material-symbols-outlined text-[20px]">show_chart</span>
                            </div>
                            <h2 class="text-lg font-extrabold text-slate-900">Grafik Performa Penjualan</h2>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Tren pendapatan dari transaksi terkonfirmasi secara berkala.</p>
                    </div>
                    
                    <!-- Dynamic Period Buttons -->
                    <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200/60 self-start sm:self-auto">
                        <button onclick="updateChartFilter('daily')" id="btn-daily" class="filter-btn text-xs font-bold px-3 py-1.5 rounded-xl transition-all cursor-pointer bg-white text-orange-600 shadow-sm">
                            Harian
                        </button>
                        <button onclick="updateChartFilter('weekly')" id="btn-weekly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-xl transition-all cursor-pointer text-slate-600 hover:text-slate-900">
                            Mingguan
                        </button>
                        <button onclick="updateChartFilter('monthly')" id="btn-monthly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-xl transition-all cursor-pointer text-slate-600 hover:text-slate-900">
                            Bulanan
                        </button>
                        <button onclick="updateChartFilter('yearly')" id="btn-yearly" class="filter-btn text-xs font-medium px-3 py-1.5 rounded-xl transition-all cursor-pointer text-slate-600 hover:text-slate-900">
                            Tahunan
                        </button>
                    </div>
                </div>
                
                <div class="relative w-full h-80">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart Card (1 Col: Kategori Terlaris) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                            <span class="material-symbols-outlined text-[20px]">pie_chart</span>
                        </div>
                        <h2 class="text-lg font-extrabold text-slate-900">Kategori Sepatu</h2>
                    </div>
                    <p class="text-xs text-slate-500">Komposisi kontribusi penjualan per kategori.</p>
                </div>

                <div class="relative my-4 flex items-center justify-center h-52">
                    <canvas id="categoryDoughnutChart"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-4 border-t border-slate-100 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                        <span class="text-slate-600 font-medium">Sneakers (45%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                        <span class="text-slate-600 font-medium">Running (30%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-600 font-medium">Casual (15%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                        <span class="text-slate-600 font-medium">Formal (10%)</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Inventory Control Table (Finished Goods / Produk Jadi) -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            
            <!-- Table Action Header -->
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-orange-600">inventory_2</span>
                        <h2 class="text-lg font-extrabold text-slate-900">Kontrol Inventaris Produk Jadi</h2>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar stok produk sepatu siap kirim di gudang penyimpanan.</p>
                </div>

                <!-- Table Search & Filters -->
                <div class="flex items-center gap-3">
                    <div class="relative w-full md:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">search</span>
                        <input type="text" id="tableSearch" onkeyup="filterTable()" placeholder="Cari nama produk..." class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-orange-500 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="inventoryTable">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <th class="py-4 px-6 font-bold">No</th>
                            <th class="py-4 px-6 font-bold">Nama Sepatu</th>
                            <th class="py-4 px-6 font-bold">Kategori</th>
                            <th class="py-4 px-6 font-bold text-center">Tingkat Stok</th>
                            <th class="py-4 px-6 font-bold text-center">Batas Min.</th>
                            <th class="py-4 px-6 font-bold text-center">Status</th>
                            <th class="py-4 px-6 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @php 
                            $listProduk = $produkJadi ?? $materials ?? [
                                (object)['Product_Name' => 'Sneakers Vulcanized High Black', 'Category' => 'Sneakers', 'stok' => 85, 'min_stok' => 15],
                                (object)['Product_Name' => 'Running Shoes Pro Carbon-X', 'Category' => 'Running', 'stok' => 8, 'min_stok' => 10],
                                (object)['Product_Name' => 'Leather Casual Loafers Tan', 'Category' => 'Casual', 'stok' => 42, 'min_stok' => 10],
                                (object)['Product_Name' => 'Classic Oxford Leather Shoes', 'Category' => 'Formal', 'stok' => 5, 'min_stok' => 12]
                            ]; 
                        @endphp
                        
                        @forelse($listProduk as $index => $item)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                <td class="py-4 px-6 text-xs font-semibold text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                                    {{ $item->Product_Name ?? $item->Nama_Produk_Jadi ?? $item->Jenis_Sepatu ?? 'Tidak Diketahui' }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                        {{ $item->Category ?? $item->kategori ?? 'Sepatu' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @php 
                                        $stokVal = $item->stok ?? $item->Qty ?? 0;
                                        $percent = min(100, max(5, ($stokVal / 100) * 100));
                                    @endphp
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="font-extrabold text-slate-900 text-xs">{{ $stokVal }} Pcs</span>
                                        <div class="w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full {{ $stokVal <= ($item->min_stok ?? 10) ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center text-xs font-medium text-slate-500">
                                    {{ $item->min_stok ?? 10 }} Pcs
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if(($item->stok ?? $item->Qty ?? 0) <= ($item->min_stok ?? 10))
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold text-rose-700 bg-rose-50 border border-rose-200/80 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            Kritis / Tipis
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/80 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Ready Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <button class="p-2 rounded-xl text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all">
                                        <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-5xl text-slate-300 mb-2">inbox</span>
                                        <p class="font-bold text-slate-700">Belum Ada Inventaris Produk Jadi</p>
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

<!-- Chart.js Logic Terintegrasi Data Dynamic & Filters -->
<script>
    let salesChart;
    let categoryChart;

    // Raw Data Fallback / Database Binding
    const rawChartData = {
        daily: { labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], values: [3200000, 4500000, 2800000, 5200000, 6800000, 9400000, 8100000] },
        weekly: { labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'], values: [22500000, 28400000, 24800000, 32100000] },
        monthly: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], values: [18000000, 24000000, 21000000, 31000000, 29000000, 38000000, 42000000, 48000000, 51000000, 49000000, 58000000, 65000000] },
        yearly: { labels: ['2024', '2025', '2026'], values: [280000000, 390000000, 520000000] }
    };

    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. Line Chart Setup (Sales Trend)
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
        gradient.addColorStop(1, 'rgba(249, 115, 22, 0.0)');

        salesChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: rawChartData.daily.labels,
                datasets: [{
                    label: 'Total Pendapatan (IDR)',
                    data: rawChartData.daily.values,
                    borderColor: '#f97316',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f97316',
                    pointHoverBackgroundColor: '#c2410c',
                    pointRadius: 4,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, family: 'Plus Jakarta Sans' },
                        bodyFont: { size: 13, weight: 'bold', family: 'Plus Jakarta Sans' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11, family: 'Plus Jakarta Sans' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11, family: 'Plus Jakarta Sans' },
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);
                            }
                        }
                    }
                }
            }
        });

        // 2. Doughnut Chart Setup (Category)
        const ctxDoughnut = document.getElementById('categoryDoughnutChart').getContext('2d');
        categoryChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Sneakers', 'Running', 'Casual', 'Formal'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: ['#f97316', '#4f46e5', '#10b981', '#94a3b8'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });

    // Switch Filter Logic
    function updateChartFilter(period) {
        if (!salesChart || !rawChartData[period]) return;

        salesChart.data.labels = rawChartData[period].labels;
        salesChart.data.datasets[0].data = rawChartData[period].values;
        salesChart.update();

        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-white', 'text-orange-600', 'shadow-sm', 'font-bold');
            btn.classList.add('text-slate-600', 'font-medium');
        });

        const activeBtn = document.getElementById(`btn-${period}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'font-medium');
            activeBtn.classList.add('bg-white', 'text-orange-600', 'shadow-sm', 'font-bold');
        }
    }

    // Filter Table Search Logic
    function filterTable() {
        const input = document.getElementById("tableSearch");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("inventoryTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                let txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

</body>
</html>