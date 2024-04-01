<?php

declare(strict_types=1);

namespace App\Item\Shield\Persistence;

use App\Item\Core\ItemRepository;
use App\Shared\Shield\Redis\RedisClientInterface;
use App\Shared\Shield\Services\JsonWrapper;
use Doctrine\Common\Collections\ArrayCollection;

final class RedisItemRepository implements ItemRepository
{
    private const string ALL_ITEMS_PREFIX = 'all_items';

    public function __construct(
        private readonly RedisClientInterface $redis,
        private readonly JsonWrapper $jsonWrapper,
    ) {
    }
    public function getById(string $id): ?ArrayCollection
    {
        $key = self::ALL_ITEMS_PREFIX . '_' . $id;
        $row = $this->redis->get($key);
        if (!$row) {
            return null;
        }

        $collection = new ArrayCollection();
        $collection->add($this->jsonWrapper->decode($row));

        return $collection;
    }
}
