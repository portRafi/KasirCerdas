<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\DataTransaksi;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahTransaksiWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
    //mengambil data transaksi sesuai stardate dan enddate
    $startDate = !is_null($this->filters['startDate'] ?? null) ? Carbon::parse($this->filters['startDate']) : null;
    $endDate = !is_null($this->filters['endDate'] ?? null) ? Carbon::parse($this->filters['endDate']) : null;
    
    $query = DataTransaksi::where('bisnis_id', Auth::user()->bisnis_id) 
        ->where('cabangs_id', Auth::user()->cabangs_id);

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
    }

    $totalTransaksi = $query->count();
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
            ->description('Data Pendataan')
            ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
            ->color('primary'),
    ];
    }
}
