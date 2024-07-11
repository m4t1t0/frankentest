<?php

declare(strict_types=1);

namespace Tests\Unit\Item\Core\Aggregate\Item\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Item\Core\Aggregate\Item\ValueObjects\Location;

final class LocationTest extends TestCase
{
    public static function providerLocation(): iterable
    {
        yield 'Main warehouse' => ['Main warehouse'];
        yield 'Store' => ['Store'];
    }

    /**
     * @test
     * @dataProvider providerLocation
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Locatiom;
     **/
    public function test_from_string(string $locationProvided): void
    {
        $description = Location::fromString($locationProvided);
        $this->assertInstanceOf(Location::class, $description);
        $this->assertSame($locationProvided, $description->toString());
    }

    /**
     * @test
     * @covers App\Item\Core\Aggregate\Item\ValueObjects\Locatiom;
     **/
    public function test_not_available_location_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('itemLocation.invalidLocation');
        Location::fromString('Bad warehouse');
    }
}
