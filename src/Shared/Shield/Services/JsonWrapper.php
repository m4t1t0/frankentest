<?php

declare(strict_types=1);

namespace App\Shared\Shield\Services;

use App\Shared\Core\Services\JsonWrapperInterface;

final class JsonWrapper implements JsonWrapperInterface
{
    public function encode(array $value): false|string
    {
        return json_encode($value);
    }

    public function decode(string $json): array
    {
        return json_decode($json, true);
    }
}
