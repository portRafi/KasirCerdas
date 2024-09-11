<?php

namespace App\Filament\Resources\PenjualanBarangResource\Pages;

use App\Filament\Resources\PenjualanBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenjualanBarangs extends ListRecords
{
    protected static string $resource = PenjualanBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
