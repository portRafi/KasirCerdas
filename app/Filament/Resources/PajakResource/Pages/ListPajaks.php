<?php

namespace App\Filament\Resources\PajakResource\Pages;

use App\Filament\Resources\PajakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPajaks extends ListRecords
{
    protected static string $resource = PajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
