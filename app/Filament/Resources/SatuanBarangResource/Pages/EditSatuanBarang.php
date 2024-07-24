<?php

namespace App\Filament\Resources\SatuanBarangResource\Pages;

use App\Filament\Resources\SatuanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditSatuanBarang extends EditRecord
{
    protected static string $resource = SatuanBarangResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Edit Satuan Barang');
    }
}
