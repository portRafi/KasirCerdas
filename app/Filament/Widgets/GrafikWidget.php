<?php

namespace App\Filament\Widgets;

use App\Models\DataTransaksi;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GrafikWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //todo
            Stat::make('Grafik Transaksi', DataTransaksi::count()),
            Stat::make('Grafik Keuntungan', DataTransaksi::count()),
            Stat::make('Grafik Pendapatan', DataTransaksi::count()),
        ];
    }
}
