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

class JumlahTransaksiWidgetAll extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        if (Auth::user()->hasRole(7)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
            ]);
        } else if (Auth::user()->hasRole(6)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
            ]);
        } else if (Auth::user()->hasRole(1)) {
            $query = DataTransaksi::all();
        }


        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total_harga_after_diskon');
        $totalKeuntungan = $query->sum('keuntungan');
        $totalPajak = $query->sum('total_pajak');

        return [
            Stat::make('Semua Jumlah Transaksi', $totalTransaksi)
                ->description('Semua Data Transaksi')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Semua Keuntungan', 'Rp.' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Semua Total Keuntungan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Semua Pendapatan', 'Rp.' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Semua Total Pendapatan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Semua Pajak', 'Rp.' . number_format($totalPajak, 0, ',', '.'))
                ->description('Semua Total Pajak')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

        ];
    }
}
