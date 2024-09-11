<?php

namespace App\Filament\Resources\KeunganResource\Pages;

use App\Filament\Resources\KeunganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeungan extends EditRecord
{
    protected static string $resource = KeunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
