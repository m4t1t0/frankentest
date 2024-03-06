<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\ValueObjects;

use Assert\Assert;

final readonly class Description implements \Stringable
{
    private function __construct(
        private string $value
    ) {
        Assert::lazy()->tryAll()
            ->that($value)
            ->string('Value must be a string', 'itemDescription.invalidType')
            ->notEmpty('Value must not be empty', 'itemDescription.notEmpty')
            ->maxLength(128, 'Value must be 128 characters length', 'itemDescription.invalidLength')
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
