<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui\Http\Ports;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/item/{id}',
    methods: Request::METHOD_GET,
)]
#[AsController]
final class ShowItemDetailPort
{
    public function __construct()
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response('Hola caracola', 200);
    }
}
