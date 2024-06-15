<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;


enum Orientation: string implements HasLabel, HasIcon
{
    case Up = 'up';
    case Down = 'down';
    case Side = 'side';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Up => 'Up',
            self::Down => 'Down',
            self::Side => 'Side',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Up => 'heroicon-m-arrow-up',
            self::Down => 'heroicon-m-arrow-down',
            self::Side => 'heroicon-m-arrows-right-left',
        };
    }    
}
