<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    // Diset tegas ke tabel 'pengiriman'
    protected $table = 'pengiriman';
    protected $primaryKey = 'Pengiriman_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Pengiriman_ID',
        'Order_ID',
        'Tujuan',
        'Qty_Kirim',
        'Kurir',
        'Status_Kirim'
    ];

    /**
     * RELASI: Pengiriman Milik dari Satu Pesanan Penjualan
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'Order_ID', 'Order_ID');
    }
}