<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Pages\Actions;
use App\Exports\UsersExport;
use App\Models\DataTransaksi;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\MetodePembayaran;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\BarangAfterCheckout;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DataTransaksiResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\DataTransaksiResource\RelationManagers;

use Filament\Tables\Filters\Layout;


use App\Models\Cabang;

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
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = DataTransaksi::query();
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
                Tables\Columns\TextColumn::make('total_harga_beli')
                    ->label('Total Harga Beli')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga_jual')
                    ->label('Total Harga Jual')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga_after_diskon')
                    ->label('Total Harga Setelah Diskon')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga_after_pajak')
                    ->label('Total Harga Setelah Pajak')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga Bayar')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_pajak')
                    ->label('Jumlah Pajak')
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
                SelectFilter::make('cabangs_id')
                    ->label('Cabang')
                    ->options(
                        Cabang::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama_cabang', 'id')->toArray()
                    ),
                SelectFilter::make('metode_pembayaran')
                    ->options(
                        MetodePembayaran::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('nama_mp', 'nama_mp')->toArray()
                    ),
                SelectFilter::make('email_staff')
                    ->options(
                        User::where('bisnis_id', '=', Auth::user()->bisnis_id)->pluck('email', 'email')->toArray()
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
            ], layout: FiltersLayout::AboveContent)

            ->actions([
                Tables\Actions\Action::make('Detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Transaksi')
                    ->modalContent(function ($record) {
                        return view('filament.tables.modals.view-transaction', ['record' => $record]);
                    })
                    ->color('primary'),

                //download invoice pdf
                Tables\Actions\Action::make('downloadInvoice')
                    ->label('Download Invoice')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->action(function ($record) {
                        $pdf = PDF::loadView('invoices.pdf', ['invoice' => $record]);
                        return response()->streamDownload(fn() => print($pdf->stream()), "invoice_{$record->kode_transaksi}.pdf");
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
