<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Tables;
use App\Models\Pajak;
use App\Models\Barang;
use App\Models\DataPajak;
use App\Models\Keranjang;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use App\Models\DataTransaksi;
use App\Models\MetodePembayaran;
use App\Models\BarangAfterCheckout;
use App\Models\DiskonTransaksi;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\SelectAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Summarizer;


class KeranjangWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function calculateTotalHargaWithPajak($totalHarga)
    {
        $jumlahPajakTotal = Pajak::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('jumlah_pajak');
        $jumlahTotalPajak = $totalHarga * ($jumlahPajakTotal / 100);
        $totalHargaDenganPajak = $totalHarga + $jumlahTotalPajak;

        return $totalHargaDenganPajak;
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->emptyStateHeading('Keranjang Kosong')
            ->emptyStateDescription('Barang yang dimasukkan ke keranjang akan muncul disini')->emptyStateIcon('heroicon-s-shopping-cart')
            ->query(
                Keranjang::where([
                    ['userid', '=', Auth::user()->id],
                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                    ['cabangs_id', '=', Auth::user()->cabangs_id]
                ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('diskon')
                    ->hidden(),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->hidden(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->hidden(),
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
                    ->summarize([
                        Summarizer::make()
                            ->label('Base Harga')
                            ->money('IDR')
                            ->using(function () {
                                $totalHarga = Keranjang::where([
                                    ['userid', '=', Auth::user()->id],
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                                ])->sum('total_harga');
                                return $totalHarga;
                            }),
                        Summarizer::make()
                            ->label('Harga [+] include pajak')
                            ->money('IDR')
                            ->using(function () {
                                $totalHarga = Keranjang::where([
                                    ['userid', '=', Auth::user()->id],
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                                ])->sum('total_harga');
                                $totalHargaDenganPajak = $this->calculateTotalHargaWithPajak($totalHarga);
                                return $totalHargaDenganPajak;
                            }),
                            Summarizer::make()
                            ->label('Total Harga [-] potongan diskon transaksi')
                            ->money('IDR')
                            ->using(function () {
                                
                                $totalHarga = Keranjang::where([
                                    ['userid', '=', Auth::user()->id],
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                                ])->sum('total_harga') ?: 0;
                        
                                
                                $totalDiskonTransaksi = DiskonTransaksi::where([
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                                    ['is_Active', '=', true], // kondisi untuk mengambil diskon aktif
                                ])->sum('jumlah_diskon') ?: 0;
                        
                                $totalHargaDenganDiskonTransaksi = ($totalDiskonTransaksi <= 100) ? $this->calculateTotalHargaWithPajak($totalHarga) - ($this->calculateTotalHargaWithPajak($totalHarga) * ($totalDiskonTransaksi / 100)) : $this->calculateTotalHargaWithPajak($totalHarga) - $totalDiskonTransaksi;
                                return $totalHargaDenganDiskonTransaksi;
                            }),
                        
                    ])

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
                                $totalHarga = Keranjang::where([
                                    ['userid', '=', Auth::user()->id],
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                                ])->sum('total_harga') ?: 0;
                                $totalHargaDenganPajak = $this->calculateTotalHargaWithPajak($totalHarga);
                                return $totalHargaDenganPajak;
                            }),
                            TextInput::make('total_harga_after_diskon_transaksi')
                            ->label('Total Harga Setelah Diskon Transaksi (readonly)')
                            ->readOnly()
                            ->prefix('Total')
                            ->default(function () {
                                $totalHarga = Keranjang::where([
                                    ['userid', '=', Auth::user()->id],
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                            ])->sum('total_harga') ?: 0;
                        
                                $diskonTransaksi = DiskonTransaksi::where([
                                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                                    ['cabangs_id', '=', Auth::user()->cabangs_id]
                                ])->first();
                        
                                // Inisialisasi total diskon
                                $totalDiskonTransaksi = 0;
                        
                                // Cek apakah diskon ada
                                if ($diskonTransaksi) {
                                    if ($diskonTransaksi->jumlah_diskon <= 100) {
                                        // Jika diskon persen
                                        $totalDiskonTransaksi = $totalHarga * ($diskonTransaksi->jumlah_diskon / 100);
                                    } elseif ($diskonTransaksi->jumlah_diskon >= 1000) {
                                        // Jika fixed price
                                        $totalDiskonTransaksi = $diskonTransaksi->jumlah_diskon;
                                    }
                                }
                        
                                // Hitung total harga setelah pajak dan diskon
                                $totalHargaDenganDiskonTransaksi = $this->calculateTotalHargaWithPajak($totalHarga) - $totalDiskonTransaksi;
                                
                                return $totalHargaDenganDiskonTransaksi;
                            }),

                        Select::make('metode_pembayaran')
                            ->required()
                            ->label('Pilih Metode Pembayaran')
                            ->options(MetodePembayaran::where([
                                ['bisnis_id', '=', Auth::user()->bisnis_id],
                                ['cabangs_id', '=', Auth::user()->cabangs_id]
                            ])->active()->pluck('nama_mp', 'id')),
                    ])
                    ->action(function ($record, $data) {
                        $randomString = 'KC_' . Str::random(5);
                        $keuntungan = Keranjang::where([
                            ['userid', '=', Auth::user()->id],
                            ['bisnis_id', '=', Auth::user()->bisnis_id],
                            ['cabangs_id', '=', Auth::user()->cabangs_id]
                        ])->get()->groupBy('nama')->map(function ($group) {
                            $item = $group->first();
                            $totalDiskonAfterTransaksi = DiskonTransaksi::where([
                                ['bisnis_id', '=', Auth::user()->bisnis_id],
                                ['cabangs_id', '=', Auth::user()->cabangs_id]
                            ])->sum('jumlah_diskon');
                            $totalHargaJual = ($item->diskon <= 100) ? ($item->harga_jual * $item->quantity) - ($item->harga_jual * ($item->diskon / 100)) : ($item->harga_jual * $item->quantity) - $item->diskon;
                            $totalHargaBeli = $item->harga_beli * $item->quantity;
                            return $totalHargaJual - $totalHargaBeli - $totalDiskonAfterTransaksi;
                        })->sum();
                        $metodePembayaran = MetodePembayaran::all()->get($data['metode_pembayaran'])->nama_mp;  
                        $emailStaff = Auth::user()->email;
                        $totalHargaAfterPajak = $data['total_harga_after_pajak'];
                        $totalDiskonTransaksi = DiskonTransaksi::where([
                            ['bisnis_id', '=', Auth::user()->bisnis_id],
                            ['cabangs_id', '=', Auth::user()->cabangs_id]
                        ])->sum('jumlah_diskon');;
                        $totalHarga = Keranjang::where([
                            ['userid', '=', Auth::user()->id],
                            ['bisnis_id', '=', Auth::user()->bisnis_id],
                            ['cabangs_id', '=', Auth::user()->cabangs_id]
                        ])->sum('total_harga') - $totalDiskonTransaksi;
                        $jumlahPajak = $totalHargaAfterPajak - $totalHarga;
                            
                        DataTransaksi::create([
                            'bisnis_id' => Auth::user()->bisnis_id,
                            'cabangs_id' => Auth::user()->cabangs_id,
                            'kode_transaksi' => $randomString,
                            'email_staff' => $emailStaff,
                            'metode_pembayaran' => $metodePembayaran,
                            'total_harga' => $totalHarga,
                            'total_harga_after_pajak' => $totalHargaAfterPajak,
                            'selisih_pajak' => $jumlahPajak,
                            'keuntungan' => $keuntungan
                        ]);
                        DataPajak::create([
                            'bisnis_id' => Auth::user()->bisnis_id,
                            'cabangs_id' => Auth::user()->cabangs_id,
                            'kode_transaksi' => $randomString,
                            'jumlah_pajak' => $jumlahPajak
                        ]);
                        $itemsInCart = Keranjang::where('userid', Auth::user()->id)->get();
                        foreach ($itemsInCart as $item) {
                            BarangAfterCheckout::create([
                                'bisnis_id' => Auth::user()->bisnis_id,
                                'cabangs_id' => Auth::user()->cabangs_id,
                                'kode_transaksi' => $randomString,
                                'kode' => $item->kode,
                                'kategori' => $item->kategori,
                                'nama' => $item->nama,
                                'quantity' => $item->quantity,
                                'total_harga' => $item->total_harga,
                                'harga_jual' => $item->harga_jual,
                                'harga_beli' => $item->harga_beli
                            ]);
                        }

                        Keranjang::where('userid', Auth::user()->id)->delete();

                        $notificationBody = '**Checkout Processed Successfully with the following items:**' . PHP_EOL;
                        foreach ($itemsInCart as $item) {
                            $notificationBody .= "_- {$item->nama} (Quantity: **{$item->quantity}**)_" . PHP_EOL;
                        }
                        $notificationBody .= "Total: **IDR " . number_format($totalHargaAfterPajak, 0, ',', '.') . "**" . PHP_EOL;
                        $notificationBody .= "Total Pajak: **IDR " . number_format($jumlahPajak, 0, ',', '.') . "**" . PHP_EOL;
                        $notificationBody .= "Total Bersih: **IDR " . number_format($totalHarga, 0, ',', '.') . "**" . PHP_EOL;
                        $notificationBody .= "Keuntungan: **IDR " . number_format($keuntungan, 0, ',', '.') . "**" . PHP_EOL;
                        $notificationBody .= "Metode Pembayaran: **" . $metodePembayaran . "**" . PHP_EOL;
                        $notificationBody .= "Kasir: **" . Auth::user()->email . "**" . PHP_EOL;

                        Notification::make()
                            ->title('Checkout Processed')
                            ->icon('heroicon-m-check-circle')
                            ->iconColor('success')
                            ->send()
                            ->body($notificationBody)
                            ->sendToDiscord();
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
                        $keranjang = Keranjang::where([
                            ['userid', '=', Auth::user()->id],
                            ['bisnis_id', '=', Auth::user()->bisnis_id],
                            ['cabangs_id', '=', Auth::user()->cabangs_id],
                        ])->get($record->id);
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