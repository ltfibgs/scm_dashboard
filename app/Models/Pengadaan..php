<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $table = 'data_pengadaan'; // Sesuaikan nama tabel pengadaan/procurement di phpMyAdmin Anda

    protected $primaryKey = 'PO_Number'; // Biasanya PO_Number atau Procurement_ID
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'PO_Number',
        'Supplier_ID',
        'Item_ID',
        'Order_Qty',
        'Cost_Per_Unit',
        'Total_Cost',
        'Order_Date',
        'Status'
    ];
}