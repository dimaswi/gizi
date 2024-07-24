<?php

namespace App\Filament\Resources\KategoriBarangResource\Pages;

use App\Filament\Resources\KategoriBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateKategoriBarang extends CreateRecord
{
    protected static string $resource = KategoriBarangResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Tambah Kategori Barang');
    }
}
