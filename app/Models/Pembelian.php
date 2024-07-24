<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nomor',
        'nomor_transaksi',
        'nomor_nota',
        'suplayer',
        'tipe_pembelian',
        'diskon',
        'ppn',
        'keterangan',
        'foto',
        'total_harga'
    ];

    public function item()
    {
        return $this->hasMany(ItemsPembelian::class);
    }

    public function toko()
    {
        return $this->belongsTo(Suplayer::class, 'suplayer');
    }
}
