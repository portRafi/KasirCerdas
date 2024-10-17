<?php

namespace App\Filament\Resources\MetodePembayaranResource\Pages;

use App\Filament\Resources\MetodePembayaranResource;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ListMetodePembayarans extends ListRecords
{
    protected static string $resource = MetodePembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array {
        return [
            Tab::make('Semua'),
            Tab::make('Aktif')
                ->modifyQueryUsing(function(EloquentBuilder $query) {
                    $query->where('is_Active', true);
                }),
            Tab::make('Tidak Aktif')
                ->modifyQueryUsing(function(EloquentBuilder $query) {
                    $query->where('is_Active', false);
                }),
        ];
    }
    public function getTitle(): string
    {
        return __('Data Metode Pembayaran');
    }
    
}
