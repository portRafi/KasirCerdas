<?php

namespace App\Filament\Resources\ModalResource\Pages;

use App\Filament\Resources\ModalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModals extends ListRecords
{
    protected static string $resource = ModalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
