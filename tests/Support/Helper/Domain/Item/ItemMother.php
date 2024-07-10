<?php

declare(strict_types=1);

namespace Tests\Support\Helper\Domain\Item;

use Symfony\Component\Uid\Uuid;
use \DateTimeImmutable;

final class ItemMother
{
    public static function createItem(
        ?string $uuid = null,
        ?string $name = null,
        ?string $description = null,
        ?string $location = null,
        ?int $quantity = null,
        ?int $price = null,
        ?bool $active = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
    ): Item {
        $uuid = $uuid ?: Uuid::v7()->toRfc4122();
        $name = $name ?: 'Item created for testing';
        $description = $description ?: 'Este item se ha creado para pruebas';
        $location = $location ?: 'Main warehouse';
        $quantity = $quantity ?: 3;
        $price = $price ?: 25.95;
        $active = $active ?: false;
        $createdAt = $createdAt ?: new DateTimeImmutable();
        $updatedAt = $updatedAt ?: new DateTimeImmutable();

        return new Item(
            $uuid,
            $name,
            $description,
            $location,
            $quantity,
            $price,
            $active,
            $createdAt,
            $updatedAt
        );
    }

    public static function withUuid(string $uuid): Item
    {
        return self::createItem($uuid);
    }
}
