<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Models\Barang;
use App\Models\Keranjang;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TransaksiResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    public function getTabs(): array
    {
        return [
            Tab::make('Barang')
                ->modifyQueryUsing(function (EloquentBuilder $query) {
                    return $query->from((new Barang())->getTable());
                }),

            Tab::make('Keranjang')
                ->modifyQueryUsing(function (EloquentBuilder $query) {
                    return $query->from((new Keranjang())->getTable())->orderBy('id', 'asc');
                }),

        ];
    }

    protected function getTableColumns(): array
    {
        if ($this->getActiveTab()->getLabel() === 'List Barang') {
            return [
                TextColumn::make('nama')
                    ->label('Nama Barang'),
                TextColumn::make('harga_jual')
                    ->label('Harga'),
                TextColumn::make('stok')
                    ->label('Stok'),
            ];
        }

        if ($this->getActiveTab()->getLabel() === 'Keranjang') {
            return [
                TextColumn::make('kode')
                    ->label('Kode Barang'),
                TextColumn::make('nama')
                    ->label('Nama Barang'),
                TextColumn::make('quantity')
                    ->label('Quantity'),
                TextColumn::make('total_harga')
                    ->label('Total Harga'),
            ];
        }

        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TransaksiResource\Widgets\TransaksiWidget::class,
        ];
    }
}
