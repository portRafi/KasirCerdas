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

    // public function getTabs(): array
    // {
    //     return [
    //         'List Barang' => Tab::make('Barang')
    //             ->modifyQueryUsing(function (EloquentBuilder $query) {
    //                 return $query->from((new Barang())->getTable());
    //             }),

    //         'Keranjang' => Tab::make('Keranjang')
    //             ->modifyQueryUsing(function (EloquentBuilder $query) {
    //                 return $query->from((new Keranjang())->getTable())->orderBy('id', 'asc');
    //             }),

    //     ];
    // }

    protected function getHeaderWidgets(): array
    {
        return [
            TransaksiResource\Widgets\TransaksiWidget::class,
            TransaksiResource\Widgets\KeranjangWidget::class,
        ];
    }
}
