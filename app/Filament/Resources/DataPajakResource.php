<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cabang;
use Filament\Forms\Form;
use App\Models\DataPajak;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataPajakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DataPajakResource\RelationManagers;
use Filament\Tables\Columns\Summarizers\Sum;

class DataPajakResource extends Resource
{
    protected static ?string $model = DataPajak::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $activeNavigationIcon = 'heroicon-s-tag';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Data Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = DataPajak::query();
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
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')
                    ->searchable()
                    ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('jumlah_pajak')
                    ->label('Jumlah Pajak')
                    ->money('IDR')
                    ->summarize(Sum::make())
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('cabangs_id')
                    ->label('Cabang')
                    ->options(
                        Cabang::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama_cabang', 'id')->toArray()
                    ),
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->required(),
                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            isset($data['start_date']) && isset($data['end_date']),
                            function (Builder $query) use ($data): Builder {
                                return $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
                            }
                        );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPajaks::route('/'),
            'create' => Pages\CreateDataPajak::route('/create'),
            'edit' => Pages\EditDataPajak::route('/{record}/edit'),
        ];
    }
}
