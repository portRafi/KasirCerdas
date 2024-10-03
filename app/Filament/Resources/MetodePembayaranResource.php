<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MetodePembayaran;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MetodePembayaranResource\Pages;
use App\Filament\Resources\MetodePembayaranResource\RelationManagers;

class MetodePembayaranResource extends Resource
{
    protected static ?string $model = MetodePembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $activeNavigationIcon = 'heroicon-m-banknotes';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Metode Pembayaran';

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
                Forms\Components\TextInput::make('nama_mp')
                    ->placeholder('Masukkan Metode Pembayaran'),
                Forms\Components\Toggle::make('is_Active')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                MetodePembayaran::where([
                    ['bisnis', '=', Auth::user()->bisnis],
                    ['cabang', '=', Auth::user()->cabang]
                ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_mp')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_Active'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn($record) => $record->is_Active ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()

            ])
            ->filters([
                //
            ])
            ->actions([])
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
            'index' => Pages\ListMetodePembayarans::route('/'),
            'create' => Pages\CreateMetodePembayaran::route('/create'),
            'edit' => Pages\EditMetodePembayaran::route('/{record}/edit'),
        ];
    }
}
