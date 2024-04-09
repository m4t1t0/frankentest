<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Item;

use Redis;

final class ItemRepository
{
    private const string ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private Redis $redis
    ) {
    }

    public function insertItem(Item $item): void
    {
        $key = self::ALL_ITEMS_PREFIX . '_' . $item->uuid->toRfc4122();
        $this->redis->set($key, json_encode([
                'id' => $item->uuid->toRfc4122(),
                'name' => $item->name,
                'description' => $item->description,
                'price' => [
                    'amount' => $item->price,
                    'currency' => Item::DEFAULT_CURRENCY,
                ],
                'quantity' => $item->quantity,
                'active' => $item->active,
                'created_at' => $item->createdAt,
                'updated_at' => $item->updatedAt,
            ])
        );
    }
}
