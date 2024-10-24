<?php
 
namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\DateTimePicker;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    // public function filtersForm(Form $form): Form
    // {
    //     return $form->schema([
    //         DatePicker::make('Dari Tanggal'),
    //         DatePicker::make('Sampai Tanggal')
    //     ]);
    // }
}