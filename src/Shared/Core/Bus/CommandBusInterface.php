<?php

namespace App\Shared\Core\Bus;

use App\Shared\Core\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $message): void;
}
