<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataTransaksiResource\Pages;
use App\Filament\Resources\DataTransaksiResource\RelationManagers;
use App\Models\DataTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Models\BarangAfterCheckout;



class DataTransaksiResource extends Resource
{
    protected static ?string $model = DataTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Data Transaksi';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->poll('5s')
        ->columns([
                Tables\Columns\TextColumn::make('kode_transaksi')
                    ->label('Kode Transaksi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_staff')
                    ->label('Email Staff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga_after_pajak')
                    ->label('Total Harga After Pajak')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('selisih_pajak')
                    ->label('Selisih Pajak')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keuntungan')
                    ->label('Keuntungan')
                    ->numeric()
                    ->money('IDR')
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
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
{
    $dataBarang = BarangAfterCheckout::where('kode_transaksi', $infolist->kode_transaksi)->first();

    return $infolist
        ->schema([
            TextEntry::make('kode_transaksi')->value($dataBarang->kode_transaksi),
            TextEntry::make('kode')->value($dataBarang->kode),
            TextEntry::make('kategori')->value($dataBarang->kategori),
            TextEntry::make('nama')->value($dataBarang->nama),
            TextEntry::make('quantity')->value($dataBarang->quantity),
            TextEntry::make('total_harga')->value($dataBarang->total_harga),
            TextEntry::make('harga_jual')->value($dataBarang->harga_jual),
            TextEntry::make('harga_beli')->value($dataBarang->harga_beli),
        ]);
}

    public static function getRelations(): array
    {
        return [
            // RelationManagers\BarangRelationManager::class,
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataTransaksis::route('/'),
        ];
    }
}
