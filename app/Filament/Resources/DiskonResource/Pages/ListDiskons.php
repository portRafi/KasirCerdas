<?php

namespace App\Filament\Resources\DiskonResource\Pages;

use App\Filament\Resources\DiskonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiskons extends ListRecords
{
    protected static string $resource = DiskonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
