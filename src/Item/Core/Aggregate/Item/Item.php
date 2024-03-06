<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item;

use App\Item\Core\Aggregate\Item\Events\V1\ItemWasAdded;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Item\Core\Aggregate\Item\ValueObjects\Region;
use App\Shared\Core\ValueObjects\Money;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class Item implements AggregateRoot
{
    use AggregateRootBehaviour;

    const string DEFAULT_CURRENCY = 'EUR';

    protected Name $name;
    protected Description $description;
    protected Quantity $quantity;
    protected Money $price;
    protected bool $active;

    public static function add(
        string $id,
        string $name,
        string $description,
        int $quantity,
        float $price,
    ): self {
        $self = new static(ItemId::fromString($id));
        $self->recordThat(
            new ItemWasAdded(
                id: $id,
                name: $name,
                description: $description,
                quantity: $quantity,
                price: $price,
            )
        );

        return $self;
    }

    protected function applyItemWasAdded(ItemWasAdded $event): void
    {
        $this->name = Name::fromString($event->name);
        $this->description = Description::fromString($event->description);
        $this->quantity = Quantity::fromInt($event->quantity);
        $this->price = Money::fromData($event->price, static::DEFAULT_CURRENCY);
        $this->active = $event->active;
    }
}
