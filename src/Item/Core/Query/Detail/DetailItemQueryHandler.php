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
        $row = $this->repository->getById($query->id); //Devolver una estructura mejor que el array

        if (! $row) {
            return new ItemDetailReadModelNotFound();
        }

        return new ItemDetailReadModel(
            id: $row['id'],
            name: $row['name'],
            description: $row['description'],
            quantity: $row['quantity'],
            price: $row['price'],
            active: $row['active'],
        );
    }
}
