<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Core\ValueObjects;

use App\Shared\Core\ValueObjects\Money;
use AssertionError;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    public static function providerEuro(): iterable
    {
        yield 'euro' => [
            [
                'amount' => 33.95,
                'currency' => 'EUR',
            ]
        ];
    }

    public static function providerWrongCurrency(): iterable
    {
        yield 'wrong' => [
            [
                'amount' => 33.95,
                'currency' => 'KKK',
            ]
        ];
    }

    /**
     * @test
     * @dataProvider providerEuro
     * @covers App\Shared\Core\ValueObjects\Money;
     **/
    public function test_from_data(array $moneyProvided): void
    {
        $money = Money::fromData($moneyProvided['amount'], $moneyProvided['currency']);
        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame($moneyProvided, $money->toArray());
    }

    /**
     * @test
     * @dataProvider providerWrongCurrency
     * @covers App\Shared\Core\ValueObjects\Money;
     **/
    public function test_wrong_currency_throws_exception(array $moneyProvided): void
    {
        $this->expectException(AssertionError::class);
        $money = Money::fromData($moneyProvided['amount'], $moneyProvided['currency']);
    }

    /**
     * @test
     * @covers App\Shared\Core\ValueObjects\Money;
     **/
    public function test_rounding(): void
    {
        $money = Money::fromData(33.747, 'EUR');
        $roundedMoney = $money->rounded();
        $this->assertSame(33.75, $roundedMoney->amount());
    }
}
