<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplayer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nama_suplayer',
        'alamat_suplayer',
        'nomor_suplayer',
    ];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
