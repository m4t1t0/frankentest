<?php

namespace App\Shared\Shield\Bus;

use App\Shared\Core\Bus\CommandBusInterface;
use App\Shared\Core\Command\CommandInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class SymfonyCommandBus implements CommandBusInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @param CommandInterface|Envelope $message
     * @return void
     */
    public function handle(CommandInterface|Envelope $message): void
    {
        $this->bus->dispatch($message);
    }
}
