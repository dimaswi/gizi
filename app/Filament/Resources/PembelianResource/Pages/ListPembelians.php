<?php

namespace App\Filament\Resources\PembelianResource\Pages;

use App\Filament\Resources\PembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListPembelians extends ListRecords
{
    protected static string $resource = PembelianResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Nota Pembelian');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus-circle')->label('Tambah')->color('success'),
        ];
    }
}
