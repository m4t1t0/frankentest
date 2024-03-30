<?php

declare(strict_types=1);

namespace App\Shared\Shield\Services\Clock;

use Psr\Clock\ClockInterface;
use DateTimeImmutable;

final class Clock implements ClockInterface
{
    private DateTimeImmutable $dateTime;
    public function __construct()
    {
        $this->dateTime = new DateTimeImmutable();
    }
    public function now(): DateTimeImmutable
    {
        return $this->dateTime;
    }
}
