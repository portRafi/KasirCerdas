<?php

namespace App\Filament\Resources\DataTransaksiResource\Pages;

use App\Filament\Resources\DataTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataTransaksi extends EditRecord
{
    protected static string $resource = DataTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
