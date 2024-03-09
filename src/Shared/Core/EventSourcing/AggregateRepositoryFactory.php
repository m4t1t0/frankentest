<?php

declare(strict_types=1);

namespace App\Shared\Core\EventSourcing;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageRepository;

readonly class AggregateRepositoryFactory
{
    public function __construct(
        private MessageRepository $messageRepository,
    ) {
    }

    /**
     * @param class-string<AggregateRoot> $className
     */
    public function instance(string $className): EventSourcedAggregateRootRepository
    {
        return new EventSourcedAggregateRootRepository($className, $this->messageRepository);
    }
}
