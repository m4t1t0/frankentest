<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Modify;

use App\Item\Core\Aggregate\Item\Events\V1\ItemWasModified;
use App\Item\Core\Aggregate\Item\ItemId;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Item\Core\ItemProjectionPersister;
use App\Shared\Core\ValueObjects\Money;
use EventSauce\EventSourcing\EventConsumption\EventConsumer;
use EventSauce\EventSourcing\Message;

class ModifyItemProjection extends EventConsumer
{
    const string DEFAULT_CURRENCY = 'EUR';

    public function __construct(
        private ItemProjectionPersister $projection,
    ) {
    }

    public function handleItemWasModified(ItemWasModified $event, Message $message): void
    {
        $this->projection->persist(
            id: ItemId::fromString($event->id),
            name: Name::fromString($event->name),
            description: Description::fromString($event->description),
            quantity: Quantity::fromInt($event->quantity),
            price: Money::fromData($event->price, static::DEFAULT_CURRENCY)
        );
    }
}
