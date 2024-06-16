<?php

namespace App\Filament\Resources\ExerciseResource\Pages;

use App\Filament\Resources\ExerciseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Muscle;


class ListExercises extends ListRecords
{
    protected static string $resource = ExerciseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Initialisieren Sie das Array mit dem 'all' Tab
        $tabs = [
            'all' => Tab::make(),
        ];

        // Holen Sie alle Muskel Enum Werte
        $muscles = Muscle::cases();

        // Erstellen Sie für jeden Muskel einen Tab
        foreach ($muscles as $muscle) {
            $tabs[$muscle->value] = Tab::make()
                ->modifyQueryUsing(function (Builder $query) use ($muscle) {
                    $query->whereJsonContains('primary_muscles', $muscle->value)
                          ->orWhereJsonContains('secondary_muscles', $muscle->value);
                });
        }

        return $tabs;
    }
}
