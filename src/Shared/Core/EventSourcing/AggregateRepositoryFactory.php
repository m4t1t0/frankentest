<?php

declare(strict_types=1);

namespace App\Shared\Core\EventSourcing;

use App\Item\Core\Command\Modify\ModifyItemProjection;
use App\Item\Core\ItemProjectionPersister;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;
use App\Item\Core\Command\Add\AddItemProjection;

readonly class AggregateRepositoryFactory
{
    public function __construct(
        private MessageRepository $messageRepository,
        private ItemProjectionPersister $projection,
    ) {
    }

    /**
     * @param class-string<AggregateRoot> $className
     */
    public function instance(string $className): EventSourcedAggregateRootRepository
    {
        $messageDispatcher = new SynchronousMessageDispatcher(
            new AddItemProjection($this->projection),
            new ModifyItemProjection($this->projection),
        );

        return new EventSourcedAggregateRootRepository(
            $className,
            $this->messageRepository,
            $messageDispatcher
        );
    }
}
