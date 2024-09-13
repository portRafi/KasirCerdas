<?php

namespace App\Filament\Resources\DataPembelianResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;

class DateWidget extends Widget
{
    protected static string $view = 'filament.resources.data-pembelian-resource.widgets.date-widget';

    public function getFormSchema(): array
    {
        return [
            DatePicker::make('date_before')
                ->label('Tanggal Sebelum')
                ->required()
                ->placeholder('Pick a date')
                ->displayFormat('Y-m-d'),
            DatePicker::make('date_after')
                ->label('Tanggal Sesudah')
                ->required()
                ->placeholder('Pick a date')
                ->displayFormat('Y-m-d') 
        ];
    }
}
