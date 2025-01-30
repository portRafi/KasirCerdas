<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Bisnis;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BisnisResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BisnisResource\RelationManagers;

class BisnisResource extends Resource
{
    protected static ?string $model = Bisnis::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $activeNavigationIcon = 'heroicon-m-building-library';
    protected static ?string $navigationLabel = 'bisnis';

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
            ->query(function () {
                $query = Bisnis::query();
                if (Auth::user()->hasRole(6)) {
                    $query->where([
                        ['id', '=', Auth::user()->bisnis_id]
                    ]);
                } else if (Auth::user()->hasRole(1)) {
                    $query->get();
                }
                return $query;
            })
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->searchable(),
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
    public static function canCreate(): bool {
        if (!auth()->user()->hasRole(1)) {
            return false;
        } 
        return true;
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->hasRole(6)) {
            return true;
        }
        else if (auth()->user()->hasRole(1)) {
            return true;
        }
        return false;
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
