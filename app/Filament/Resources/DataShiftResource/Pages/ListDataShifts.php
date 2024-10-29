<?php

namespace App\Filament\Resources\DataShiftResource\Pages;

use App\Filament\Resources\DataShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataShifts extends ListRecords
{
    protected static string $resource = DataShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
