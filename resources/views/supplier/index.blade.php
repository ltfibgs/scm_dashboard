<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<div class="min-h-screen flex">
    @include('partials.sidebar', ['active' => 'supplier'])

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Supplier</h2>
            <span class="text-sm bg-indigo-100 text-indigo-800 font-medium px-3 py-1 rounded-full">Administrator</span>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6">
                <!-- Tabel Daftar Supplier -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Supplier</h3>
                        <!-- Tombol Tambah Supplier di Kanan Atas Tabel -->
                        <button onclick="document.getElementById('modalTambahSupplier').showModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Supplier
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold">Supplier_ID</th>
                                <th class="py-3 px-6 font-semibold">Nama</th>
                                <th class="py-3 px-6 font-semibold">Category</th>
                                <th class="py-3 px-6 font-semibold">Kontak</th>
                                <th class="py-3 px-6 font-semibold">Kota</th>
                                <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($suppliers as $s)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-6 font-medium text-gray-700">{{ $s->Supplier_ID }}</td>
                                    <td class="py-3 px-6 font-semibold text-gray-900">{{ $s->Supplier_Name }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $s->Category }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $s->Contact_Person }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $s->City }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <details class="relative">
                                                <summary class="cursor-pointer text-indigo-700 font-semibold text-xs">Edit</summary>
                                                <form method="POST" action="{{ route('supplier.update', $s->Supplier_ID) }}" class="mt-2 text-left bg-white border border-gray-200 rounded p-3 absolute z-10 right-0 w-64 shadow-lg">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="space-y-2">
                                                        <input type="text" name="Supplier_Name" value="{{ $s->Supplier_Name }}" class="w-full rounded border-gray-300 text-sm px-2 py-1 border" placeholder="Nama">
                                                        <input type="text" name="Category" value="{{ $s->Category }}" class="w-full rounded border-gray-300 text-sm px-2 py-1 border" placeholder="Category">
                                                        <input type="text" name="Contact_Person" value="{{ $s->Contact_Person }}" class="w-full rounded border-gray-300 text-sm px-2 py-1 border" placeholder="Kontak">
                                                        <input type="text" name="City" value="{{ $s->City }}" class="w-full rounded border-gray-300 text-sm px-2 py-1 border" placeholder="Kota">
                                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1 rounded">Update</button>
                                                    </div>
                                                </form>
                                            </details>

                                            <form method="POST" action="{{ route('supplier.destroy', $s->Supplier_ID) }}" onsubmit="return confirm('Hapus supplier ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 hover:text-red-800 font-semibold text-xs cursor-pointer">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-400 font-semibold">Belum ada data.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- MODAL TAMBAH SUPPLIER -->
<dialog id="modalTambahSupplier" class="rounded-xl shadow-xl border border-gray-200 p-0 w-full max-w-md backdrop:bg-black/50 backdrop:backdrop-blur-sm">
    <div class="bg-white p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Supplier</h3>
            <button onclick="document.getElementById('modalTambahSupplier').close()" class="text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <form method="POST" action="{{ route('supplier.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Supplier ID</label>
                <input type="text" name="Supplier_ID" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                <input type="text" name="Supplier_Name" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" name="Category" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kontak / No Telepon</label>
                <input type="text" name="Contact_Person" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat / Kota</label>
                <input type="text" name="City" class="mt-1 w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 mt-4">
                <button type="button" onclick="document.getElementById('modalTambahSupplier').close()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded text-sm cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</dialog>

</body>
</html>