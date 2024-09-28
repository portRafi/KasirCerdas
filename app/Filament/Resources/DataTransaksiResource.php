<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataTransaksiResource\Pages;
use App\Filament\Resources\DataTransaksiResource\RelationManagers;
use App\Models\DataTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataTransaksiResource extends Resource
{
    protected static ?string $model = DataTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Data Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('kode')
                ->label('Kode Barang'),
            Tables\Columns\TextColumn::make('kategori')
                ->label('Kategori'),
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Barang'),
            Tables\Columns\TextColumn::make('quantity')
                ->label('Quantity'),
            Tables\Columns\TextColumn::make('diskon')
                ->hidden(),
            Tables\Columns\TextColumn::make('total_harga')
                ->label('Total Harga')
                ->money('IDR')
                ->summarize(Sum::make()->money('IDR'))
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
            'index' => Pages\ListDataTransaksis::route('/'),
            'create' => Pages\CreateDataTransaksi::route('/create'),
            'edit' => Pages\EditDataTransaksi::route('/{record}/edit'),
        ];
    }
}
