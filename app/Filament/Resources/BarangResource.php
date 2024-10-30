<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use App\Models\Diskon;
use App\Models\Satuan;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected ?string $heading = 'Custom Page Heading';
    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $activeNavigationIcon = 'heroicon-m-squares-plus';
    protected static ?string $navigationGroup = 'Database';
    protected static ?string $navigationLabel = 'Barang';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('bisnis_id')
                    ->default(Auth::user()->bisnis_id),
                Forms\Components\Hidden::make('cabangs_id')
                    ->default(Auth::user()->cabangs_id),
                Forms\Components\TextInput::make('kode')
                    ->placeholder('Kode Barang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->placeholder('Nama Barang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('kategori')
                    ->placeholder('Kategori Barang')
                    ->preload()
                    ->options(Kategori::all()->pluck('nama', 'nama'))
                    ->required(),
                Forms\Components\TextInput::make('harga_beli')
                    ->placeholder('Harga Beli')
                    ->prefix('Rp')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('harga_jual')
                    ->placeholder('Harga Jual')
                    ->prefix('Rp')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('stok')
                    ->placeholder('Stok Barang')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('diskon')
                    ->preload()
                    ->options(Diskon::where([
                        ['bisnis_id', Auth::user()->bisnis_id],
                        ['cabangs_id', Auth::user()->cabangs_id],
                    ])->pluck('nama_diskon', 'jumlah_diskon')),
                Forms\Components\Select::make('satuan')
                    ->options(Satuan::where([
                        ['bisnis_id', Auth::user()->bisnis_id],
                        ['cabangs_id', Auth::user()->cabangs_id],
                    ])->pluck('nama_satuan', 'nama_satuan'))
                    ->required(),
                Forms\Components\TextInput::make('berat')
                    ->placeholder('Berat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('letak_rak')
                    ->placeholder('Letak Rak')
                    ->numeric(),
                Forms\Components\TextInput::make('keterangan')
                    ->placeholder('Keterangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Barang::where([
                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                    ['cabangs_id', '=', Auth::user()->cabangs_id]
                ])
            )
            ->poll('5s')
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diskon')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('berat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('letak_rak')
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
