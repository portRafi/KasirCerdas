<?php

namespace App\Filament\Resources\PenjualanKategoriResource\Pages;

use App\Filament\Resources\PenjualanKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenjualanKategori extends EditRecord
{
    protected static string $resource = PenjualanKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
