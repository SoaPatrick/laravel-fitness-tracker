<?php

namespace App\Filament\Resources\MuscleResource\Pages;

use App\Filament\Resources\MuscleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMuscles extends ListRecords
{
    protected static string $resource = MuscleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
