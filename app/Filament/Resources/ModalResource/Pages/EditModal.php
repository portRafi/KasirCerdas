<?php

namespace App\Filament\Resources\ModalResource\Pages;

use App\Filament\Resources\ModalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModal extends EditRecord
{
    protected static string $resource = ModalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
