<?php

declare(strict_types=1);

namespace App\Item\Core;

use Doctrine\Common\Collections\Collection;

interface ItemRepository
{
    public function createSearchIndex(): void;

    public function getById(string $id): ?Collection;

    public function findByCriteria(): Collection;
}
