<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatuanBarangResource\Pages;
use App\Filament\Resources\SatuanBarangResource\RelationManagers;
use App\Models\SatuanBarang;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SatuanBarangResource extends Resource
{
    protected static ?string $model = SatuanBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Satuan Barang';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('nama_satuan')->required()->placeholder('Masukan Nama Satuan'),
                    TextInput::make('kode')->required()->placeholder('Masukan Kode Satuan'),
                    Textarea::make('deskripsi')->required()->placeholder('Masukan Deskripsi')->columnSpanFull(),
                ])->columns(2)
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
                TextColumn::make('nama_satuan')->searchable()->sortable(),
                TextColumn::make('kode')->searchable()->sortable()->badge(),
                TextColumn::make('deskripsi')->limit(20),
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
            'index' => Pages\ListSatuanBarangs::route('/'),
            'create' => Pages\CreateSatuanBarang::route('/create'),
            'edit' => Pages\EditSatuanBarang::route('/{record}/edit'),
        ];
    }
}
