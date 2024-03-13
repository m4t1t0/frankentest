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

    public function exists(string $key): bool
    {
        return $this->redis->exists($key);
    }

    public function rpush(string $key, string $value): int
    {
        return $this->redis->rpush($key, $value);
    }

    public function lpop(string $key): string
    {
        return $this->redis->lpop($key);
    }

    public function keys(string $pattern): array
    {
        return $this->keys($pattern);
    }
}
