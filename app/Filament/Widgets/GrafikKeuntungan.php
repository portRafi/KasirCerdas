<?php
namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use App\Models\DataTransaksi;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class GrafikKeuntungan extends ChartWidget
{   
    protected static string $color = 'info';
    protected static ?string $heading = 'Grafik Keuntungan';

    protected function getData(): array 
    {
        $query = DataTransaksi::query();
        if (Auth::user()->hasRole(7)) {
            $query->where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
            ]);
        } elseif (Auth::user()->hasRole(6)) {
            $query->where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
            ]);
        }

        $data = Trend::model(DataTransaksi::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->sum('keuntungan'); 

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Keuntungan',
                    'data' => collect($data)->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'backgroundColor' => '#36C2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line'; 
    }
}
