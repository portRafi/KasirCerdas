<?php

namespace App\Filament\Resources\PenjualanBarangResource\Pages;

use App\Filament\Resources\PenjualanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenjualanBarang extends EditRecord
{
    protected static string $resource = PenjualanBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
