<?php

namespace App\Filament\Resources\ModulBiayaResource\Pages;

use App\Filament\Resources\ModulBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModulBiaya extends EditRecord
{
    protected static string $resource = ModulBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
