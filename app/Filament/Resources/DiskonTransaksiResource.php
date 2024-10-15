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
                Forms\Components\TextInput::make('tipe_diskon')
                    ->default('Diskon IDR - 100 Diskon persen')
                    ->readOnly(),
                Forms\Components\TextInput::make('nama_diskon')
                    ->placeholder('Nama Diskon')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_diskon')
                    ->placeholder('Jumlah Diskon')
                    ->numeric()
                    ->required()
                    ->reactive() 
                    ->prefix(fn($state) => $state < 100 ? '%' : 'IDR') 
                    ->suffix(fn($state) => $state < 100 ? 'Diskon persen' : 'Diskon IDR') 
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state < 100) {
                            $set('tipe_diskon', 'Diskon persen');
                        } else {
                            $set('tipe_diskon', 'Diskon IDR');
                        }
                    }),
                Forms\Components\TextInput::make('minimum_pembelian')
                    ->placeholder('Minimum Pembelian')
                    ->prefix('IDR')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('is_Active'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
        ->query(
            DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id]
            ])
        )
        ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('tipe_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_diskon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_diskon')
                    ->formatStateUsing(fn ($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.')) 
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
