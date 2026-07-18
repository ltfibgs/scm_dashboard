<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengadaan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
<div class="min-h-screen flex">
    @include('partials.sidebar', ['active' => 'pengadaan'])

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Pengadaan</h2>
            <span class="text-sm bg-indigo-100 text-indigo-800 font-medium px-3 py-1 rounded-full">Administrator</span>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Pengadaan</h3>

                    <form method="POST" action="{{ route('pengadaan.store') }}" class="space-y-4" id="pengadaanForm">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pengadaan_ID</label>
                            <input type="text" name="Pengadaan_ID" class="mt-1 w-full rounded border-gray-300" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Supplier_ID</label>
                            <select name="Supplier_ID" class="mt-1 w-full rounded border-gray-300" required>
                                @foreach($suppliers as $sp)
                                    <option value="{{ $sp->Supplier_ID }}">{{ $sp->Supplier_ID }} - {{ $sp->Supplier_Name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Barang / Item</label>
                            <input type="text" name="Item_Nama" class="mt-1 w-full rounded border-gray-300" required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Qty Masuk</label>
                                <input type="number" min="1" name="Qty_Masuk" id="qtyMasuk" class="mt-1 w-full rounded border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Beli Satuan</label>
                                <input type="number" min="0" step="0.01" name="Harga_Beli_Satuan" id="hargaSatuan" class="mt-1 w-full rounded border-gray-300" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Harga Pengadaan (otomatis)</label>
                            <input type="number" min="0" step="0.01" name="Total_Harga_Pengadaan" id="totalHarga" class="mt-1 w-full rounded border-gray-300" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal/Waktu Transaksi Masuk</label>
                            <input type="datetime-local" name="Tanggal_Waktu_Transaksi_Masuk" class="mt-1 w-full rounded border-gray-300" required>
                        </div>

                        <div class="pt-2">
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded" type="submit">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengadaan</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold">Pengadaan_ID</th>
                                <th class="py-3 px-6 font-semibold">Supplier</th>
                                <th class="py-3 px-6 font-semibold">Item</th>
                                <th class="py-3 px-6 font-semibold">Qty</th>
                                <th class="py-3 px-6 font-semibold">Total</th>
                                <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse($pengadaan as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-6 font-medium text-gray-700">{{ $p->Pengadaan_ID }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $p->Supplier_ID }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $p->Item_Nama }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ $p->Qty_Masuk }}</td>
                                    <td class="py-3 px-6 text-gray-700">{{ number_format((float)$p->Total_Harga_Pengadaan, 2, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <details class="relative">
                                                <summary class="cursor-pointer text-indigo-700 font-semibold text-xs">Edit</summary>
                                                <form method="POST" action="{{ route('pengadaan.update', $p->Pengadaan_ID) }}" class="mt-2 text-left bg-white border border-gray-200 rounded p-3">
                                                    @csrf
                                                    <div class="space-y-2">
                                                        <select name="Supplier_ID" class="w-full rounded border-gray-300 text-sm" required>
                                                            @foreach($suppliers as $sp)
                                                                <option value="{{ $sp->Supplier_ID }}" {{ $sp->Supplier_ID === $p->Supplier_ID ? 'selected' : '' }}>
                                                                    {{ $sp->Supplier_ID }} - {{ $sp->Supplier_Name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="text" name="Item_Nama" value="{{ $p->Item_Nama }}" class="w-full rounded border-gray-300 text-sm" required>
                                                        <input type="number" min="1" name="Qty_Masuk" value="{{ $p->Qty_Masuk }}" class="w-full rounded border-gray-300 text-sm" required>
                                                        <input type="number" min="0" step="0.01" name="Harga_Beli_Satuan" value="{{ $p->Harga_Beli_Satuan }}" class="w-full rounded border-gray-300 text-sm" required>
                                                        <input type="number" min="0" step="0.01" name="Total_Harga_Pengadaan" value="{{ $p->Total_Harga_Pengadaan }}" class="w-full rounded border-gray-300 text-sm">
                                                        <input type="datetime-local" name="Tanggal_Waktu_Transaksi_Masuk" value="{{ 
                                                            \Carbon\Carbon::parse($p->Tanggal_Waktu_Transaksi_Masuk)->format('Y-m-d\TH:i') 
                                                        }}" class="w-full rounded border-gray-300 text-sm" required>
                                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1 rounded">Update</button>
                                                    </div>
                                                </form>
                                            </details>

                                            <form method="POST" action="{{ route('pengadaan.destroy', $p->Pengadaan_ID) }}" onsubmit="return confirm('Hapus pengadaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 hover:text-red-800 font-semibold text-xs">Hapus</button>
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

<script>
    const qty = document.getElementById('qtyMasuk');
    const harga = document.getElementById('hargaSatuan');
    const total = document.getElementById('totalHarga');

    function hitung() {
        const q = parseFloat(qty?.value || 0);
        const h = parseFloat(harga?.value || 0);
        if (!Number.isNaN(q) && !Number.isNaN(h)) total.value = (q * h).toFixed(2);
    }

    qty?.addEventListener('input', hitung);
    harga?.addEventListener('input', hitung);
</script>
</body>
</html>

