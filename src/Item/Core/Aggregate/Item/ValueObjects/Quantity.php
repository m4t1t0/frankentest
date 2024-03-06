<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\ValueObjects;

use Assert\Assert;

final readonly class Quantity
{
    private function __construct(
        private int $value
    ) {
        Assert::lazy()->tryAll()
            ->that($value)
            ->integer('Value must be an integer ', 'itemQuantity.invalidType')
            ->verifyNow();
    }

    public static function fromInt(int $value): self
    {
        return new self(value: $value);
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
