<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function itemBarang()
    {
        return $this->hasMany(Barang::class, 'id');
    }
}
