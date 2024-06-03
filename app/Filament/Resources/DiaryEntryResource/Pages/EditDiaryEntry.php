<?php

namespace App\Filament\Resources\DiaryEntryResource\Pages;

use App\Filament\Resources\DiaryEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiaryEntry extends EditRecord
{
    protected static string $resource = DiaryEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
