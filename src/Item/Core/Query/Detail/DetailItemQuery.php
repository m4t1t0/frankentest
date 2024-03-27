<?php

namespace App\Item\Core\Query\Detail;

use App\Shared\Core\Query\QueryInterface;

class DetailItemQuery implements QueryInterface
{
    public function __construct(public string $id)
    {
    }
}
