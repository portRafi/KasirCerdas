<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DiskonTransaksi;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DiskonTransaksiResource\Pages;
use App\Filament\Resources\DiskonTransaksiResource\RelationManagers;

class DiskonTransaksiResource extends Resource
{
    protected static ?string $model = DiskonTransaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $activeNavigationIcon = 'heroicon-m-percent-badge';
    protected static ?string $navigationGroup = 'Database';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('bisnis_id')
                    ->default(Auth::user()->bisnis_id),
                Forms\Components\Hidden::make('cabangs_id')
                    ->default(Auth::user()->cabangs_id),
                Forms\Components\Select::make('tipe_diskon')
                    ->options([
                        'Persentase' => 'persen',
                        'Diskon Tetap' => 'fixed',
                    ]),
                Forms\Components\TextInput::make('nama_diskon')
                    ->placeholder('Nama Diskon')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_diskon')
                    ->placeholder('Jumlah Diskon')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('minimum_pembelian')
                    ->placeholder('Minimal Pembelian')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('is_Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = DiskonTransaksi::query();
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
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('tipe_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_diskon')
                    ->formatStateUsing(fn($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('minimum_pembelian')
                    ->formatStateUsing(fn($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_Active'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(fn($record) => $record->is_Active ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn($state) => $state === 'Aktif' ? 'success' : 'warning'),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDiskonTransaksis::route('/'),
            'create' => Pages\CreateDiskonTransaksi::route('/create'),
            'edit' => Pages\EditDiskonTransaksi::route('/{record}/edit'),
        ];
    }
}
