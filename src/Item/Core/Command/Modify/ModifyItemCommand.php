<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Modify;

use App\Shared\Core\Command\CommandInterface;

/**
 * @see ModifyItemCommandHandler
 */
final readonly class ModifyItemCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public int $quantity,
        public float $price,
    ) {
    }
}
