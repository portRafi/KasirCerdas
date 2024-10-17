<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Bisnis;
use App\Models\Cabang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CabangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CabangResource\RelationManagers;

class CabangResource extends Resource
{
    protected static ?string $model = Cabang::class;
    protected static ?string $navigationIcon = 'heroicon-m-building-storefront';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $activeNavigationIcon = 'heroicon-m-building-storefront';
    protected static ?string $navigationLabel = 'cabang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('bisnis_id')
                    ->label('Nama Bisnis')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Bisnis::where('nama_bisnis', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('nama_bisnis', 'id')
                        ->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => Bisnis::find($value)?->nama_bisnis)
                    ->reactive(),
                Forms\Components\TextInput::make('nama_cabang')
                    ->placeholder('Nama Cabang')
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
            ->query(Cabang::where([

                // ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['id', '=', Auth::user()->cabangs_id]
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_bisnis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_cabang')
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
            'index' => Pages\ListCabangs::route('/'),
            'create' => Pages\CreateCabang::route('/create'),
            'edit' => Pages\EditCabang::route('/{record}/edit'),
        ];
    }
}
