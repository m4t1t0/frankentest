<?php

declare(strict_types=1);

namespace App\Shared\Shield\Redis;

class ReadRedisClient extends RedisClient
{
    public function __construct(string $dsn)
    {
        parent::__construct($dsn);
    }
}
