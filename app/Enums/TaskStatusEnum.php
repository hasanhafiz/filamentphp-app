<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskStatusEnum: string implements HasLabel, HasIcon, HasColor, HasDescription
{
    case PENDING = "pending";
    case PROCESSING = "processing";
    case CANCELED = "canceled";
    case COMPLETED = "completed";


    public function getLabel(): string
    {
        // dd($this->name);
        // return ucwords($this->value);

        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::CANCELED => 'Canceled'
        };

    }

    public function getIcon(): string|null
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::PROCESSING => 'heroicon-o-arrow-path',
            self::COMPLETED => 'heroicon-o-check',
            self::CANCELED => 'heroicon-o-x-circle'
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::PENDING => Color::Yellow,
            self::PROCESSING => Color::Cyan,
            self::COMPLETED => Color::Green,
            self::CANCELED => Color::Red
        };
    }

    public function getDescription(): string|null
    {
        return match ($this) {
            self::PENDING => 'These task are in Pending Stage',
            self::PROCESSING => 'These task are in Processing Stage',
            self::COMPLETED => 'Yahoo! These task are Completed!',
            self::CANCELED => 'Opps! These task are Canceled for some reason. Please contact to your admin.'
        };
    }

}
