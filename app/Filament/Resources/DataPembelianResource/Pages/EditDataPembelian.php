<?php

namespace App\Filament\Resources\DataPembelianResource\Pages;

use App\Filament\Resources\DataPembelianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPembelian extends EditRecord
{
    protected static string $resource = DataPembelianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
