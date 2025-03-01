<?php

namespace App\Enums;

enum PackageType: string

{
    case DEFAULT = 'default';
    case TRIAL = 'trial';
    case STANDARD = 'standard';
    case LIFETIME = 'lifetime';
    case FREE = 'free';

    public function label(): string
    {
        return match ($this) {
            self::DEFAULT => 'Default',
            self::TRIAL => 'Trial',
            self::FREE => 'Free',
            self::STANDARD => 'Standard',
            self::LIFETIME => 'Lifetime',
        };
    }

    /**
     * Check if the package type is editable.
     *
     * @return bool
     */
    public function isEditable(): bool
    {
        return !in_array($this, [self::DEFAULT, self::TRIAL], true);
    }

    /**
     * Check if the package type is deletable.
     *
     * @return bool
     */
    public function isDeletable(): bool
    {
        return !in_array($this, [self::DEFAULT, self::TRIAL], true);
    }
}
