<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pajak;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PajakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PajakResource\RelationManagers;

class PajakResource extends Resource
{
    protected static ?string $model = Pajak::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $activeNavigationIcon = 'heroicon-m-scale';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bisnis')
                    ->value(Auth::user()->bisnis)
                    ->hidden(),
                Forms\Components\TextInput::make('cabang')
                    ->value(Auth::user()->cabang)
                    ->hidden(),
                Forms\Components\TextInput::make('nama_pajak')
                    ->placeholder('Nama Pajak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_pajak')
                    ->placeholder('Jumlah Pajak')
                    ->numeric()
                    ->suffix('%')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Pajak::where([
                    ['bisnis', '=', Auth::user()->bisnis],
                    ['cabang', '=', Auth::user()->cabang]
                ])
            )
            ->poll('5s')
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
            // 'create' => Pages\CreatePajak::route('/create'),
            // 'edit' => Pages\EditPajak::route('/{record}/edit'),
        ];
    }
}
