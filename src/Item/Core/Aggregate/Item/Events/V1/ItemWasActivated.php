<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\Events\V1;

final readonly class ItemWasActivated
{
    public function __construct(
        public string $id,
    ) {
    }
}
