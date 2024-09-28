<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPajakResource\Pages;
use App\Filament\Resources\DataPajakResource\RelationManagers;
use App\Models\DataPajak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataPajakResource extends Resource
{
    protected static ?string $model = DataPajak::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Data Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')
                ->searchable()
                ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('jumlah_pajak')
                ->label('Jumlah Pajak')
                ->money('IDR')
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
