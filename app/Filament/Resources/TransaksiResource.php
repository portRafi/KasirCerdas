<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use App\Models\Keranjang;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransaksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Filament\Resources\TransaksiResource\Widgets\TransaksiWidget;


class TransaksiResource extends Resource
{
    protected static ?string $model = Keranjang::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $activeNavigationIcon = 'heroicon-s-building-storefront';
    protected static ?string $navigationLabel = 'POS / KASIR';
    protected static ?string $navigationGroup = 'POS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('15s')
            ->query(
                Barang::where([
                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                    ['cabangs_id', '=', Auth::user()->cabangs_id],
                    ['stok', '>', 0],
                ])
            )
            ->heading('Point Of Sales')
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->money('IDR')
                    ->hidden(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('diskon')
                    ->formatStateUsing(fn ($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.'))
                    ->sortable(),
            ])
            ->filters([
                //
                //
            ])

            ->actions([
                Action::make('addToCart')
                    ->label('Add')
                    ->button()
                    ->form([
                        TextInput::make('quantity')->label('Quantity')->required()->numeric()->minValue(1),
                    ])
                    ->action(function ($record, $data) {
                        $itemAlreadyAdd = Keranjang::where('userid', Auth::user()->id)
                            ->where('kode', $record->kode)
                            ->first();
                        if ($itemAlreadyAdd) {
                            Notification::make()
                                ->title('Barang sudah ada di keranjang')
                                ->icon('heroicon-s-exclamation-circle')
                                ->iconColor('danger')
                                ->send();
                        } elseif($data['quantity'] > $record->stok) {
                            Notification::make()
                                ->title('Quantity melebihi stok yang tersedia')
                                ->icon('heroicon-s-exclamation-circle')
                                ->iconColor('danger')
                                ->send();
                        } else {
                            $totalDiskon = ($record->diskon <= 100) ? $record->harga_jual * ($record->diskon / 100) : $record->diskon;
                            Keranjang::create([
                                'userid' => Auth::user()->id,
                                'bisnis_id' => Auth::user()->bisnis_id,
                                'cabangs_id' => Auth::user()->cabangs_id,
                                'kode' => $record->kode,
                                'nama' => $record->nama,
                                'kategori' => $record->kategori,
                                'harga_beli' => $record->harga_beli,
                                'harga_jual' => $record->harga_jual,
                                'total_harga' => $record->harga_jual * $data['quantity'] - $totalDiskon,
                                'quantity' => $data['quantity'],
                                'diskon' => $record->diskon
                            ]);

                            Notification::make()
                                ->title('Barang dimasukkan ke keranjang')
                                ->icon('heroicon-s-shopping-bag')
                                ->iconColor('success')
                                ->send();
                        }
                    })
                    ->icon('heroicon-s-plus-circle'),

            ])
            ->bulkActions([]);
    }

    public static function getWidgets(): array

    {
        return [
            TransaksiWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
        ];
    }
}
