<?php

declare(strict_types=1);

namespace App\Item\Shield\Persistence;

use App\Item\Core\Aggregate\Item\ItemId;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Item\Core\ItemProjectionPersister;
use App\Shared\Core\ValueObjects\Money;
use App\Shared\Shield\Redis\RedisClientInterface;

final class RedisItemProjectionPersister implements ItemProjectionPersister
{
    private const ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private RedisClientInterface $redis,
    ) {
    }
    public function persist(
        ItemId $id,
        Name $name,
        Description $description,
        Quantity $quantity,
        Money $price,
    ): void
    {
        $key = self::ALL_ITEMS_PREFIX . '_' . $id->toString();
        $this->redis->set($key, json_encode([
            'name' => $name->toString(),
            'description' => $description->toString(),
            'quantity' => $quantity->toInt(),
            'price' => $price->toArray(),
        ]));
    }
}
