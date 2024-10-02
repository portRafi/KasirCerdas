<?php

namespace App\Filament\Resources\DataTransaksiResource\Pages;

use App\Filament\Resources\DataTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataTransaksis extends ListRecords
{
    protected static string $resource = DataTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return __('Data Transaksi');
    }
}
