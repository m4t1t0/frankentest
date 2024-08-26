<?php

declare(strict_types=1);

namespace App\Item\Shield\Persistence;

use App\Item\Core\Aggregate\Item\ItemId;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Location;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Item\Core\ItemProjectionPersister;
use App\Shared\Core\Services\JsonWrapperInterface;
use App\Shared\Core\ValueObjects\Money;
use App\Shared\Shield\Redis\RedisClientInterface;

final class RedisItemProjectionPersister implements ItemProjectionPersister
{
    private const string ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private readonly RedisClientInterface $redis,
        private readonly JsonWrapperInterface $jsonWrapper,
    ) {
    }

    public function persist(
        ItemId $id,
        Name $name,
        Description $description,
        Location $location,
        Quantity $quantity,
        Money $price,
        bool $active,
        ?string $dateAdd,
        string $dateUpd
    ): void
    {
        $key = $this->redis->getPrefix() . self::ALL_ITEMS_PREFIX . ':' . $id->toString();

        $row = $this->redis->get($key);
        if ($row) {
            $decodedRow = $this->jsonWrapper->decode($row);
        }

        $this->redis->jsonSet($key, $this->jsonWrapper->encode([
            'id' => $id->toString(),
            'name' => $name->toString(),
            'description' => $description->toString(),
            'location' => $location->toString(),
            'quantity' => $quantity->toInt(),
            'price' => $price->toArray(),
            'active' => $active,
            'date_add' => $dateAdd ?: ($decodedRow['date_add'] ?? null),
            'date_upd' => $dateUpd,
        ]));
    }
}
