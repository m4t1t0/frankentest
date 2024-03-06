<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\Events\V1;

final readonly class ItemWasAdded
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $quantity,
        public float $price,
        public bool $active = true,
    ) {
    }
}
