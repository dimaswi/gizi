<?php

namespace App\Filament\Resources\SatuanBarangResource\Pages;

use App\Filament\Resources\SatuanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSatuanBarang extends CreateRecord
{
    protected static string $resource = SatuanBarangResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Tambah Satuan');
    }
}
