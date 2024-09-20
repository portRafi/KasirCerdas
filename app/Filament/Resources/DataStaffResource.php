<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataStaffResource\Pages;
use App\Filament\Resources\DataStaffResource\RelationManagers;
use App\Models\DataStaff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataStaffResource extends Resource
{
    protected static ?string $model = DataStaff::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $activeNavigationIcon = 'heroicon-m-clipboard-document-list';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'DataStaff';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Administrator',
                        'nonaktif' => 'Manajer',
                        'iklik' => 'Kasir',
                        ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'draft' => 'Administrator',
                        'nonaktif' => 'Manajer',
                        'iklik' => 'Kasir',
                ]),
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
            'index' => Pages\ListDataStaff::route('/'),
            'create' => Pages\CreateDataStaff::route('/create'),
            'edit' => Pages\EditDataStaff::route('/{record}/edit'),
        ];
    }
}
