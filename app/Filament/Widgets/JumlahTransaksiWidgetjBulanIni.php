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

class JumlahTransaksiWidgetjBulanIni extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = Carbon::now()->subMonth(); 
        $endDate = Carbon::now(); 

        if (Auth::user()->hasRoles(7)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
            ]);
        }
        else if (Auth::user()->hasRoles(6)) {
            $query = DataTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
            ]);
        }
        else if (Auth::user()->hasRoles(1)) {
            $query = DataTransaksi::all();
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total_harga_after_diskon');
        $totalKeuntungan = $query->sum('keuntungan');
        $totalPajak = $query->sum('total_pajak');

        return [
            Stat::make('Jumlah Transaksi Bulan Ini', $totalTransaksi)
                ->description('Data Transaksi Bulan Ini')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Keuntungan Bulan Ini', 'Rp.' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Total Keuntungan Bulan Ini')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Pendapatan Bulan Ini', 'Rp.' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Total Pendapatan Bulan Ini')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),

            Stat::make('Pajak Bulan Ini', 'Rp.' . number_format($totalPajak, 0, ',', '.'))
                ->description('Total Pajak Bulan Ini')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('primary'),
          
        ];
        
    }
    
}
