<?php

namespace App\Filament\Widgets;

use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahTransaksiWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPendapatan = DataTransaksi::sum('yang_dibayarkan');
        $totalKeuntungan = PenjualanBarang::sum('keuntungan');

        return [
            Stat::make('Jumlah Transaksi', DataTransaksi::count())
                ->description('Data Jumlah Transaksi')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
            Stat::make('Keuntungan', $totalKeuntungan)
                ->description('Data Keuntungan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
            Stat::make('Pendapatan', $totalPendapatan)
                ->description('Data Pendapatan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
        ];
    }
}
