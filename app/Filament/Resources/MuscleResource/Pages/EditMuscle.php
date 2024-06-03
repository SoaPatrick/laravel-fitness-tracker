<?php

namespace App\Filament\Resources\MuscleResource\Pages;

use App\Filament\Resources\MuscleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMuscle extends EditRecord
{
    protected static string $resource = MuscleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
