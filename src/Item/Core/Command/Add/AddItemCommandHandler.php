<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Add;

use App\Shared\Core\Command\CommandHandlerInterface;
use App\Item\Core\Aggregate\Item\Item;

final readonly class AddItemCommandHandler implements CommandHandlerInterface
{
    public function __construct(
    ) {
    }

    public function handle(AddItemCommand $command): void
    {
        //$repository = $this->factory->instance(Item::class);

        $item = Item::add(
            id: $command->id,
            name: $command->name,
            description: $command->description,
            quantity: $command->quantity,
            price: $command->price,
        );

        //$repository->persist($item);
    }
}
