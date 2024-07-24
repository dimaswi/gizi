<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;

    // public function getTabs(): array
    // {
    //     return [
    //         'active' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true)),
    //         'inactive' => Tab::make()
    //             ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false)),
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('stok_opname')->icon('heroicon-m-clipboard-document-list')->label('Stok Opname')->color('primary')->url('/admin/barangs/stok_opname'),
            Actions\CreateAction::make()->icon('heroicon-m-plus-circle')->label('Tambah')->color('success'),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('Barang / Bahan');
    }
}
