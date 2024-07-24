<?php

namespace App\Filament\Resources\KategoriBarangResource\Pages;

use App\Filament\Resources\KategoriBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListKategoriBarangs extends ListRecords
{
    protected static string $resource = KategoriBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus-circle')->label('Tambah')->color('success'),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('Kategori Barang');
    }
}
