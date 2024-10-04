<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\DataPajak;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataPajakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataPajakResource\RelationManagers;

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
        ->query(
            DataPajak::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id]
            ])
        )
        ->poll('5s')
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
