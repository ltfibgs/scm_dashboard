<aside id="appSidebar" class="sticky top-0 h-screen overflow-y-auto shrink-0 w-64 bg-slate-900 text-white flex flex-col justify-between transition-all duration-300 z-30 border-r border-slate-800">
    <div class="p-5">
        <!-- Header / Logo -->
        <div class="flex items-center justify-between ">
            <div id="sidebarTitle" class="flex items-center gap-2 transition-all duration-300 whitespace-nowrap overflow-hidden">
                <div class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center text-white shrink-0 font-extrabold text-sm shadow-md shadow-orange-500/30">
                    S
                </div>
                <h1 class="text-xl font-black tracking-wider text-white">
                    SHOES <span class="text-orange-500">SCM</span>
                </h1>
            </div>
            <button id="sidebarToggle" type="button" aria-label="Toggle sidebar" class="text-slate-300 hover:text-white p-2 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 transition duration-200 cursor-pointer border border-slate-700/50">
                <!-- Icon Hamburger SVG -->
                <svg id="toggleIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-8 space-y-1.5">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'dashboard' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Dashboard</span>
            </a>

            <!-- Supplier -->
            <a href="{{ route('supplier.index') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'supplier' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Manajemen Supplier</span>
            </a>

            <!-- Pengadaan -->
            <a href="{{ route('pengadaan.index') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'pengadaan' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Pengadaan</span>
            </a>

            <!-- Gudang -->
            <a href="{{ route('gudang.index') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'gudang' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V11m0 0h5m-5 0H7m5 0v10"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Gudang</span>
            </a>

            <!-- Produksi -->
            <a href="{{ route('produksi.index') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'produksi' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Produksi</span>
            </a>

            <!-- Pengiriman -->
            <a href="{{ route('pengiriman.index') }}"
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'pengiriman' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Pengiriman</span>
            </a>

            <!-- Penjualan -->
            <a href="{{ route('penjualan.index') }}" 
               class="menu-link flex items-center py-2.5 px-4 rounded-xl transition duration-200 {{ ($active ?? '') === 'penjualan' ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/80 hover:text-orange-400 text-slate-300' }}">
                <span class="menu-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </span>
                <span class="menu-text ml-3 text-sm">Penjualan</span>
            </a>
        </nav>
    </div>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-slate-800 text-xs text-slate-400 flex items-center justify-between">
        <span id="sidebarFooterText" class="transition-opacity duration-200 block truncate">v1.1 - Industrial Orange Edition</span>
        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block shrink-0" title="System Active"></span>
    </div>
</aside>

<style>
    /* Mode Collapse Sidebar */
    #appSidebar.collapsed { width: 4.5rem; }
    #appSidebar.collapsed .menu-text { display: none; }
    #appSidebar.collapsed #sidebarTitle h1 { display: none; }
    #appSidebar.collapsed #sidebarFooterText { display: none; }
    
    .menu-icon { 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        width: 1.5rem; 
        height: 1.5rem;
        flex-shrink: 0;
    }

    #appSidebar.collapsed .menu-link { 
        padding-left: 0rem; 
        padding-right: 0rem; 
        justify-content: center; 
    }
</style>

<script>
    (function(){
        const sidebar = document.getElementById('appSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (!sidebar || !toggleBtn) return;

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            
            // Mengubah SVG Tombol Toggle saat collapsed/expanded
            if (isCollapsed) {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>';
            } else {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
            }
        });
    })();
</script>