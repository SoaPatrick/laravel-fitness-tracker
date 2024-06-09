<?php

namespace App\Filament\Resources\ExerciseResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;
use App\Models\DiaryEntry;
use Carbon\Carbon;
use Filament\Support\RawJs;


class ExerciseChart extends ChartWidget
{
    protected static ?string $heading = 'Weight Chart';

    public ?Model $record = null;

    protected function getData(): array
    {
        // Zugriff auf die exerciseId direkt aus dem aktuellen Exercise-Datensatz
        $exerciseId = $this->record->id;

        $diaryEntries = DiaryEntry::where('exercise_id', $exerciseId)
                                          ->latest()
                                          ->take(10)
                                          ->get()
                                          ->sortBy('created_at')
                                          ->values(); //

        $labels = $diaryEntries->map(function ($entry) {
            return Carbon::parse($entry->created_at)->format('l j M Y');
        });

        $weights = $diaryEntries->map(function ($entry) {
            return $entry->weight;
        });

        return [
            'labels' => $labels->toArray(),
            'datasets' => [
                [
                    'label' => 'Weight',
                    'data' => $weights->toArray(),
                ],
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'min' => 1,
                        'max' => 12
                    ]
                ]
            ]
        ];
    }
     
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                scales: {
                    y: {
                        min: 0,
                        max: 12,
                    },
                },
            }
        JS);
    }


    protected function getType(): string
    {
        return 'line';
    }
}