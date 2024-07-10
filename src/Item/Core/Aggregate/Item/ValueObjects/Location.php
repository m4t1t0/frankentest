<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\ValueObjects;

use Assert\Assert;

final readonly class Location
{
    public const array AVAILABLE_LOCATIONS = [
        'Main warehouse',
        'Second warehouse',
        'Store',
        'In return',
    ];

    private function __construct(
        private string $value
    ) {
        Assert::lazy()->tryAll()
            ->that($value)
            ->inArray(
                self::AVAILABLE_LOCATIONS,
                'Value must be a valid location',
                'itemLocation.invalidLocation')
            ->verifyNow();
    }

    public static function fromString(string $value): self
    {
        return new self(value: $value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
