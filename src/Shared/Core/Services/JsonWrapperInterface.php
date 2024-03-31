<?php

declare(strict_types=1);

namespace App\Shared\Core\Services;

interface JsonWrapperInterface
{
    public function encode(array $value): false|string;
    public function decode(string $json): array;
}
