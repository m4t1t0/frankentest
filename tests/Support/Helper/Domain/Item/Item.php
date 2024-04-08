<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Item;


use Symfony\Component\Uid\Uuid;

final class Item
{
    public const string DEFAULT_CURRENCY = 'EUR';

    public Uuid $uuid;
    public string $name;
    public string $description;
    public int $quantity;
    public float $price;
    public bool $active;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $updatedAt;

    public function __construct(
        string $uuid,
        string $name,
        string $description,
        int $quantity,
        float $price,
        bool $active,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ) {
        $this->uuid = Uuid::fromString($uuid);
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->active = $active;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
