<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Models\BarangAfterCheckout;
use Filament\Tables;
use App\Models\Pajak;
use App\Models\Keranjang;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use App\Models\DataTransaksi;
use App\Models\MetodePembayaran;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
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
                Tables\Columns\TextColumn::make('harga_beli'),
                Tables\Columns\TextColumn::make('harga_jual'),
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Barang'),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Barang'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->summarize(Sum::make()->money('IDR'))
            ])
            ->headerActions([
                Action::make('checkout')
                    ->label('Checkout')
                    ->button()
                    ->form([
                        TextInput::make('total_harga_after_pajak')
                            ->label('Total Harga Setelah Pajak (readonly)')
                            ->readOnly()
                            ->prefix('IDR')
                            ->default(function () {
                                $totalHarga = Keranjang::sum('total_harga') ?: 0;
                                $totalHargaDenganPajak = $this->calculateTotalHargaWithPajak($totalHarga);

                                return $totalHargaDenganPajak;
                            }),
                        Select::make('metode_pembayaran')
                            ->required()
                            ->label('Pilih Metode Pembayaran')
                            ->options(MetodePembayaran::active()->pluck('nama_mp', 'id')),
                    ])
                    ->action(function ($record, $data) {
                        $randomString = Str::random(5);
                        $keuntungan = Keranjang::all()->sum(function($item) {
                            return ($item->harga_jual - $item->harga_beli) * $item->quantity;
                        });
                        $metodePembayaran = MetodePembayaran::find($data['metode_pembayaran'])->nama_mp;
                        DataTransaksi::create([
                            'kode_transaksi' => $randomString,
                            //todo
                            'email_staff' => $randomString, 
                            'metode_pembayaran' => $metodePembayaran,
                            'total_harga' => Keranjang::sum('total_harga'),
                            'total_harga_after_pajak' => $data['total_harga_after_pajak'],
                            'keuntungan' => $keuntungan
                        ]);
                        //todo
                        // BarangAfterCheckout::create([
                        //     'kode_transaksi' => $randomString,
                        //     'kode' => $record->kode,
                        //     'kategori' => $record->kategori,
                        //     'nama' => $record->nama,
                        //     'quantity' => $record->quantity,
                        //     'total_harga' => $record->total_harga,
                        // ]);
                        Keranjang::truncate();
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
                                'harga_beli' => $record->harga_beli * $data['quantity'],
                                'harga_jual' => $record->harga_jual * $data['quantity'],
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
