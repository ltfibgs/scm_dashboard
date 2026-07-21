<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Nama tabel sesuai di database .sql
    protected $table = '3__dataset_penjualan_sepatu';

    // Konfigurasi Primary Key
    protected $primaryKey = 'Order_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    // Nonaktifkan timestamps bawaan Laravel
    public $timestamps = false;

    // Kolom yang dapat diisi mass-assignment
    protected $fillable = [
        'Order_ID', 
        'Timestamp', 
        'Product_Name', 
        'Category', 
        'Qty', 
        'Unit_Price', 
        'Total_Price', 
        'Payment_Method'
    ];

    // Konversi tipe data otomatis (Casting)
    protected $casts = [
        'Timestamp'   => 'datetime',
        'Qty'         => 'integer',
        'Unit_Price'  => 'float',
        'Total_Price' => 'float',
    ];
}