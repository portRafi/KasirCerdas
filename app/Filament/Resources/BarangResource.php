<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\Diskon;
use App\Models\Satuan;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Tables\Columns\FileUpload;

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
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->label('Foto Barang'),
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
                    ->options(Kategori::where([
                        ['bisnis_id', '=', Auth::user()->bisnis_id],
                        ['cabangs_id', '=', Auth::user()->cabangs_id]
                    ])->pluck('nama', 'nama'))
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
                    ->required()
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
            ->query(function () {
                $query = Barang::query();
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
                // Tables\Columns\FileUpload::make('upload')
                //     ->label('Foto Barang'
                //     ->image()
                //     ->sortable()),
                // Tables\Columns\TextColumn::make('barcode')
                //     ->searchable(),
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
                    ->formatStateUsing(fn($state) => $state <= 100 ? "$state%" : "IDR " . number_format($state, 0, ',', '.'))
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
            ->filters(
                array_filter([
                    Auth::user()->hasRole(6) ?
                        SelectFilter::make('cabangs_id')
                        ->label('Cabang')
                        ->options(
                            Cabang::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama_cabang', 'id')->toArray()
                        ) : null,

                    SelectFilter::make('nama')
                        ->label('Nama Barang')
                        ->options(
                            Barang::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama', 'nama')->toArray()
                        ),

                    SelectFilter::make('satuan')
                        ->options(
                            Satuan::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama_satuan', 'nama_satuan')->toArray()
                        ),

                    SelectFilter::make('kategori')
                        ->options(
                            Kategori::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama', 'nama')->toArray()
                        ),

                    Filter::make('date_range')
                        ->form([
                            DatePicker::make('start_date')
                                ->label('Start Date')
                                ->required(),
                            DatePicker::make('end_date')
                                ->label('End Date')
                                ->required(),
                        ])
                        ->columns(2)
                        ->query(function (Builder $query, array $data): Builder {
                            return $query->when(
                                isset($data['start_date']) && isset($data['end_date']),
                                function (Builder $query) use ($data): Builder {
                                    return $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
                                }
                            );
                        }),
                ]),
                layout: FiltersLayout::AboveContent
            )
            ->actions([])
            ->bulkActions([
                ExportBulkAction::make(),
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
