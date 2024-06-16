<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DiaryEntry;
use App\Enums\Muscle;

class MuscleFrequencyChart extends ChartWidget
{
    protected static ?string $heading = 'Muscle Frequency';

    protected function getData(): array
    {
        // Holen Sie alle Diary Entries mit zugehörigen Übungen
        $diaryEntries = DiaryEntry::with('exercise')->get();

        $muscleFrequency = [];

        foreach ($diaryEntries as $entry) {
            // Sicherstellen, dass primary_muscles und secondary_muscles immer Arrays sind
            $primaryMuscles = $entry->exercise->primary_muscles ?? [];
            $secondaryMuscles = $entry->exercise->secondary_muscles ?? [];
            $muscles = array_merge($primaryMuscles, $secondaryMuscles);

            foreach ($muscles as $muscle) {
                $muscleEnum = Muscle::tryFrom($muscle);
                if ($muscleEnum) {
                    $muscleLabel = $muscleEnum->getLabel();
                    if (!isset($muscleFrequency[$muscleLabel])) {
                        $muscleFrequency[$muscleLabel] = 0;
                    }
                    $muscleFrequency[$muscleLabel]++;
                }
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