<?php

namespace App\Filament\Widgets;

use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahTransaksiWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTransaksi = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->count();
        $totalPendapatan = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('total_harga_after_pajak');
        $totalKeuntungan = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('keuntungan');

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
