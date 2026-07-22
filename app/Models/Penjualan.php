<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

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

    protected $casts = [
        'Timestamp'   => 'datetime',
        'Qty'         => 'integer',
        'Unit_Price'  => 'float',
        'Total_Price' => 'float',
    ];

    /**
     * RELASI: Satu Pesanan Penjualan Memiliki Satu Data Pengiriman
     */
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'Order_ID', 'Order_ID');
    }
}