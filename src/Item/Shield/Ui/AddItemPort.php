<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui;


use App\Item\Core\Command\Add\AddItemCommand;
use App\Shared\Core\Bus\CommandBusInterface;
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
        $this->commandBus->handle(
            new AddItemCommand(
                id: '6bf4d9f2-0cd1-4b0e-b92c-ba7a05811861',
                name: 'Prueba 1',
                description: 'Primera prueba',
                quantity: 5,
                price: 10.95
            )
        );

        return new Response('Procesado el comando!', 202);
    }
}
