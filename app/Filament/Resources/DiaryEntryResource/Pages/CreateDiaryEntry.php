<?php

namespace App\Filament\Resources\DiaryEntryResource\Pages;

use App\Filament\Resources\DiaryEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDiaryEntry extends CreateRecord
{
    protected static string $resource = DiaryEntryResource::class;
}
