<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianResource\Pages;
use App\Filament\Resources\PembelianResource\RelationManagers;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Suplayer;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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

class PembelianResource extends Resource
{
    protected static ?string $model = Pembelian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Nota';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $nota = Pembelian::orderBy('created_at', 'desc')->first();

        if ($nota == null) {
            $nomor = 1;
        } else {
            $nomor = $nota->nomor + 1;
        }

        $nomor_transaksi = str_pad($nomor, 6, '0', STR_PAD_LEFT);

        return $form
            ->schema([
                Card::make()->schema([
                    Hidden::make('nomor')->default($nomor),
                    TextInput::make('nomor_transaksi')->readOnly()->default('TRX-GZ-' . $nomor_transaksi)->required()->columnSpanFull(),
                    TextInput::make('nomor_nota')->required()->placeholder('Masukan Nomor Nota'),
                    Select::make('suplayer')->searchable()->options(Suplayer::all()->pluck('nama_suplayer', 'id'))->required(),
                    Select::make('tipe_pembelian')->options([
                        'CASH' => 'CASH',
                        'TEMPO' => 'TEMPO'
                    ])->required(),
                    TextInput::make('total_harga')->required()->prefix('Rp.')->placeholder('Masukan Total Harga')->numeric(),
                    TextInput::make('diskon')->required()->prefix('Rp.')->default(0)->numeric(),
                    TextInput::make('ppn')->required()->prefix('Rp.')->default(0)->numeric(),
                    Textarea::make('keterangan')->columnSpanFull()->placeholder('Masukan Keterangan'),
                    FileUpload::make('foto')->required()->columnSpanFull()
                ])->columns(2),

                Card::make()->schema([
                    Placeholder::make('Pembelian'),
                    Repeater::make('item')->label('Daftar Barang')->relationship()->schema([
                        Select::make('nama_barang')
                            ->searchable()
                            ->options(Barang::whereMonth('stok_opname', Carbon::now()->month)->pluck('nama_barang', 'id'))
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $harga = Barang::where('id', $state)->value('harga');
                                $set('harga_lama', $harga);
                            }),
                        TextInput::make('jumlah_barang')->required()->numeric()->placeholder('Masukan Jumlah'),
                        TextInput::make('harga_lama')->required()->numeric()->readOnly(),
                        TextInput::make('harga_baru')->required()->numeric()->placeholder('Masukan Baru'),
                    ])->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        $stok = Barang::where('id', $data['nama_barang'])->first();
                        Barang::where('id', $data['nama_barang'])->update([
                            'jumlah_barang' => $stok->jumlah_barang + $data['jumlah_barang'],
                            'total_harga' => ($data['harga_baru'] * $data['jumlah_barang']) + $stok->total_harga
                        ]);

                        return $data;
                    })->columns(4)
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
                TextColumn::make('toko.nama_suplayer')->searchable()->sortable()->alignCenter(),
                TextColumn::make('nomor_transaksi')->badge()->searchable()->sortable()->alignCenter(),
                TextColumn::make('nomor_nota')->searchable()->sortable()->alignCenter(),
                TextColumn::make('total_harga')->searchable()->sortable()->alignCenter()->money('IDR')->badge(),
                TextColumn::make('tipe_pembelian')->badge()->color(fn (string $state): string => match ($state) {
                    'TEMPO' => 'warning',
                    'CASH' => 'success',
                })->searchable()->sortable()->alignCenter(),
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
            'index' => Pages\ListPembelians::route('/'),
            'create' => Pages\CreatePembelian::route('/create'),
            'edit' => Pages\EditPembelian::route('/{record}/edit'),
        ];
    }
}
