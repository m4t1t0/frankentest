<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Event;

use Redis;

final readonly class EventRepository
{
    private const string EVENTS_PREFIX = 'es_events';

    public function __construct(
        private Redis $redis,
        private string $prefix,
    ) {
    }

    public function insertEvent(Event $event): void
    {
        $key = $this->prefix . self::EVENTS_PREFIX . ':' . $event->aggregateId->toRfc4122();
        $this->redis->rPush($key, json_encode([
                'headers' => $event->headers,
                'payload' => $event->payload,
            ])
        );
    }
}
