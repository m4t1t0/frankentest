<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui;

use App\Item\Core\Query\Detail\DetailItemQuery;
use App\Item\Core\Query\Detail\ItemDetailReadModelNotFound;
use App\Shared\Core\Bus\QueryBusInterface;
use App\Item\Shield\Ui\ViewModels\ItemDetailViewModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route(
    path: '/api/item/{id}',
    methods: Request::METHOD_GET,
)]
#[AsController]
final class ShowItemDetailPort
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $itemId = $request->get('id');

        $readModel = $this->queryBus->ask(
            new DetailItemQuery($itemId)
        )->getResult();

        if ($readModel instanceof ItemDetailReadModelNotFound) {
            throw new NotFoundHttpException('Item was not found');
        }

        return new JsonResponse(
            new ItemDetailViewModel($readModel)
        );
    }
}
