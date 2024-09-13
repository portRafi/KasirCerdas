<?php

namespace App\Filament\Resources\DataPembelianResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Date extends Widget
{
    protected static string $view = 'filament.resources.data-pembelian-resource.widgets.date';

    public static string $resource = DataPembelianResource::class;
    use HasFiltersForm;
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            DatePicker::make('Dari Tanggal'),
            DatePicker::make('Sampai Tanggal')
            //
        ]);
    }

}
