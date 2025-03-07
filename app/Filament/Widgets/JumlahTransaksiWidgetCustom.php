<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\DataTransaksi;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Forms\Components\Grid;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahTransaksiWidgetCustom extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ? Carbon::parse($this->filters['startDate']) : null;
        $endDate = !is_null($this->filters['endDate'] ?? null) ? Carbon::parse($this->filters['endDate']) : null;

        if (Auth::user()->hasRole(7)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
            ])->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [optional($startDate)->startOfDay(), optional($endDate)->endOfDay()]);
            });
        } else if (Auth::user()->hasRole(6)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
            ])->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [optional($startDate)->startOfDay(), optional($endDate)->endOfDay()]);
            });
        } else if (Auth::user()->hasRole(1)) {
            $query = DataTransaksi::when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [optional($startDate)->startOfDay(), optional($endDate)->endOfDay()]);
            });
        }


        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total_harga_after_diskon');
        $totalKeuntungan = $query->sum('keuntungan');
        $totalPajak = $query->sum('total_pajak');

        return [
            Stat::make('Jumlah Transaksi Custom', $totalTransaksi)
                ->description('Data Transaksi Custom')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Keuntungan Custom', 'Rp.' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Total Keuntungan Custom')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Pendapatan Custom', 'Rp.' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Total Pendapatan Custom')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Pajak Custom', 'Rp.' . number_format($totalPajak, 0, ',', '.'))
                ->description('Total Pajak Custom')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

        ];
    }
}
