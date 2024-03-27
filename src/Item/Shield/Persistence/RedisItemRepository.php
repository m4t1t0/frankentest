<?php

declare(strict_types=1);

namespace App\Item\Shield\Persistence;

use App\Shared\Shield\Redis\RedisClientInterface;

final class RedisItemRepository
{
    private const ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private readonly RedisClientInterface $redis,
    ) {
    }
    public function getById(string $id): ?array
    {
        $key = self::ALL_ITEMS_PREFIX . '_' . $id;
        $row = $this->redis->get($key);
        if (!$row) {
            return null;
        }

        return json_decode($row, true);
    }
}
