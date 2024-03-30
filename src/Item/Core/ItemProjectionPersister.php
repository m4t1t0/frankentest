<?php

declare(strict_types=1);

namespace App\Item\Core;

use App\Item\Core\Aggregate\Item\ItemId;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Shared\Core\ValueObjects\Money;

interface ItemProjectionPersister
{
    public function persist(
        ItemId $id,
        Name $name,
        Description $description,
        Quantity $quantity,
        Money $price,
        bool $active,
        ?string $dateAdd,
        string $dateUpd,
    ): void;
}
