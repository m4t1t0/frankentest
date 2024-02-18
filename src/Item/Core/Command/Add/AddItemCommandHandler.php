<?php

declare(strict_types=1);

namespace App\Item\Core\Command\Add;

use App\Shared\Core\Command\CommandHandlerInterface;

final readonly class AddItemCommandHandler implements CommandHandlerInterface
{
    public function __construct(
    ) {
    }

    public function handle(AddItemCommand $command): void
    {
        echo "LLego!!";
    }
}
