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
        $result = $this->redis->jsonGet($key);
        if (!$result) {
            return null;
        }

        $result = $this->jsonWrapper->decode($result);
        if (!$result[0]) {
            return null;
        }

        $row = $result[0];

        $collection = new ArrayCollection();
        $collection->add($row);

        return $collection;
    }

    public function findByCriteria(): ArrayCollection
    {
        $collection = new ArrayCollection();
        $keys = $this->redis->keys(self::ALL_ITEMS_PREFIX . '_*');

        foreach ($keys as $key) {
            $result = $this->redis->jsonGet($key);
            if ($result) {
                $row = $this->jsonWrapper->decode($result);
                if ($row && $row[0]) {
                    $collection->add($row[0]);
                }
            }
        }

        return $collection;
    }
}
