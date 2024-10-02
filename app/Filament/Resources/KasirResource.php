<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KasirResource\Pages;
use App\Filament\Resources\KasirResource\RelationManagers;
use App\Models\Bisnis;
use App\Models\Cabang;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\View\TablesRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KasirResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $activeNavigationIcon = 'heroicon-m-user-plus';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Akun Kasir';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                ->live()
                ->relationship('class', 'name'),
            Forms\Components\Select::make('section_id'),
                Forms\Components\Select::make('bisnis')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Bisnis::where('nama_bisnis', 'like', "%{$search}%")->limit(50)->pluck('nama_bisnis', 'nama_bisnis')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => Bisnis::find($value)?->nama_bisnis)
                    ->reactive(),
                Forms\Components\Select::make('cabang')
                    ->required()
                    ->options(function (callable $get) {
                        $bisnisId = $get('bisnis');
                        if ($bisnisId) {
                            return Cabang::where('nama_bisnis', $bisnisId)->pluck('nama_cabang', 'nama_cabang');
                        }
                        return Cabang::all()->pluck('nama_cabang', 'nama_cabang'); 
                    })
                    ->disabled(fn(callable $get) => !$get('bisnis'))
                    ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('alamat')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'kasir' => 'Kasir',
                    ]),
                Tables\Columns\TextColumn::make('bisnis')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cabang')
                    ->badge()
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
            'index' => Pages\ListKasirs::route('/'),
            'create' => Pages\CreateKasir::route('/create'),
            'edit' => Pages\EditKasir::route('/{record}/edit'),
        ];
    }
}
