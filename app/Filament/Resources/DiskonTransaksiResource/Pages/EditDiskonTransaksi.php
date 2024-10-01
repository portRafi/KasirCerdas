<?php

namespace App\Filament\Resources\DiskonTransaksiResource\Pages;

use App\Filament\Resources\DiskonTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiskonTransaksi extends EditRecord
{
    protected static string $resource = DiskonTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
