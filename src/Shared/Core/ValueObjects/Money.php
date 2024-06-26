<?php

declare(strict_types=1);

namespace App\Shared\Core\ValueObjects;

use Locale;
use NumberFormatter;
use Symfony\Component\Intl\Currencies;

readonly class Money
{
    private function __construct(
        private float $amount,
        private string $currency
    ) {
    }

    public static function fromData(float $amount, string $iso3): self
    {
        assert(Currencies::exists($iso3));
        return new self ($amount, $iso3);
    }

    public function toString(): string
    {
        $fmt = new NumberFormatter(Locale::getDefault(), NumberFormatter::CURRENCY);

        return $fmt->formatCurrency($this->amount, $this->currency);
    }

    public function toArray(): array{
        return [
            'amount' => $this->amount,
            'currency'=>$this->currency
        ];
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function rounded(): self
    {
        $currency = $this->currency;
        $fmt = new NumberFormatter(Locale::getDefault(), NumberFormatter::CURRENCY);
        $result = $fmt->parseCurrency($fmt->formatCurrency($this->amount, $currency),$currency);
        if ($result === false) {
            throw new \InvalidArgumentException(sprintf('Cannot parse %s "%s"', $this->amount, $currency));
        }

        return new self($result, $currency);
    }
}
