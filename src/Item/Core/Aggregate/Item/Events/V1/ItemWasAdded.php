<?php

declare(strict_types=1);

namespace App\Item\Core\Aggregate\Item\Events\V1;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

final readonly class ItemWasAdded implements SerializablePayload
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $location,
        public int $quantity,
        public float $price,
        public bool $active = true,
    ) {
    }

    public function toPayload(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
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
            $payload['location'],
            $payload['quantity'],
            $payload['price'],
            $payload['active'],
        );
    }
}
