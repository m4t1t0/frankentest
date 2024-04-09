<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Event;

use Symfony\Component\Uid\Uuid;

final class Event
{
    public Uuid $aggregateId;
    public array $headers;
    public array $payload;

    public function __construct(
        string $aggregateId,
        array $headers,
        array $payload,
    ) {
        $this->aggregateId = Uuid::fromString($aggregateId);
        $this->headers = $headers;
        $this->payload = $payload;
    }
}
