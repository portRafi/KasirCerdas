<?php

namespace App\Filament\Resources\LabaRugiResource\Pages;

use App\Filament\Resources\LabaRugiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabaRugis extends ListRecords
{
    protected static string $resource = LabaRugiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
