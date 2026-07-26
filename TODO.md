# TODO - Perbaikan Stok & Dropdown Produk Penjualan

## Masalah
1. Dropdown "Pilih Produk" kosong karena model Produksi tidak ada
2. Stok produk jadi tidak berkurang saat transaksi penjualan

## Langkah Perbaikan

- [x] **Step 1: Buat migration** - Tambah kolom `Stok_Tersedia` di tabel `tabel_produksi`
- [x] **Step 2: Jalankan migration**
- [x] **Step 3: Update `ProduksiController@complete`** - Set `Stok_Tersedia = Qty_Hasil_Jadi`
- [x] **Step 4: Update `PenjualanController`**
  - [x] 4.1 `index()`: Query `tabel_produksi` dengan filter `Completed` + `Stok_Tersedia > 0`
  - [x] 4.2 `store()`: Validasi stok terpenuhi, lalu decrement `Stok_Tersedia`
- [x] **Step 5: Update view** - Tampilkan stok tersedia di dropdown, tambah hidden `Produksi_ID`
- [x] **Step 6: Test** - Semua perubahan selesai
