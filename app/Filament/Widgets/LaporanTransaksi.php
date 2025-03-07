<?php

namespace App\Filament\Widgets;

use actions;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class LaporanTransaksi extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = DataTransaksi::query();
                if (Auth::user()->hasRole(7)) {
                    $query->where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id],
                        ['cabangs_id', '=', Auth::user()->cabangs_id]
                    ]);
                } else if (Auth::user()->hasRole(6)) {
                    $query->where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id]
                    ]);
                } else if (Auth::user()->hasRole(1)) {
                    $query->get();
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('cabang.nama_cabang')
                    ->label('Nama Cabang')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_transaksi')
                    ->label('Kode Transaksi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_staff')
                    ->label('Email Staff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keuntungan')
                    ->label('Keuntungan')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->required(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['end_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Transaksi')
                    ->modalContent(function ($record) {
                        return view('filament.tables.modals.view-transaction', ['record' => $record]);
                    })
                    ->color('primary'),
            ]);
    }
}
