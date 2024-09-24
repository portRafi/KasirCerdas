<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Filament\Resources\TransaksiResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class POSWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 1;
    public function table(Table $table): Table
    {
        return $table
            ->query(TransaksiResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('diskon')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
            ]);
    }
}
