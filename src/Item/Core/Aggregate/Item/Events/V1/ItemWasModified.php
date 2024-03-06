<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\Events\V1;

final readonly class ItemWasModified
{
    public function __construct(
        public string $id,
        public string $lang,
        public string $name,
        public string $description,
        public string $region,
    ) {
    }
}
