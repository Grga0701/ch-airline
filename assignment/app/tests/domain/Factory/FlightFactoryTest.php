<?php

declare(strict_types=1);

namespace App\Tests\Domain\Factory;

use App\Domain\Factory\FlightFactory;
use PHPUnit\Framework\TestCase;

final class FlightFactoryTest extends TestCase
{
    public function testFlightFactoryReturnsAFlightObject(): void
    {
        $json = file_get_contents('var/flight.json'); 
        $json = json_decode($json);
        $test = FlightFactory::create($json);
        $this->assertIsObject(FlightFactory::create($json));
        $this->assertSame('STN', $test->getFrom());
        $this->assertSame('ch-aviation', $test->getAirplane()->getAirline()->getName());
    }
}
