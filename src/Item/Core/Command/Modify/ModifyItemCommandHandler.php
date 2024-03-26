<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Modify;

use App\Item\Core\Aggregate\Item\Item;
use App\Item\Core\Aggregate\Item\ItemId;
use App\Shared\Core\Command\CommandHandlerInterface;
use App\Shared\Core\EventSourcing\AggregateRepositoryFactory;

final readonly class ModifyItemCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AggregateRepositoryFactory $factory,
    ) {
    }

    public function handle(ModifyItemCommand $command): void
    {
        $repository = $this->factory->instance(Item::class);

        /** @var Item $item */
        $item = $repository->retrieve(ItemId::fromString($command->id));

        $item->modify(
            name: $command->name,
            description: $command->description,
            quantity: $command->quantity,
            price: $command->price,
        );

        $repository->persist($item);
    }
}
