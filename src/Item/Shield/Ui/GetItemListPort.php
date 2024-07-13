<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui;

use App\Item\Core\Query\List\ListItemsQuery;
use App\Item\Shield\Ui\ViewModels\ItemListViewModel;
use App\Shared\Core\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/items',
    methods: Request::METHOD_GET,
)]
#[AsController]
final class GetItemListPort
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $items = $this->queryBus->ask(
            new ListItemsQuery()
        )->getResult();

        $result = [];
        foreach ($items as $item) {
            $result[] = new ItemListViewModel($item);
        }

        return new JsonResponse($result);
    }
}
