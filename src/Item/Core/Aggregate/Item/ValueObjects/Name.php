<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\ValueObjects;

use Assert\Assert;

final readonly class Name implements \Stringable
{
    private function __construct(
        private string $value
    ) {
        Assert::lazy()->tryAll()
            ->that($value)
            ->string('Value must be a string', 'itemName.invalidType')
            ->notEmpty('Value must not be empty', 'itemName.notEmpty')
            ->maxLength(64, 'Value must be 64 characters length', 'itemName.invalidLength')
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
