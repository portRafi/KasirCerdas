<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Keranjang;

class KerangjangWidget extends BaseWidget
{   

    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
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
                    Tables\Columns\TextColumn::make('total_harga')  
                        ->label('Total Harga'),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
