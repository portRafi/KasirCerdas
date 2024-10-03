<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KategoriResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KategoriResource\RelationManagers;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $activeNavigationIcon = 'heroicon-m-clipboard-document-list';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Kategori';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bisnis')
                    ->default(Auth::user()->bisnis)
                    ->hidden(),
                Forms\Components\TextInput::make('cabang')
                    ->default(Auth::user()->cabang)
                    ->hidden(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->query(
                Kategori::where([
                    ['bisnis', '=', Auth::user()->bisnis],
                    ['cabang', '=', Auth::user()->cabang]
                ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
