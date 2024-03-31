<?php

declare(strict_types=1);

namespace App\Item\Shield\Persistence;

use App\Shared\Shield\Redis\RedisClientInterface;
use App\Shared\Shield\Services\JsonWrapper;

final class RedisItemRepository
{
    private const ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private readonly RedisClientInterface $redis,
        private readonly JsonWrapper $jsonWrapper,
    ) {
    }
    public function getById(string $id): ?array
    {
        $key = self::ALL_ITEMS_PREFIX . '_' . $id;
        $row = $this->redis->get($key);
        if (!$row) {
            return null;
        }

        return $this->jsonWrapper->decode($row);
    }
}
