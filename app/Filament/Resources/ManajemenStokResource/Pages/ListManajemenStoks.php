<?php

namespace App\Filament\Resources\ManajemenStokResource\Pages;

use App\Filament\Resources\ManajemenStokResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenStoks extends ListRecords
{
    protected static string $resource = ManajemenStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return __('Manajemen Stok');
    }
}
