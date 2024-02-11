<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;


enum AppointmentStatus: string implements HasLabel, HasColor
{

    case Pending = 'pending';
    case Confirmed = 'confiremed';
    case Canceled = 'canceled';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Canceled => 'danger',
        };
    }
}