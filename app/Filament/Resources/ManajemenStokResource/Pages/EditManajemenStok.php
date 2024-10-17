<?php

namespace App\Filament\Resources\ManajemenStokResource\Pages;

use App\Filament\Resources\ManajemenStokResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenStok extends EditRecord
{
    protected static string $resource = ManajemenStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
