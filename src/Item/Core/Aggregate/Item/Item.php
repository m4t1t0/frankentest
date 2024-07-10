<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item;

use App\Item\Core\Aggregate\Item\Events\V1\ItemWasAdded;
use App\Item\Core\Aggregate\Item\Events\V1\ItemWasModified;
use App\Item\Core\Aggregate\Item\ValueObjects\Location;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Shared\Core\ValueObjects\Money;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class Item implements AggregateRoot
{
    use AggregateRootBehaviour;

    const string DEFAULT_CURRENCY = 'EUR';

    protected Name $name;
    protected Description $description;
    protected Location $location;
    protected Quantity $quantity;
    protected Money $price;
    protected bool $active;

    public static function add(
        string $id,
        string $name,
        string $description,
        string $location,
        int $quantity,
        float $price,
    ): self {
        $self = new static(ItemId::fromString($id));
        $self->recordThat(
            new ItemWasAdded(
                id: $id,
                name: $name,
                description: $description,
                location: $location,
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
        $this->location = Location::fromString($event->location);
        $this->quantity = Quantity::fromInt($event->quantity);
        $this->price = Money::fromData($event->price, static::DEFAULT_CURRENCY);
        $this->active = $event->active;
    }

    public function modify(
        string $name,
        string $description,
        string $location,
        int $quantity,
        float $price,
    ): void {
        $this->recordThat(
            new ItemWasModified(
                id: (string)$this->aggregateRootId(),
                name: $name,
                description: $description,
                location: $location,
                quantity: $quantity,
                price: $price,
                active: $this->active,
            ),
        );
    }

    protected function applyItemWasModified(ItemWasModified $event): void
    {
        $this->name = Name::fromString($event->name);
        $this->description = Description::fromString($event->description);
        $this->location = Location::fromString($event->location);
        $this->quantity = Quantity::fromInt($event->quantity);
        $this->price = Money::fromData($event->price, static::DEFAULT_CURRENCY);
    }
}
