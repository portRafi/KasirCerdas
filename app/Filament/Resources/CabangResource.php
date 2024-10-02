<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CabangResource\Pages;
use App\Filament\Resources\CabangResource\RelationManagers;
use App\Models\Cabang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CabangResource extends Resource
{
    protected static ?string $model = Cabang::class;
    protected static ?string $navigationIcon = 'heroicon-m-building-storefront';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $activeNavigationIcon = 'heroicon-m-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_bisnis')
                ->placeholder('Nama Bisnis')
                ->required()
                ->maxLength(255),
                    Forms\Components\TextInput::make('nama_cabang')
                    ->placeholder('Nama Cabang')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('deskripsi')
                    ->placeholder('Tambah Deskripsi')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('alamat')
                    ->placeholder('Tambah Alamat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nama_bisnis')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nama_cabang')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
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
            'index' => Pages\ListCabangs::route('/'),
            'create' => Pages\CreateCabang::route('/create'),
            'edit' => Pages\EditCabang::route('/{record}/edit'),
        ];
    }
}
