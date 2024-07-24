<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuplayerResource\Pages;
use App\Filament\Resources\SuplayerResource\RelationManagers;
use App\Models\Suplayer;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuplayerResource extends Resource
{
    protected static ?string $model = Suplayer::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Master Suplayer';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('nama_suplayer')->required()->placeholder('Masukan Nama Suplayer'),
                    TextInput::make('alamat_suplayer')->required()->placeholder('Masukan Alamat Suplayer'),
                    TextInput::make('nomor_suplayer')->required()->placeholder('Masukan Nomor Suplayer'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                function () {
                    return null;
                },
            )
            ->columns([
                TextColumn::make('nama_suplayer')->searchable()->sortable(),
                TextColumn::make('alamat_suplayer')->searchable()->limit(20),
                TextColumn::make('nomor_suplayer')->searchable()->sortable()->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuplayers::route('/'),
            'create' => Pages\CreateSuplayer::route('/create'),
            'edit' => Pages\EditSuplayer::route('/{record}/edit'),
        ];
    }
}
