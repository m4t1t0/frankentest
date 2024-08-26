<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Item;

use Redis;

final readonly class ItemRepository
{
    private const string ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private Redis $redis,
        private string $prefix,
    ) {
    }

    public function insertItem(Item $item): void
    {
        $key = $this->prefix . self::ALL_ITEMS_PREFIX . ':' . $item->uuid->toRfc4122();
        $this->redis->rawCommand('JSON.SET', $key, '$', json_encode([
                'id' => $item->uuid->toRfc4122(),
                'name' => $item->name,
                'description' => $item->description,
                'location' => $item->location,
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
