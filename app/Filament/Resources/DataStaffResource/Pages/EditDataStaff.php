<?php

namespace App\Filament\Resources\DataStaffResource\Pages;

use App\Filament\Resources\DataStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataStaff extends EditRecord
{
    protected static string $resource = DataStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
