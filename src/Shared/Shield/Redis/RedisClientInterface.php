<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

use Redis;

interface RedisClientInterface
{
    public function set(string $key, string $value): Redis|bool;
}
