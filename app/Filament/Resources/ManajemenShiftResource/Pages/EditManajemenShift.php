<?php

namespace App\Filament\Resources\ManajemenShiftResource\Pages;

use App\Filament\Resources\ManajemenShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenShift extends EditRecord
{
    protected static string $resource = ManajemenShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
