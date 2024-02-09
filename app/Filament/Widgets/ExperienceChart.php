<?php

namespace App\Filament\Widgets;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Experience;
use Filament\Widgets\ChartWidget;

class ExperienceChart extends ChartWidget
{
    protected static ?string $heading = 'Expérience';
    protected static ?int $sort=3;

    protected function getData(): array
    {
        $data = Trend::model(Experience::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Expérience',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];


    }

    protected function getType(): string
    {
        return 'line';
    }
}
