<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BisnisResource\Pages;
use App\Filament\Resources\BisnisResource\RelationManagers;
use App\Models\Bisnis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BisnisResource extends Resource
{
    protected static ?string $model = Bisnis::class;
    protected static ?string $navigationIcon = 'heroicon-m-building-library';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $activeNavigationIcon = 'heroicon-m-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('nama_bisnis')
                    ->placeholder('Nama Bisnis')
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
            'index' => Pages\ListBisnis::route('/'),
            'create' => Pages\CreateBisnis::route('/create'),
            'edit' => Pages\EditBisnis::route('/{record}/edit'),
        ];
    }
}
