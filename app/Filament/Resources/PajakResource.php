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
                forms\Components\Hidden::make('nama_user'),
                Forms\Components\Hidden::make('bisnis_id')
                    ->default(Auth::user()->bisnis_id),
                Forms\Components\Hidden::make('cabangs_id')
                    ->default(Auth::user()->cabangs_id),
                Forms\Components\TextInput::make('nama_pajak')
                    ->placeholder('Nama Pajak')
                    ->required()
                    ->maxLength(255),
                    forms\Components\Hidden::make('nama_user'),
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
                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                    ['cabangs_id', '=', Auth::user()->cabangs_id]
                ])
            )
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('nama_pajak')
                    ->searchable(),
                    forms\Components\Hidden::make('nama_user'),
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
