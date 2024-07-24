<?php

namespace App\Filament\Resources\SuplayerResource\Pages;

use App\Filament\Resources\SuplayerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSuplayers extends ListRecords
{
    protected static string $resource = SuplayerResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Daftar Suplayer');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus-circle')->label('Tambah')->color('success'),
        ];
    }
}
