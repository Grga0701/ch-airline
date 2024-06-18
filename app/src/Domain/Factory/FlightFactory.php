<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Airline;
use App\Domain\Airplane;
use App\Domain\Flight;

final class FlightFactory
{
    public static function Create(Object $json):Flight
    {
        return new Flight(
            new Airplane ($json->registration, new Airline(Airline::AIRLINE_NAME)),
            $json->from,
            $json->to,
            new \DateTimeImmutable($json->scheduled_start),
            new \DateTimeImmutable($json->scheduled_end),
            new \DateTimeImmutable($json->actual_start),
            new \DateTimeImmutable($json->actual_end),
        );
    }

}