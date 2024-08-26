<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

use Redis;
use Symfony\Component\Cache\Adapter\RedisAdapter;

final readonly class RedisClient implements RedisClientInterface
{
    private Redis $redis;
    private string $prefix;

    public function __construct(string $dsn, string $prefix)
    {
        $this->redis = RedisAdapter::createConnection($dsn);
        $this->prefix = $prefix;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
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
        return $this->redis->rPush($key, $value);
    }

    public function lrange(string $key, int $start = 0, int $end = -1): array
    {
        return $this->redis->lRange($key, $start, $end);
    }

    public function keys(string $pattern): array
    {
        return $this->redis->keys($pattern);
    }

    public function rawCommand(string $command, mixed ...$arguments): mixed
    {
        return $this->redis->rawCommand($command, ...$arguments);
    }

    public function jsonSet(string $key, string $payload): Redis|bool
    {
        return $this->rawCommand('JSON.SET', $key, '$', $payload);
    }

    public function jsonGet(string $key): mixed
    {
        return $this->rawCommand('JSON.GET', $key, '$');
    }
}
