<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiskonResource\Pages;
use App\Filament\Resources\DiskonResource\RelationManagers;
use App\Models\Diskon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiskonResource extends Resource
{
    protected static ?string $model = Diskon::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $activeNavigationIcon = 'heroicon-m-percent-badge';
    protected static ?string $navigationGroup = 'Database';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipe_diskon')
                    ->placeholder('Tipe Diskon')
                    ->options([
                        'persen' => 'Persen (%)',
                        'rupiah' => 'Rupiah (Rp)',
                    ]),
                Forms\Components\TextInput::make('nama_diskon')
                    ->placeholder('Nama Diskon')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_diskon')
                    ->placeholder('Jumlah Diskon')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipe_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_diskon')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDiskons::route('/'),
            'create' => Pages\CreateDiskon::route('/create'),
            'edit' => Pages\EditDiskon::route('/{record}/edit'),
        ];
    }
}
