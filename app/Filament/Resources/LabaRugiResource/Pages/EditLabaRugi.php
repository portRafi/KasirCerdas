<?php

namespace App\Filament\Resources\LabaRugiResource\Pages;

use App\Filament\Resources\LabaRugiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabaRugi extends EditRecord
{
    protected static string $resource = LabaRugiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
