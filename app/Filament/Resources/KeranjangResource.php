<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeranjangResource\Pages;
use App\Filament\Resources\KeranjangResource\RelationManagers;
use App\Models\Keranjang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KeranjangResource extends Resource
{
    protected static ?string $model = Keranjang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode Barang'),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Barang'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity'),
                Tables\Columns\TextColumn::make('total_harga')  
                    ->label('Total Harga'),
            ])
            ->filters([
                //
            ])

            ->action(function($record, $data){
                $keranjangs = Keranjang::with('barang')->where('barangs.id', $id)->get();
                if ($keranjang) {
                    $keranjang->update([
                        'quantity' => $data['quantity'],
                        'total_harga' => $record->harga_jual * $data['quantity'] * (1 - $record->diskon / 100),
                    ]);
                }
            })
            // ->actions([
            //     ->action(function ($record, $data) {
            //         Keranjang::create([
            //             'kode' => $record->kode,
            //             'nama' => $record->nama,
            //             'kategori' => $record->kategori,
            //             'harga_jual' => $record->harga_jual,
            //             'total_harga' => $record->harga_jual * $data['quantity'] * (1 - $record->diskon / 100),
            //             'kode_barang' => $record->kode_barang,
            //             'quantity' => $data['quantity'],
            //         ]);
            //         Notification::make()
            //             ->title('Barang Dimasukkan ke Keranjang')
            //             ->icon('heroicon-s-shopping-bag')
            //             ->iconColor('success')
            //             ->send();
            //     })
            // ])
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
            'index' => Pages\ListKeranjangs::route('/'),
            'create' => Pages\CreateKeranjang::route('/create'),
            'edit' => Pages\EditKeranjang::route('/{record}/edit'),
        ];
    }
}
