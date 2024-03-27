<?php

declare(strict_types=1);

namespace App\Item\Shield\Ui\ViewModels;

use App\Item\Core\Query\Detail\ItemDetailReadModel;

final readonly class ItemDetailViewModel
{
    public string $id;
    public string $name;
    public string $description;
    public int $quantity;
    public array $price; //Cambiar esto por un DTO
    public bool $active;

    public function __construct(
        ItemDetailReadModel $item,
    ) {
        $this->id = $item->id->toString();
        $this->name = $item->name->toString();
        $this->description = $item->description->toString();
        $this->quantity = $item->quantity->toInt();
        $this->price = $item->price->toArray();
        $this->active = $item->active;
    }
}
