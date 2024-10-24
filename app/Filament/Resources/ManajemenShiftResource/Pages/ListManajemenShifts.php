<?php

namespace App\Filament\Resources\ManajemenShiftResource\Pages;

use App\Filament\Resources\ManajemenShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenShifts extends ListRecords
{
    protected static string $resource = ManajemenShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
