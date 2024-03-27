<?php

namespace App\Shared\Shield\Bus;

use App\Shared\Core\Bus\Resultable;
use App\Shared\Core\Bus\QueryBusInterface;
use App\Shared\Core\Query\QueryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly class SymfonyQueryBus implements QueryBusInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function ask(QueryInterface|Envelope $message): Resultable
    {
        return new class($this->bus->dispatch($message)) implements Resultable {

            public function __construct(private readonly Envelope $envelope)
            {
            }

            public function getResult(): mixed
            {
                return $this->envelope->last(HandledStamp::class)?->getResult();
            }

            public function getEnvelope(): Envelope
            {
                return $this->envelope;
            }
        };
    }
}
