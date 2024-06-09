<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DiaryEntry;

class WeekdayFrequencyChart extends ChartWidget
{
    protected static ?string $heading = 'Weekday Frequency';


    protected function getData(): array
    {
        $entries = DiaryEntry::all();
        $weekdayCounts = array_fill(0, 7, 0); // Initialisiert ein Array mit 7 Elementen auf 0

        foreach ($entries as $entry) {
            $weekday = date('N', strtotime($entry->created_at)) - 1; // 'N' gibt den Wochentag zurück (1 für Montag bis 7 für Sonntag), -1 für Array-Index
            $weekdayCounts[$weekday]++;
        }

        return [
            'labels' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'datasets' => [
                [
                    'label' => 'Exercises',
                    'data' => $weekdayCounts,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}