<?php

namespace App\Item\Core\Aggregate\Item;

use EventSauce\EventSourcing\AggregateRootId;
use Symfony\Component\Uid\Uuid;

readonly class ItemId implements AggregateRootId, \Stringable
{
    private function __construct(private Uuid $id)
    {
    }

    public function toString(): string
    {
        return (string)$this->id;
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new self(Uuid::fromString($aggregateRootId));
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
