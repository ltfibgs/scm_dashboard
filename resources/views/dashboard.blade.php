<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoes SCM - Dashboard & Sales Trend</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="h-full font-sans antialiased text-gray-800 bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Partials -->
        @include('partials.sidebar', ['active' => 'dashboard'])

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <!-- Top Header -->
            <header class="bg-white shadow-xs px-6 py-4 flex justify-between items-center border-b border-gray-200 sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight">Ringkasan Performa & Rantai Pasok</h2>
                </div>
                <div class="flex items-center gap-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full text-xs font-semibold">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Administrator</span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6 md:p-8 space-y-8 max-w-7xl w-full mx-auto">
                
                <!-- KPI Metric Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Revenue Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Revenue</p>
                            <h3 class="text-2xl lg:text-3xl font-extrabold text-gray-900 mt-2">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Units Sold Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Units Sold</p>
                            <h3 class="text-2xl lg:text-3xl font-extrabold text-gray-900 mt-2">
                                {{ number_format($totalUnitsSold, 0, ',', '.') }} <span class="text-lg font-medium text-gray-500">Pcs</span>
                            </h3>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Low Stock Alert Card -->
                    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Low Stock Alerts</p>
                            <h3 class="text-2xl lg:text-3xl font-extrabold mt-2 {{ $lowStockCount > 0 ? 'text-rose-600' : 'text-gray-900' }}">
                                {{ $lowStockCount }} <span class="text-lg font-medium text-gray-500">Items</span>
                            </h3>
                        </div>
                        <div class="p-3 {{ $lowStockCount > 0 ? 'bg-rose-50 text-rose-600' : 'bg-gray-50 text-gray-400' }} rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sales Trend Line Chart -->
                <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Grafik Sales Trend</h3>
                            <p class="text-sm text-gray-500">Visualisasi pertumbuhan pendapatan berkala dari transaksi penjualan sepatu</p>
                        </div>
                        <div class="inline-flex items-center gap-1.5 self-start sm:self-auto bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Database Connected</span>
                        </div>
                    </div>
                    
                    <div class="relative w-full h-80">
                        <canvas id="salesTrendChart"></canvas>
                    </div>
                </div>

                <!-- Inventory Control Table -->
                <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h4 class="font-bold text-gray-800">Status Kontrol Inventaris</h4>
                        @if($lowStockCount > 0)
                            <span class="inline-flex items-center gap-1 text-xs bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Butuh Restock Segera
                            </span>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold tracking-wider border-b border-gray-200">
                                    <th class="py-3.5 px-6">No</th>
                                    <th class="py-3.5 px-6">Nama Item / Bahan Baku</th>
                                    <th class="py-3.5 px-6 text-center">Stok Saat Ini</th>
                                    <th class="py-3.5 px-6 text-center">Batas Minimum</th>
                                    <th class="py-3.5 px-6">Pemasok / Supplier</th>
                                    <th class="py-3.5 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($materials as $index => $item)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="py-4 px-6 font-medium text-gray-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6 font-semibold text-gray-900">
                                            {{ $item->nama_bahan ?? $item->Product_Name ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="py-4 px-6 text-center font-bold text-gray-800">
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
                                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 rounded-full">
                                                    Kritis
                                                </span>
                                            @else
                                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full">
                                                    Aman
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-400 font-medium">
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

    <!-- Chart.js Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const labelsData = {!! json_encode($chartLabels ?? []) !!};
            const salesValues = {!! json_encode($chartValues ?? []) !!};

            const ctx = document.getElementById('salesTrendChart').getContext('2d');
            
            // Gradient area fill under chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

            new Chart(ctx, {
                type: 'line', 
                data: {
                    labels: labelsData,
                    datasets: [{
                        label: 'Total Pendapatan (IDR)',
                        data: salesValues,
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
                            backgroundColor: '#1e293b',
                            titleFont: { size: 13 },
                            bodyFont: { size: 13, weight: 'bold' },
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
                            ticks: { color: '#64748b', font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                color: '#64748b',
                                font: { size: 12 },
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>