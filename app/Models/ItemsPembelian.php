<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsPembelian extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'pembelian_id',
        'nama_barang',
        'harga_lama',
        'harga_baru',
        'jumlah_barang',
    ];

    public function nota()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }
}
