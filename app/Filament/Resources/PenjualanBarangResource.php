<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanBarangResource\Pages;
use App\Filament\Resources\PenjualanBarangResource\RelationManagers;
use App\Models\PenjualanBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjualanBarangResource extends Resource
{
    protected static ?string $model = PenjualanBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Penjualan Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_pendapatan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('keuntungan')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_pendapatan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keuntungan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPenjualanBarangs::route('/'),
            'create' => Pages\CreatePenjualanBarang::route('/create'),
            'edit' => Pages\EditPenjualanBarang::route('/{record}/edit'),
        ];
    }
}
