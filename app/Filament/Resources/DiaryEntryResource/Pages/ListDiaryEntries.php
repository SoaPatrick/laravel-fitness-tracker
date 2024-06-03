<?php

namespace App\Filament\Resources\DiaryEntryResource\Pages;

use App\Filament\Resources\DiaryEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiaryEntries extends ListRecords
{
    protected static string $resource = DiaryEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
