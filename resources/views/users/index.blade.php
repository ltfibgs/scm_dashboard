<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogiChain SCM - Manajemen Pengguna</title>
    
    <!-- Tailwind CSS -->
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
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0b1329",
                        "brand-primary": "#f97316",
                        "outline-variant": "#e2e8f0",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar', ['active' => 'users'])

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 max-w-[1600px] mx-auto w-full md:ml-64">
        
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Alert Error -->
        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-sm font-semibold flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/80 text-rose-800 text-sm">
                <p class="font-bold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 text-[11px] font-bold uppercase tracking-wider border border-orange-200/60 flex items-center gap-1.5 w-fit">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Administrasi Sistem
                    </span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola akun pengguna, hak akses, dan keamanan sistem.</p>
            </div>
            
            <button onclick="document.getElementById('modalTambahUser').showModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-bold text-sm transition-all shadow-md shadow-orange-600/20 active:scale-95 cursor-pointer shrink-0">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Tambah Pengguna
            </button>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">group</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">{{ $users->count() }} <span class="text-xs font-semibold text-slate-400">Akun</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">verified_user</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Aktif</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">{{ $users->count() }} <span class="text-xs font-semibold text-slate-400">Terdaftar</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[28px]">admin_panel_settings</span>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Role</p>
                    <p class="text-slate-900 text-2xl font-black mt-0.5">Admin <span class="text-xs font-semibold text-slate-400">Default</span></p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Pengguna -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-orange-600">manage_accounts</span>
                    <h3 class="text-base font-extrabold text-slate-900">Daftar Akun & Pengguna Sistem</h3>
                </div>
                <span class="text-xs font-bold text-orange-700 bg-orange-50 px-3 py-1 rounded-full border border-orange-200/60">
                    {{ $users->count() }} Pengguna
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <th class="py-4 px-6 font-bold">ID</th>
                            <th class="py-4 px-6 font-bold">Nama Lengkap</th>
                            <th class="py-4 px-6 font-bold">Email</th>
                            <th class="py-4 px-6 font-bold">Terdaftar</th>
                            <th class="py-4 px-6 font-bold text-center">Status</th>
                            <th class="py-4 px-6 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-slate-100 text-xs font-mono font-bold text-slate-700 border border-slate-200/60">
                                        #{{ $user->id }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-extrabold text-slate-900 group-hover:text-orange-600 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center text-sm font-extrabold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] font-bold">Anda</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-700 font-medium">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-slate-400">mail</span>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-600 text-xs">
                                    {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')" class="inline-flex items-center gap-1 text-orange-600 hover:text-orange-800 font-bold text-xs bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-xl border border-orange-200/60 transition-colors cursor-pointer">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                            Edit
                                        </button>

                                        <!-- Delete Form -->
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ addslashes($user->name) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-800 font-bold text-xs bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-xl border border-rose-200/60 transition-colors cursor-pointer">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400 italic">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">person_off</span>
                                        <p class="font-bold text-slate-700">Belum Ada Data Pengguna</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Klik tombol "Tambah Pengguna" untuk mendaftarkan akun baru.</p>
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

<!-- MODAL TAMBAH PENGGUNA -->
<dialog id="modalTambahUser" class="rounded-3xl shadow-2xl border border-slate-200/80 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-600">person_add</span>
                <h3 class="text-lg font-extrabold text-slate-900">Tambah Pengguna Baru</h3>
            </div>
            <button onclick="document.getElementById('modalTambahUser').close()" class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: John Doe" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Contoh: john@example.com" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Password</label>
                <input type="password" name="password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Minimal 6 karakter" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Ulangi password" required>
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100 mt-6">
                <button type="button" onclick="document.getElementById('modalTambahUser').close()" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs transition-colors shadow-md shadow-orange-600/20 cursor-pointer">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</dialog>

<!-- MODAL EDIT PENGGUNA -->
<dialog id="modalEditUser" class="rounded-3xl shadow-2xl border border-slate-200/80 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-600">edit_square</span>
                <h3 class="text-lg font-extrabold text-slate-900">Edit Pengguna: <span id="editUserName" class="text-orange-600"></span></h3>
            </div>
            <button onclick="document.getElementById('modalEditUser').close()" class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="formEditUser" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" id="editName" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" id="editEmail" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Password Baru <span class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Minimal 6 karakter">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-600 outline-none transition-all" placeholder="Ulangi password baru">
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-slate-100 mt-6">
                <button type="button" onclick="document.getElementById('modalEditUser').close()" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs transition-colors shadow-md shadow-orange-600/20 cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openEditModal(id, name, email) {
        document.getElementById('formEditUser').action = `/users/${id}`;
        document.getElementById('editUserName').textContent = name;
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('modalEditUser').showModal();
    }
</script>

</body>
</html>
