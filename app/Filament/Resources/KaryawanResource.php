<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Cabang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\View\TablesRenderHook;
use App\Filament\Resources\KaryawanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class KaryawanResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $activeNavigationIcon = 'heroicon-m-user-plus';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Pendataan Karyawan';
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
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state)),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name', function ($query) {
                        if (Auth::user()->hasRole(7)) {
                            return $query->where('id', 4);
                        } else {
                            return $query->whereNotIn('id', [1, 9]);
                        }
                    }),

                Forms\Components\Hidden::make('bisnis_id')
                    ->default(Auth::user()->bisnis_id),
                Forms\Components\Select::make('cabangs_id')
                    ->label('Cabang')
                    ->options(function () {
                        return Cabang::where('bisnis_id', Auth::user()->bisnis_id)
                            ->pluck('nama_cabang', 'id');
                    })
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = User::query();
                if (Auth::user()->hasRole(7)) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('bisnis_id', Auth::user()->bisnis_id)
                              ->where('cabangs_id', Auth::user()->cabangs_id)
                              ->where('roles.id', '=', 4);
                    })->with('roles');
                } else if (Auth::user()->hasRole(6)) {
                    $query->where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id],
                        ['email', '!=', Auth::user()->email]
                    ]);
                } else if (Auth::user()->hasRole(1)) {
                    $query->get();
                }
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }

    // public static function shouldRegisterNavigation(): bool
    // {
    //     if(!auth()->user()->hasRole(1)) {
    //         return false;   
    //     }
    //     return true;
    // }

}
