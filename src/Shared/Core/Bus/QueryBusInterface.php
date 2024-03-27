<?php

namespace App\Shared\Core\Bus;

use App\Shared\Core\Query\QueryInterface;

interface QueryBusInterface
{
    public function ask(QueryInterface $message): Resultable;
}
