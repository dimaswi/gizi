<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanBarang extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_satuan',
        'kode',
        'deskripsi',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id');
    }
}
