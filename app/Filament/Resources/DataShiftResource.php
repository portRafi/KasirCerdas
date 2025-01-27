<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\DataShift;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DataShiftResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataShiftResource\RelationManagers;

class DataShiftResource extends Resource
{
    protected static ?string $model = DataShift::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $activeNavigationIcon = 'heroicon-s-document';
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationLabel = 'Data Shift Kasir';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('bisnis_id')
                    ->default(Auth::user()->bisnis_id),
                Forms\Components\Hidden::make('cabangs_id')
                    ->default(Auth::user()->cabangs_id),
                Forms\Components\TextInput::make('shift')
                    ->required()
                    ->numeric(),
                Forms\Components\TimePicker::make('shift_start')
                    ->seconds(false)    
                    ->label('Jam Shift Dimulai')
                    ->required(),
                Forms\Components\TimePicker::make('shift_end')
                    ->seconds(false)
                    ->label('Jam Shift Berakhir')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
            ->query(DataShift::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('shift')
                    ->label('Shift'),
                Tables\Columns\TextColumn::make('shift_start')
                    ->label('Shift Start'),
                Tables\Columns\TextColumn::make('shift_end')
                    ->label('Shift End'),
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

    public static  function canCreate():bool {
        $shiftCount = DataShift::where('bisnis_id', Auth::user()->bisnis_id)
            ->where('cabangs_id', Auth::user()->cabangs_id)
            ->count();

        if ($shiftCount >= 2) {
            return(false);
        } else {
            return(true);   
        }
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
            'index' => Pages\ListDataShifts::route('/'),
            'create' => Pages\CreateDataShift::route('/create'),
            'edit' => Pages\EditDataShift::route('/{record}/edit'),
        ];
    }
    // public static function shouldRegisterNavigation(): bool
    // {
    //     if(!auth()->user()->hasRole('super_admin')) {
    //         return false;   
    //     }
    //     return true;
    // }
}