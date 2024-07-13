<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui\ViewModels;

use App\Item\Core\Query\List\ItemListReadModel;

final readonly class ItemListViewModel
{
    public string $id;
    public string $name;
    public string $description;
    public string $location;
    public int $quantity;
    public array $price; //Cambiar esto por un DTO
    public bool $active;

    public function __construct(
        ItemListReadModel $item,
    ) {
        $this->id = $item->id->toString();
        $this->name = $item->name->toString();
        $this->description = $item->description->toString();
        $this->location = $item->location->toString();
        $this->quantity = $item->quantity->toInt();
        $this->price = $item->price->toArray();
        $this->active = $item->active;
    }
}
