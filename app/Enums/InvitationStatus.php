<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvitationStatus: string implements HasLabel, HasColor, HasIcon
{
    case SENT = 'sent';
    case ACCEPTED = 'accepted';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SENT => __('Sent'),
            self::ACCEPTED => __('Accepted'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SENT => 'warning',
            self::ACCEPTED => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::SENT => 'heroicon-o-clock',
            self::ACCEPTED => 'heroicon-o-check-circle',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
