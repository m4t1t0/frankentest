<?php

declare(strict_types=1);

namespace Tests\Unit\Item\Core\Aggregate\Item\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Item\Core\Aggregate\Item\ValueObjects\Quantity;

final class QuantityTest extends TestCase
{
    public static function providerQuantity(): iterable
    {
        yield 'one' => [1];
    }

    /**
     * @test
     * @dataProvider providerQuantity
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
     **/
    public function test_from_string(int $quantityProvided): void
    {
        $quantity = Quantity::fromInt($quantityProvided);
        $this->assertInstanceOf(Quantity::class, $quantity);
        $this->assertSame($quantityProvided, $quantity->toInt());
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Quantity;
     **/
    public function test_negative_number_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemQuantity.notNegative');
        Quantity::fromInt(-1);
    }
}
