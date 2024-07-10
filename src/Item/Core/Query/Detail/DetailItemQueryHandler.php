<?php

declare(strict_types=1);

namespace App\Item\Core\Query\Detail;

use App\Item\Core\ItemRepository;
use App\Shared\Core\Query\QueryHandlerInterface;

readonly final class DetailItemQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ItemRepository $repository,
    ) {
    }

    public function handle(DetailItemQuery $query): ItemDetailReadModel|ItemDetailReadModelNotFound
    {
        $collection = $this->repository->getById($query->id);

        if (! $collection) {
            return new ItemDetailReadModelNotFound();
        }

        $row = $collection->current();

        return new ItemDetailReadModel(
            id: $row['id'],
            name: $row['name'],
            description: $row['description'],
            location: $row['location'],
            quantity: $row['quantity'],
            price: $row['price'],
            active: $row['active'],
        );
    }
}
