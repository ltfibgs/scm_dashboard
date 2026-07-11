<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    // Nama tabel sesuai di database .sql kamu
    protected $table = '3__dataset_penjualan_sepatu';

    protected $primaryKey = 'Order_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

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
}