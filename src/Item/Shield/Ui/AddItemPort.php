<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui;


use App\Item\Core\Command\Add\AddItemCommand;
use App\Shared\Core\Bus\CommandBusInterface;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/item',
    methods: Request::METHOD_POST,
)]
#[AsController]
final readonly class AddItemPort
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        $payload = json_decode($request->getContent());

        if (! $payload) {
            //TODO: Change this for a custom exception
            throw new \RuntimeException('No content!');
        }

        Assert::lazy()->tryAll()
            ->that($payload)
            ->propertyExists(
                'id',
                'Request does not contain id property',
                'itemId.notFound'
            )
            ->propertyExists(
                'name',
                'Request does not contains name property',
                'itemName.notFound'
            )
            ->propertyExists(
                'description',
                'Request does not contains description property',
                'itemDescription.notFound'
            )
            ->propertyExists(
                'quantity',
                'Request does not contains quantity property',
                'itemQuantity.notFound'
            )
            ->propertyExists(
                'price',
                'Request does not contains price property',
                'itemPrice.notFound'
            )
            ->verifyNow();

        $this->commandBus->handle(
            new AddItemCommand(
                id: $payload->id,
                name: $payload->name,
                description: $payload->description,
                quantity: $payload->quantity,
                price: $payload->price
            )
        );

        return new Response('Procesado el comando!', 202);
    }
}
