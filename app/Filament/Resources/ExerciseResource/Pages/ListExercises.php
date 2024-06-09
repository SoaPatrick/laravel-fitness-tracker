<?php

namespace App\Filament\Resources\ExerciseResource\Pages;

use App\Filament\Resources\ExerciseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Muscle;

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

        // Holen Sie alle Muskelnamen aus der Datenbank
        $muscles = Muscle::all();

        // Erstellen Sie für jeden Muskel einen Tab
        foreach ($muscles as $muscle) {
            $tabs[$muscle->name] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->whereHas('muscles', fn (Builder $query) => 
                        $query->where('name', $muscle->name)
                    )
                );
        }

        return $tabs;
    }
}
