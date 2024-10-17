<?php

namespace App\Filament\Resources\DataPajakResource\Pages;

use App\Filament\Resources\DataPajakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPajak extends EditRecord
{
    protected static string $resource = DataPajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
