<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
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
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) : null;

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) : null;
        $totalTransaksi = DataTransaksi::whereBetween([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            [$startDate, $endDate]
        ])->count();
        $totalPendapatan = DataTransaksi::whereBetween([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            [$startDate, $endDate]
        ])->sum('total_harga_after_pajak');
        $totalKeuntungan = DataTransaksi::whereBetween([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            [$startDate, $endDate]
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
