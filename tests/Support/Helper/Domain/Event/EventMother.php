<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Event;

use Symfony\Component\Uid\Uuid;
use DateTime;
use Tests\Support\Helper\Domain\Aggregate\Aggregate;

final class EventMother
{
    private static function createEvent(
        ?string $aggregateId = null,
        ?array $headers = null,
        ?array $payload = null,
    ): Event {
        $aggregateId = $aggregateId ?: Uuid::v7()->toRfc4122();
        $headers = $headers ?: [
            '__time_of_recording' => '2024-04-08 21:11:33.113832+0000',
            '__time_of_recording_format' => 'Y-m-d H:i:s.uO',
            '__aggregate_root_id' => $aggregateId,
            '__aggregate_root_type' => 'app.item.core.aggregate.item.item',
            '__aggregate_root_version' => 1,
            '__event_type' => 'app.item.core.aggregate.item.events.v1.item_was_added',
            '__aggregate_root_id_type' => 'app.item.core.aggregate.item.item_id',
        ];

        $payload = $payload ?: [
            'id' => $aggregateId,
            'name' => 'Prueba 1',
            'description' => 'Primera prueba',
            'quantity' => 5,
            'price' => 10.95,
            'active' => true,
        ];

        return new Event(
            $aggregateId,
            $headers,
            $payload
        );
    }

    public static function withUuid(string $aggregateId): Event
    {
        return self::createEvent(aggregateId: $aggregateId);
    }
}
