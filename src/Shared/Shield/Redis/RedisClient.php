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

    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }

    public function set(string $key, string $value): Redis|bool
    {
        return $this->redis->set($key, $value);
    }

    public function exists(string $key): bool
    {
        return (bool)$this->redis->exists($key);
    }

    public function rpush(string $key, string $value): int
    {
        return $this->redis->rpush($key, $value);
    }

    public function lrange(string $key, int $start = 0, int $end = -1): array
    {
        return $this->redis->lrange($key, $start, $end);
    }

    public function keys(string $pattern): array
    {
        return $this->redis->keys($pattern);
    }
}
