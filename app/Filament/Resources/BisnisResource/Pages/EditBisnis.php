<?php

namespace App\Filament\Resources\BisnisResource\Pages;

use App\Filament\Resources\BisnisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBisnis extends EditRecord
{
    protected static string $resource = BisnisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
