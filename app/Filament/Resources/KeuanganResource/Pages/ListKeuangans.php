<?php

namespace App\Filament\Resources\KeuanganResource\Pages;

use App\Filament\Resources\KeuanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeuangans extends ListRecords
{
    protected static string $resource = KeuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            KeuanganResource\Widgets\KeuanganWidget::class,
            KeuanganResource\Widgets\GrafikKeuntungan::class,
            KeuanganResource\Widgets\GrafikTransaksi::class,
        ];
    }
}
