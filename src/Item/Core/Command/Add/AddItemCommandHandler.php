<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Add;

use App\Item\Core\Aggregate\Item\Item;
use App\Shared\Core\Command\CommandHandlerInterface;
use App\Shared\Core\EventSourcing\AggregateRepositoryFactory;

final readonly class AddItemCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AggregateRepositoryFactory $factory,
    ) {
    }

    public function handle(AddItemCommand $command): void
    {
        $repository = $this->factory->instance(Item::class);

        $item = Item::add(
            id: $command->id,
            name: $command->name,
            description: $command->description,
            location: $command->location,
            quantity: $command->quantity,
            price: $command->price,
        );

        $repository->persist($item);
    }
}
