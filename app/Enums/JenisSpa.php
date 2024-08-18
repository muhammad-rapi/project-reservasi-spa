<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum JenisSpa: string implements HasLabel
{
    case Ibu = 'Ibu';
    case Anak = 'Anak';

    public function getLabel(): string
    {
        return match ($this) {
            self::Ibu => 'Ibu',
            self::Anak => 'Anak',
        };
    }
}
