<aside id="appSidebar" class="w-64 bg-gray-900 text-white flex flex-col justify-between transition-all duration-300">
    <div class="p-5">
        <div class="flex items-center justify-between gap-3">
            <h1 id="sidebarTitle" class="text-2xl font-bold tracking-wider text-indigo-400 transition-all duration-300">
                SHOES SCM
            </h1>
            <button id="sidebarToggle" type="button" aria-label="Toggle sidebar" class="text-white/90 hover:text-white p-2 rounded bg-gray-800 hover:bg-gray-700 transition duration-200">
                <span class="block text-lg leading-none">&#9776;</span>
            </button>
        </div>

        <nav class="mt-10 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="menu-link block py-2.5 px-4 rounded transition duration-200 {{ ($active ?? '') === 'dashboard' ? 'bg-gray-800 text-white font-semibold' : 'hover:bg-gray-800 hover:text-white text-white' }}">
                <span class="menu-icon">🏠</span>
                <span class="menu-text ml-3">Dashboard</span>
            </a>

            <a href="{{ route('supplier.index') }}"
               class="menu-link block py-2.5 px-4 rounded transition duration-200 {{ ($active ?? '') === 'supplier' ? 'bg-gray-800 text-white font-semibold' : 'hover:bg-gray-800 hover:text-white text-white' }}">
                <span class="menu-icon">🤝</span>
                <span class="menu-text ml-3">Manajemen Supplier</span>
            </a>

            <a href="{{ route('pengadaan.index') }}"
               class="menu-link block py-2.5 px-4 rounded transition duration-200 {{ ($active ?? '') === 'pengadaan' ? 'bg-gray-800 text-white font-semibold' : 'hover:bg-gray-800 hover:text-white text-white' }}">
                <span class="menu-icon">📦</span>
                <span class="menu-text ml-3">Inventaris / Gudang</span>
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-gray-800 text-sm text-gray-400">
        <span id="sidebarFooterText" class="transition-opacity duration-200">v1.1 - Dashboard Update</span>
    </div>
</aside>

<style>
    /* Sidebar collapsed: hanya ikon yang terlihat */
    #appSidebar.collapsed { width: 4rem; }
    #appSidebar.collapsed .menu-text { display: none; }
    #appSidebar.collapsed #sidebarTitle { opacity: 0; width: 0; overflow: hidden; }
    #appSidebar.collapsed #sidebarFooterText { opacity: 0; }
    .menu-icon { font-size: 1.05rem; line-height: 1; }
    #appSidebar.collapsed .menu-link { padding-left: 1rem; padding-right: 1rem; text-align: center; }
</style>

<script>
    (function(){
        const sidebar = document.getElementById('appSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        if (!sidebar || !toggleBtn) return;

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            const isCollapsed = sidebar.classList.contains('collapsed');
            toggleBtn.innerHTML = isCollapsed ? '<span class="block text-lg leading-none">&#187;</span>' : '<span class="block text-lg leading-none">&#9776;</span>';
        });
    })();
</script>

