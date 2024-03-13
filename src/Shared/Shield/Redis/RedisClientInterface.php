<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

use Redis;

interface RedisClientInterface
{
    public function set(string $key, string $value): Redis|bool;
    public function exists(string $key): bool;
    public function rpush(string $key, string $value): int;
    public function lpop(string $key): string;
    public function keys(string $pattern): array;
}
