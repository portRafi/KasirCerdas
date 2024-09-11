<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PajakResource\Pages;
use App\Filament\Resources\PajakResource\RelationManagers;
use App\Models\Pajak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PajakResource extends Resource
{
    protected static ?string $model = Pajak::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pajak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_pajak')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_pajak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_pajak')
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
            'index' => Pages\ListPajaks::route('/'),
            'create' => Pages\CreatePajak::route('/create'),
            'edit' => Pages\EditPajak::route('/{record}/edit'),
        ];
    }
}
