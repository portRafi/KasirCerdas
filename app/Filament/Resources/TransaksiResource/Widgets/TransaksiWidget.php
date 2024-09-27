<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransaksiWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full'; 
    protected function getStats(): array
    {
        $totalTransaksiToday = DataTransaksi::count();
        $totalUangMasukToday = DataTransaksi::sum('total_harga');
        $totalKeuntunganToday = DataTransaksi::sum('keuntungan');

        return [
            Stat::make('Total Transaksi Hari Ini', $totalTransaksiToday)
                ->icon('heroicon-s-shopping-cart', IconPosition::Before)
                ->color('success'),
            Stat::make('Total Uang Masuk Hari Ini', 'Rp.' . $totalUangMasukToday)
                ->icon('heroicon-s-currency-dollar', IconPosition::Before)
                ->color('success'),
            Stat::make('Keuntungan Hari Ini', 'Rp.' . $totalKeuntunganToday)
                ->icon('heroicon-m-document-currency-dollar', IconPosition::Before)
                ->color('success'),
        ];
    }
}
