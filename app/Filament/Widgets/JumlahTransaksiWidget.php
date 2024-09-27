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
        $totalPendapatan = DataTransaksi::sum('total_harga_after_pajak');
        $totalKeuntungan = DataTransaksi::sum('keuntungan');

        return [
            Stat::make('Jumlah Transaksi', DataTransaksi::count())
                ->description('Data Jumlah Transaksi')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->chart([DataTransaksi::count()])
                ->color('primary'),
            Stat::make('Keuntungan', 'Rp.'.number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Data Keuntungan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
            Stat::make('Pendapatan', 'Rp.'.number_format($totalPendapatan, 0, ',', '.'))
                ->description('Data Pendapatan')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
        ];
    }
}
