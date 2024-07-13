<?php

declare(strict_types=1);

namespace App\Item\Core\Query\List;

use App\Item\Core\ItemRepository;
use App\Shared\Core\Query\QueryHandlerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

readonly final class ListItemsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ItemRepository $repository,
    ) {
    }

    public function handle(ListItemsQuery $query): Collection
    {
        $result = new ArrayCollection();
        $items = $this->repository->findByCriteria();

        foreach ($items as $item) {
            $result->add(new ItemListReadModel(
                id: $item['id'],
                name: $item['name'],
                description: $item['description'],
                location: $item['location'],
                quantity: $item['quantity'],
                price: $item['price'],
                active: $item['active'],
            ));
        }

        return $result;
    }
}
