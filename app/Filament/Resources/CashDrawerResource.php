<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashDrawerResource\Pages;
use App\Filament\Resources\CashDrawerResource\RelationManagers;
use App\Models\CashDrawer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SelectColumn;

class CashDrawerResource extends Resource
{
    protected static ?string $model = CashDrawer::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $activeNavigationIcon = 'heroicon-m-banknotes';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Cash Drawer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                ->required()
                ->maxLength(255),
                Forms\Components\Select::make('status')
                ->options([
                    'draft' => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                ]),
                Forms\Components\TextInput::make('nominal')
                ->required()
                ->numeric()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'draft' => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                    
                ]),
                Tables\Columns\TextColumn::make('nominal')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCashDrawers::route('/'),
            'create' => Pages\CreateCashDrawer::route('/create'),
            'edit' => Pages\EditCashDrawer::route('/{record}/edit'),
        ];
    }
}
