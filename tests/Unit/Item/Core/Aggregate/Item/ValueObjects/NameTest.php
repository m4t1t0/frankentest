<?php

declare(strict_types=1);

namespace Tests\Unit\Item\Core\Aggregate\Item\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Item\Core\Aggregate\Item\ValueObjects\Name;

final class NameTest extends TestCase
{
    public static function providerName(): iterable
    {
        yield 'Monitor' => ['Monitor'];
        yield 'Hard Disk' => ['Hard Disk'];
    }

    /**
     * @test
     * @dataProvider providerName
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Name;
     **/
    public function test_from_string(string $nameProvided): void
    {
        $name = Name::fromString($nameProvided);
        $this->assertInstanceOf(Name::class, $name);
        $this->assertSame($nameProvided, $name->toString());
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Name;
     **/
    public function test_empty_name_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemName.notEmpty');
        Name::fromString('');
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Name;
     **/
    public function test_long_name_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemName.invalidLength');
        Name::fromString(str_repeat('a', 65));
    }
}
