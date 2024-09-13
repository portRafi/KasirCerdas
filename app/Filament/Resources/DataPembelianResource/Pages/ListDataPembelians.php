<?php

namespace App\Filament\Resources\DataPembelianResource\Pages;

use App\Filament\Resources\DataPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataPembelians extends ListRecords
{
    protected static string $resource = DataPembelianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            DataPembelianResource\Widgets\Date::class,
        ];
    }
}
