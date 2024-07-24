<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'jumlah_barang',
        'harga',
        'satuan',
        'stok_opname',
        'total_harga',
    ];

    public function itemKategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function itemSatuan()
    {
        return $this->belongsTo(SatuanBarang::class, 'satuan');
    }
}
