<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum TransferType: string implements HasLabel
{
    case VOLAN = 'Volan';
    case BALAZS_BUSZ = 'Balazs busz';
    case MIKROBUSZ = 'Mikrobusz';
    case TAXI = 'Taxi';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
