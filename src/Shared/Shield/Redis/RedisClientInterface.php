<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

use Redis;

interface RedisClientInterface
{
    public function get(string $key): mixed;
    public function set(string $key, string $value): Redis|bool;
    public function exists(string $key): bool;
    public function rpush(string $key, string $value): int;
    public function lrange(string $key, int $start = 0, int $end = -1): array;
    public function keys(string $pattern): array;
}
