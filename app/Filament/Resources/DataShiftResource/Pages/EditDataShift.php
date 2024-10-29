<?php

namespace App\Filament\Resources\DataShiftResource\Pages;

use App\Filament\Resources\DataShiftResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataShift extends EditRecord
{
    protected static string $resource = DataShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
