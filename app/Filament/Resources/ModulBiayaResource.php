<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModulBiayaResource\Pages;
use App\Filament\Resources\ModulBiayaResource\RelationManagers;
use App\Models\ModulBiaya;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModulBiayaResource extends Resource
{
    protected static ?string $model = ModulBiaya::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-m-book-open';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Modul Biaya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nominal')
                    ->prefix('Rp')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
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
            'index' => Pages\ListModulBiayas::route('/'),
            // 'create' => Pages\CreateModulBiaya::route('/create'),
            // 'edit' => Pages\EditModulBiaya::route('/{record}/edit'),
        ];
    }
}
