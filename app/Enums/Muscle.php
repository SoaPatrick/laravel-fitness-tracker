<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;


enum Muscle: string implements HasLabel
{
    case Bauch = 'bauch';
    case Beine = 'beine';
    case Bizeps = 'bizeps';
    case Brust = 'brust';
    case Nacken = 'nacken';
    case Po = 'po';
    case Ruecken = 'ruecken';
    case Schultern = 'schultern';
    case Trizeps = 'trizeps';
    case Unterarm = 'unterarm';
    case Waden = 'waden';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::Bauch => 'Bauch',
            self::Beine => 'Beine',
            self::Bizeps => 'Bizeps',
            self::Brust => 'Brust',
            self::Nacken => 'Nacken',
            self::Po => 'Po',
            self::Ruecken => 'Rücken',
            self::Schultern => 'Schultern',
            self::Trizeps => 'Trizeps',
            self::Unterarm => 'Unterarm',
            self::Waden => 'Waden',
        };
    }
}
