<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Add;

use App\Shared\Core\Command\CommandInterface;

/**
 * @see AddItemCommandHandler
 */
final readonly class AddItemCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $location,
        public int $quantity,
        public float $price,
    ) {
    }
}
