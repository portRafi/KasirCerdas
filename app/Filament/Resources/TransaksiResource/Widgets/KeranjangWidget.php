<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Tables;
use App\Models\Pajak;
use App\Models\Keranjang;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\DataTransaksi;
use App\Models\MetodePembayaran;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Widgets\TableWidget as BaseWidget;

class KeranjangWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    public function calculateTotalHargaWithPajak($totalHarga)
    {
        $jumlahPajakTotal = Pajak::sum('jumlah_pajak');
        $jumlahTotalPajak = $totalHarga * ($jumlahPajakTotal / 100);
        $totalHargaDenganPajak = $totalHarga + $jumlahTotalPajak;

        return $totalHargaDenganPajak;
    }

    public function table(Table $table): Table
    {

        return $table
            ->emptyStateHeading('Keranjang Kosong')
            ->emptyStateDescription('Barang yang dimasukkan ke keranjang akan muncul disini')->emptyStateIcon('heroicon-s-shopping-cart')
            ->query(
                Keranjang::query()
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Barang'),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Barang'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('diskon')
                    ->hidden(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->summarize(Sum::make()->money('IDR'))
            ])
            ->headerActions([

                SelectAction::make('nama_mp')
                    ->label('Metode Pembayaran')
                    ->color('primary')
                    ->options(MetodePembayaran::active()->pluck('nama_mp', 'id')),
                Action::make('checkout')
                    ->label('Checkout')
                    ->button()
                    ->form([
                        TextInput::make('total_harga_after_pajak')
                            ->label('Total Harga Setelah Pajak')
                            ->readOnly()
                            ->mask(RawJs::make('$money($input)'))
                            ->prefix('IDR')
                            ->default(function () {
                                $totalHarga = Keranjang::sum('total_harga') ?: 0;
                                $totalHargaDenganPajak = $this->calculateTotalHargaWithPajak($totalHarga);

                                return $totalHargaDenganPajak;
                            }),
                        TextInput::make('nama_mp')
                            ->label('Metode Pembayaran')
                            ->default(function () {
                                $totalHarga = Keranjang::sum('total_harga') ?: 0;
                                $totalHargaDenganPajak = $this->calculateTotalHargaWithPajak($totalHarga);

                                return $totalHargaDenganPajak;
                            }),
                        
                    ])
                    ->action(function ($record, $data) {
                        $DataTransaksi = DataTransaksi::find($record->id);
                        if ($DataTransaksi) {
                            $DataTransaksi->update([
                                'total_harga' => $data['total_harga'],
                            ]);
                        }
                        Notification::make()
                            ->title('Checkout Processed')
                            ->icon('heroicon-m-check-circle')
                            ->iconColor('success')
                            ->send();
                    }),
            ])
            ->actions([
                Action::make('edit')
                    ->label('Edit')
                    ->form([
                        TextInput::make('quantity')->label('Quantity')->required()->numeric()->minValue(1),
                    ])
                    ->action(function ($record, $data) {
                        $totDiskon = $record->harga_jual * ($record->diskon / 100);
                        $keranjang = Keranjang::find($record->id);
                        if ($keranjang) {
                            $keranjang->update([
                                'quantity' => $data['quantity'],
                                'total_harga' => $record->harga_jual * $data['quantity'] - $totDiskon,
                            ]);
                        }
                        Notification::make()
                            ->title('Quantity Barang Di edit')
                            ->icon('heroicon-m-pencil-square')
                            ->iconColor('success')
                            ->send();
                    })
                    ->icon('heroicon-m-pencil-square'),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
