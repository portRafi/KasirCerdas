<?php

namespace App\Filament\Resources\KeuanganResource\Widgets;

use Carbon\Carbon;
use App\Models\DataTransaksi;
use App\Models\JumlahTotalHargaKotor;
use App\Models\JumlahTotalKeuntungan;
use App\Models\JumlahTotalPajak;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class KeuanganWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
        $totalTransaksiToday = DataTransaksi::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->count();
        $totalHargaKotor = JumlahTotalHargaKotor::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('total_harga_kotor');
        $totalKeuntungan = JumlahTotalKeuntungan::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('total_keuntungan');
        $totalPajak = JumlahTotalPajak::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('total_pajak');

        return [
            Stat::make('Total Transaksi', $totalTransaksiToday)
                ->description('Total Transaksi')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('success'),
            Stat::make('Total Uang Masuk', 'Rp.' . number_format($totalHargaKotor, 0, ',', '.'))
                ->description('Total Uang Masuk')
                ->descriptionIcon('heroicon-s-circle-stack', IconPosition::Before)
                ->color('success'),
            Stat::make('Total Keuntungan', 'Rp.' . number_format($totalKeuntungan, 0, ',', '.'))
                ->description('Total Keuntungan')
                ->descriptionIcon('heroicon-m-document-currency-dollar', IconPosition::Before)
                ->color('success'),
            Stat::make('Total Pajak Terkumpul', 'Rp.' . number_format($totalPajak, 0, ',', '.'))
                ->description('Total Pajak Terkumpul')
                ->descriptionIcon('heroicon-m-document-currency-dollar', IconPosition::Before)
                ->color('success'),
        ];
    }
}