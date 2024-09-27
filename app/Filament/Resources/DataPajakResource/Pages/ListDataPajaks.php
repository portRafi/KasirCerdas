<?php

namespace App\Filament\Resources\DataPajakResource\Pages;

use App\Filament\Resources\DataPajakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataPajaks extends ListRecords
{
    protected static string $resource = DataPajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
