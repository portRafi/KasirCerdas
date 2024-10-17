<?php

namespace App\Filament\Resources\KeranjangResource\Pages;

use App\Filament\Resources\KeranjangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeranjang extends EditRecord
{
    protected static string $resource = KeranjangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
