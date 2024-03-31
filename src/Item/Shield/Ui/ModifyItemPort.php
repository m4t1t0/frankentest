<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui;

use App\Item\Core\Command\Modify\ModifyItemCommand;
use App\Shared\Core\Bus\CommandBusInterface;
use App\Shared\Core\Services\JsonWrapperInterface;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/item',
    methods: Request::METHOD_PUT,
)]
#[AsController]
final readonly class ModifyItemPort
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private JsonWrapperInterface $jsonWrapper,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $payload = $this->jsonWrapper->decode($request->getContent());

        if (! $payload) {
            //TODO: Change this for a custom exception
            throw new \RuntimeException('No content!');
        }

        Assert::lazy()->tryAll()
            ->that($payload)
            ->keyExists(
                'id',
                'Request does not contain id property',
                'itemId.notFound'
            )
            ->keyExists(
                'name',
                'Request does not contains name property',
                'itemName.notFound'
            )
            ->keyExists(
                'description',
                'Request does not contains description property',
                'itemDescription.notFound'
            )
            ->keyExists(
                'quantity',
                'Request does not contains quantity property',
                'itemQuantity.notFound'
            )
            ->keyExists(
                'price',
                'Request does not contains price property',
                'itemPrice.notFound'
            )
            ->verifyNow();

        $this->commandBus->handle(
            new ModifyItemCommand(
                id: $payload['id'],
                name: $payload['name'],
                description: $payload['description'],
                quantity: $payload['quantity'],
                price: $payload['price']
            )
        );

        return new Response('', 202);
    }
}
