<?php

namespace App\Filament\Widgets;

use App\Models\PenjualanBarang;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget; 

class LaporanPenjualanBarangWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query( 
                PenjualanBarang::query()
            )
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode'),
                TextColumn::make('nama')
                    ->label('Nama'),
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                TextColumn::make('total_pendapatan')
                    ->label('Total Pendapatan'),
                TextColumn::make('keuntungan')  
                    ->label('Keuntungan'),
            ]);
    }
}
