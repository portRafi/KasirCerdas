<?php

namespace App\Filament\Resources\KasirResource\Pages;

use App\Filament\Resources\KasirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKasir extends EditRecord
{
    protected static string $resource = KasirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
