<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\SatuanBarang;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationLabel = 'Barang / Bahan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('nama_barang')->required()->placeholder('Masukan Nama Barang'),
                    Select::make('satuan')->required()->options(SatuanBarang::all()->pluck('kode', 'id')),
                    Select::make('kategori_id')->options(KategoriBarang::all()->pluck('nama_kategori', 'id'))->searchable(),
                    DateTimePicker::make('stok_opname')->required(),
                    TextInput::make('jumlah_barang')->numeric()->required()->placeholder('Masukan Jumlah Barang')
                        ->live()
                        ->afterStateUpdated(function (Get $get, callable $set, $state) {
                            $total = $state * $get('harga');

                            $set('total_harga', $total);
                        }),
                    TextInput::make('harga')->numeric()->required()->placeholder('Masukan Harga')->prefix('Rp.')
                        ->live()
                        ->afterStateUpdated(function (Get $get, callable $set, $state) {
                            $total = $get('jumlah_barang') * $state;

                            $set('total_harga', $total);
                        }),
                    TextInput::make('total_harga')->numeric()->required()->readOnly()->prefix('Rp.')->columnSpanFull(),
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
            ->modifyQueryUsing(function (Builder $query) {
                return $query->whereMonth('stok_opname', Carbon::now()->month);
            })
            ->columns([
                TextColumn::make('nama_barang')->searchable()->sortable()->label('Nama Barang'),
                TextColumn::make('itemSatuan.kode')->searchable()->label('Satuan')->badge()->alignCenter(),
                TextColumn::make('itemKategori.nama_kategori')->searchable()->badge()->label('Kategori'),
                TextColumn::make('jumlah_barang')->searchable()->alignCenter(),
                TextColumn::make('harga')->searchable()->sortable()->label('Harga')->money('IDR')->badge(),
                TextColumn::make('stok_opname')->searchable()->sortable()->datetime('d-m-Y H:i:s'),
                TextColumn::make('total_harga')->summarize(Sum::make()->label('Total'))->money('IDR'),
            ])
            ->filters([
                Filter::make('stok_opname')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('stok_opname', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('stok_opname', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make('table')->fromTable(),
                ])
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

    public static function updateTotals(Get $get, Set $set): void
    {
        // Calculate subtotal based on the selected products and quantities

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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
            'stok_opname' => Pages\StokOpname::route('/stok_opname'),
        ];
    }
}
