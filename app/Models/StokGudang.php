<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokGudang extends Model
{
    // Nama tabel disesuaikan dengan skema SCM (biasanya data_stok_gudang atau sejenisnya)
    protected $table = 'data_stok_gudang'; 

    protected $primaryKey = 'Item_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Item_ID', 
        'Item_Name', 
        'Stock_Qty', 
        'Unit', 
        'Min_Stock', 
        'Supplier_ID', 
        'Unit_Cost'
    ];
}