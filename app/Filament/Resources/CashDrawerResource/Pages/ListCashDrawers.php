<?php

namespace App\Filament\Resources\CashDrawerResource\Pages;

use App\Filament\Resources\CashDrawerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCashDrawers extends ListRecords
{
    protected static string $resource = CashDrawerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
