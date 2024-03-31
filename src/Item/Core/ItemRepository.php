<?php

declare(strict_types=1);

namespace App\Item\Core;

interface ItemRepository
{
    public function getById(string $id): ?array;
}
