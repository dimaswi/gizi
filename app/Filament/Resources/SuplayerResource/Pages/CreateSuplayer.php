<?php

namespace App\Filament\Resources\SuplayerResource\Pages;

use App\Filament\Resources\SuplayerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSuplayer extends CreateRecord
{
    protected static string $resource = SuplayerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Tambah Suplayer');
    }
}
