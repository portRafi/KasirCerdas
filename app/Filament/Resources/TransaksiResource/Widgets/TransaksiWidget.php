<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Carbon\Carbon;
use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TransaksiWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        $totalTransaksiToday = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->whereDate('created_at', Carbon::today())->count();
        $totalUangMasukToday = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->whereDate('created_at', Carbon::today())->sum('total_harga');
        $totalKeuntunganToday = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->whereDate('created_at', Carbon::today())->sum('keuntungan');

        return [
            Stat::make('Total Transaksi Hari Ini', $totalTransaksiToday)
                ->icon('heroicon-s-shopping-cart', IconPosition::Before)
                ->color('success'),
            Stat::make('Total Uang Masuk Hari Ini', 'Rp.' . number_format($totalUangMasukToday, 0, ',', '.'))
                ->icon('heroicon-s-currency-dollar', IconPosition::Before)
                ->color('success'),
            Stat::make('Keuntungan Hari Ini', 'Rp.' . number_format($totalKeuntunganToday, 0, ',', '.'))
                ->icon('heroicon-m-document-currency-dollar', IconPosition::Before)
                ->color('success'),
        ];
    }
}
