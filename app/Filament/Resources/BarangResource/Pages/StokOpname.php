<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use App\Models\Barang;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class StokOpname extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = BarangResource::class;

    protected static string $view = 'filament.resources.barang-resource.pages.stok-opname';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Barang::query()->whereMonth('stok_opname', '!=', Carbon::now()->month))
            ->recordUrl(
                function () {
                    return null;
                }
            )
            ->columns([
                TextColumn::make('nama_barang')->searchable()->sortable()->label('Nama Barang'),
                TextColumn::make('itemSatuan.kode')->searchable()->label('Satuan')->badge()->alignCenter(),
                TextColumn::make('itemKategori.nama_kategori')->searchable()->badge()->label('Kategori'),
                TextColumn::make('jumlah_barang')->searchable()->alignCenter(),
                TextColumn::make('harga')->searchable()->sortable()->label('Harga')->money('IDR')->badge(),
                TextColumn::make('stok_opname')->searchable()->sortable()->datetime('d-m-Y H:i:s'),
                TextColumn::make('total_harga')->summarize(Sum::make()->label('Total'))->money('IDR'),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('stok_opname')->color('success')->icon('heroicon-m-circle-stack')
                        ->form([
                            TextInput::make('barang_terpakai')->required()->placeholder('Masukan Barang Terpakai')->label('Sisa Stok'),
                        ])
                        ->action(function (array $data, Barang $record): void {
                            Barang::where('id', $record->id)->update([
                                'jumlah_barang' => $record->jumlah_barang - $data['barang_terpakai'],
                                'updated_at' => Carbon::now()
                            ]);

                            Barang::create([
                                'kategori_id' => $record->kategori_id,
                                'nama_barang' => $record->nama_barang,
                                'jumlah_barang' => $data['barang_terpakai'],
                                'satuan' => $record->satuan,
                                'stok_opname' => Carbon::now(),
                                'harga' => $record->harga,
                                'total_harga' => $record->harga * $data['barang_terpakai'],
                            ]);

                            Notification::make()
                                ->title($record->nama_barang . ' Berhasil ditambahkan ke Stok Opname')
                                ->success()
                                ->send();
                        })
                ])
            ])->filters([
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
            ]);
    }
}
