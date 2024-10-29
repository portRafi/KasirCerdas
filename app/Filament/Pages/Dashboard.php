<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Contracts\HasForms;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                DatePicker::make('startDate')
                    ->maxDate(fn (Get $get) => $get('endDate') ?: now())
                    ->afterStateUpdated(function ($state, callable $set) {
                        $this->getStats(); // Memperbarui data saat startDate diperbarui
                    }),
                DatePicker::make('endDate')
                    ->minDate(fn (Get $get) => $get('startDate') ?: now())
                    ->maxDate(now())
                    ->afterStateUpdated(function ($state, callable $set) {
                        $this->getStats(); // Memperbarui data saat endDate diperbarui
                    }),
            ])->columns(2),
        ]);
    }

    // Tambahkan method getStats di sini
    public function getStats()
    {
        // Contoh logika perhitungan statistik
        $startDate = !is_null($this->filters['startDate'] ?? null) ? Carbon::parse($this->filters['startDate']) : null;
        $endDate = !is_null($this->filters['endDate'] ?? null) ? Carbon::parse($this->filters['endDate']) : null;

        $query = DataTransaksi::where('bisnis_id', Auth::user()->bisnis_id)
            ->where('cabangs_id', Auth::user()->cabangs_id);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
        }

        $totalTransaksi = $query->count();
        $totalPenjualan = $query->sum('total_harga');
        $totalPendapatan = $query->sum('total_harga_after_pajak');
        $totalKeuntungan = $query->sum('keuntungan');

        return [
            Stat::make('Jumlah Transaksi', $totalTransaksi)
                ->description('Data Jumlah Transaksi')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->chart([$totalTransaksi])
                ->color('primary'),
            Stat::make('Keuntungan', 'Rp.' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Data Keuntungan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
            Stat::make('Pendapatan', 'Rp.' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Data Pendapatan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
        ];  
    }
}