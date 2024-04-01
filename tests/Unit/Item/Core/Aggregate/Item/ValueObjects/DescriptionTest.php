<?php

declare(strict_types=1);

namespace Tests\Unit\Item\Core\Aggregate\Item\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Item\Core\Aggregate\Item\ValueObjects\Description;

final class DescriptionTest extends TestCase
{
    public static function providerDescription(): iterable
    {
        yield 'Monitor' => ['Un precioso monitor de 32 pulgadas'];
        yield 'Hard Disk' => ['Un disco duro externo de 1TB muy rápido'];
    }

    /**
     * @test
     * @dataProvider providerDescription
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Description;
     **/
    public function test_from_string(string $descriptionProvided): void
    {
        $description = Description::fromString($descriptionProvided);
        $this->assertInstanceOf(Description::class, $description);
        $this->assertSame($descriptionProvided, $description->toString());
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Description;
     **/
    public function test_empty_description_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemDescription.notEmpty');
        Description::fromString('');
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Description;
     **/
    public function test_long_description_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemDescription.invalidLength');
        Description::fromString(str_repeat('a', 129));
    }
}
