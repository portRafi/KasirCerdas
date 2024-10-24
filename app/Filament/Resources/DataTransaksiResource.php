<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataTransaksi;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\BarangAfterCheckout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataTransaksiResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DataTransaksiResource\RelationManagers;
use App\Exports\UsersExport;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;
use PDF; 


class DataTransaksiResource extends Resource
{
    protected static ?string $model = DataTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $activeNavigationIcon = 'heroicon-s-clipboard-document-list';
    protected static ?string $navigationGroup = 'laporan';
    protected static ?string $navigationLabel = 'Data Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                DataTransaksi::where([
                    ['bisnis_id', '=', Auth::user()->bisnis_id],
                    ['cabangs_id', '=', Auth::user()->cabangs_id]
                ])
            )
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
                Tables\Actions\Action::make('Detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Transaksi')
                    ->modalContent(function ($record) {
                        return view('filament.tables.modals.view-transaction', ['record' => $record]);
                    })
                    ->color('primary'),
                
                // Tables\Actions\Action::make('View Invoice')
                //     ->label('View Invoice')
                //     ->icon('heroicon-o-eye')
                //     ->modalHeading('Detail Invoice')
                //     ->modalContent(function ($record) {
                //         return view('filament.views-invoice.view-invoice', ['record' => $record]);
                //     })
                //     ->color('primary'),

                Tables\Actions\Action::make('downloadInvoice')
                ->label('Download Invoice')
                ->action(function ($record) {
                    // Load view invoice.pdf dengan data record yang akan dicetak
                    $pdf = PDF::loadView('invoices.pdf', ['invoice' => $record]);
                    
                    // Stream atau download file PDF
                    return response()->streamDownload(fn () => print($pdf->stream()), "invoice_{$record->invoice_number}.pdf");
                })
                

            ])
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
