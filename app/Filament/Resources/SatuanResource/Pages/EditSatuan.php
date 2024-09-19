<?php

namespace App\Filament\Resources\SatuanResource\Pages;

use App\Filament\Resources\SatuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSatuan extends EditRecord
{
    protected static string $resource = SatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
