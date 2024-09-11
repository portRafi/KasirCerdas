<?php

namespace App\Filament\Resources\ModulBiayaResource\Pages;

use App\Filament\Resources\ModulBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModulBiayas extends ListRecords
{
    protected static string $resource = ModulBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
