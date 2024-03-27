<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\Events\V1;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class ItemWasModified implements SerializablePayload
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $quantity,
        public float $price,
        public bool $active,
    ) {
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'active' => $this->active,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new self(
            $payload['id'],
            $payload['name'],
            $payload['description'],
            $payload['quantity'],
            $payload['price'],
            $payload['active'],
        );
    }
}
