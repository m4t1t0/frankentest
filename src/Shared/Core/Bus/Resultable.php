<?php

namespace App\Shared\Core\Bus;

interface Resultable
{
    public function getResult(): mixed;
}
