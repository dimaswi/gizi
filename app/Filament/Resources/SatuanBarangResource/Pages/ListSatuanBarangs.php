<?php

namespace App\Filament\Resources\SatuanBarangResource\Pages;

use App\Filament\Resources\SatuanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSatuanBarangs extends ListRecords
{
    protected static string $resource = SatuanBarangResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Satuan Barang');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus-circle')->label('Tambah')->color('success'),
        ];
    }
}
