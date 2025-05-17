<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum InvitationGroupType: string implements HasLabel
{
    case MANAGERS = 'managers';
    case PEERS = 'peers';
    case SUBORDINATES = 'subordinates';
    case FRIENDS_AND_FAMILY = 'friends_and_family';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MANAGERS => __('Managers'),
            self::PEERS => __('Peers'),
            self::SUBORDINATES => __('Subordinates'),
            self::FRIENDS_AND_FAMILY => __('Friends & Family'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MANAGERS => 'heroicon-o-user-tie',
            self::PEERS => 'heroicon-o-users',
            self::SUBORDINATES => 'heroicon-o-user-group',
            self::FRIENDS_AND_FAMILY => 'heroicon-o-heart',
        };
    }
}
