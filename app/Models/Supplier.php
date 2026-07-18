<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // gunakan tabel eksisting (sesuai instruksi: jangan ganti struktur yang ada)
    protected $table = 'supplier';

    protected $primaryKey = 'Supplier_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Supplier_ID', 
        'Supplier_Name', 
        'Category', 
        'Contact_Person', 
        'City'
    ];
}