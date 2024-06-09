<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DiaryEntry;

class MuscleFrequencyChart extends ChartWidget
{
    protected static ?string $heading = 'Muscle Frequency';


    protected function getData(): array
    {
        // Angenommen, es gibt eine Methode in Ihrem Exercise-Modell, die die Muskeln zurückgibt
        // und jedes DiaryEntry hat ein zugehöriges Exercise
        $diaryEntries = DiaryEntry::with('exercise.muscles')->get();

        $muscleFrequency = [];

        foreach ($diaryEntries as $entry) {
            foreach ($entry->exercise->muscles as $muscle) {
                $muscleName = $muscle->name; // Angenommen, es gibt ein 'name' Feld in der Muskel-Entität
                if (!isset($muscleFrequency[$muscleName])) {
                    $muscleFrequency[$muscleName] = 0;
                }
                $muscleFrequency[$muscleName]++;
            }
        }

        $labels = array_keys($muscleFrequency);
        $data = array_values($muscleFrequency);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Muscles',
                    'data' => $data,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}