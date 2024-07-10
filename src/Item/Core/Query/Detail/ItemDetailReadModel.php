<?php

declare(strict_types=1);

namespace App\Item\Core\Query\Detail;

use App\Item\Core\Aggregate\Item\ItemId;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;
use App\Item\Core\Aggregate\Item\ValueObjects\Location;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
use App\Shared\Core\ValueObjects\Money;

class ItemDetailReadModel
{
    public readonly ItemId $id;
    public readonly Name $name;
    public readonly Description $description;
    public readonly Location $location;
    public readonly Quantity $quantity;
    public readonly Money $price;
    public readonly bool $active;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $location,
        int $quantity,
        array $price,
        bool $active,
    ) {
        $this->id = ItemId::fromString($id);
        $this->name = Name::fromString($name);
        $this->description = Description::fromString($description);
        $this->location = Location::fromString($location);
        $this->quantity = Quantity::fromInt($quantity);
        $this->price = Money::fromData(
            amount: $price['amount'],
            iso3: $price['currency']
        );
        $this->active = $active;
    }
}
