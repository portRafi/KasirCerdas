<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use App\Models\DataShift;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ManajemenShiftResource\Pages;
use App\Filament\Resources\ManajemenShiftResource\RelationManagers;

class ManajemenShiftResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $activeNavigationIcon = 'heroicon-s-clipboard';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Manajemen Shift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = User::query();
                if (Auth::user()->hasRole(7)) {
                    $query->where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id],
                        ['cabangs_id', '=', Auth::user()->cabangs_id]
                    ]);
                } else if (Auth::user()->hasRole(6)) {
                    $query->where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id]
                    ]);
                } else if (Auth::user()->hasRole(1)) {
                    $query->get();
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('shift')
                ->options(DataShift::where([
                    
                ])->pluck('nama_shift', 'shift'))
                ->selectablePlaceholder(false),
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
            'index' => Pages\ListManajemenShifts::route('/'),
            'create' => Pages\CreateManajemenShift::route('/create'),
            'edit' => Pages\EditManajemenShift::route('/{record}/edit'),
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
