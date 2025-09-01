<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'barang_id',
        'jumlah',
        'total_harga',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
