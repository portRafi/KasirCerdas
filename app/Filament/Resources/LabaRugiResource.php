<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabaRugiResource\Pages;
use App\Filament\Resources\LabaRugiResource\RelationManagers;
use App\Models\Labarugi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabaRugiResource extends Resource
{
    protected static ?string $model = Labarugi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Laba Rugi';

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
                //
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
            'index' => Pages\ListLabaRugis::route('/'),
            'create' => Pages\CreateLabaRugi::route('/create'),
            'edit' => Pages\EditLabaRugi::route('/{record}/edit'),
        ];
    }
}
