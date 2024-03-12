<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

use Redis;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisClient implements RedisClientInterface
{
    private Redis $redis;
    public function __construct(string $dsn)
    {
        $this->redis = RedisAdapter::createConnection($dsn);
    }

    public function set(string $key, string $value): Redis|bool
    {
        return $this->redis->set($key, $value);
    }
}
