<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Bisnis;
use App\Models\Cabang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\View\TablesRenderHook;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $activeNavigationIcon = 'heroicon-m-user-plus';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Pendataan Admin Bisnis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('bisnis_id')
                    ->label('bisnis_id')
                    ->required()
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Bisnis::where('nama_bisnis', 'like', "%{$search}%")
                        ->limit(50)
                        ->pluck('nama_bisnis', 'id')
                        ->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => Bisnis::find($value)?->nama_bisnis)
                    ->reactive(),
                Forms\Components\Select::make('cabangs_id')
                    ->label('cabangs_id')
                    ->required()
                    ->options(function (callable $get) {
                        $bisnisId = $get('bisnis_id');
                        if ($bisnisId) {
                            return Cabang::where('bisnis_id', $bisnisId)
                                ->pluck('nama_cabang', 'id');
                        }
                        return Cabang::all()->pluck('nama_cabang', 'id');
                    })
                    ->disabled(fn(callable $get) => !$get('bisnis_id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = User::query();
                    $query->whereHas('roles', function ($query) {
                        $query->where('roles.id', '=', 6);
                    })->with('roles');
                return $query;
            })
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->badge(), 
                Tables\Columns\TextColumn::make('bisnis.nama_bisnis')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cabang.nama_cabang')
                    ->badge()
                    ->color('success')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (!auth()->user()->hasRole(1)) {
            return false;
        }
        return true;
    }
}
