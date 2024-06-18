<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure;

use App\Infrastructure\FlightDurationService;
use PHPUnit\Framework\TestCase;

final class FlightDurationServiceTest extends TestCase
{
    protected FlightDurationService $flightDurationService;
    protected array $mockFlightsArray = [
        "registration" => "OO-AAA",
        "from"=> "ZAG",
        "to" => "BUD",
        "scheduled_start" => "2020-01-01T00:00:00+00:00",
        "scheduled_end" => "2020-01-01T00:50:00+00:00",
        "actual_start" => "2020-01-01T00:04:00+00:00",
        "actual_end" => "2020-01-01T01:03:00+00:00",
    ];

    protected array $mockDurationArray = [
        [
            "registration" => "OO-AAA",
            "from"=> "ZAG",
            "to" => "BUD",
            "scheduled_start" => "2020-01-01T00:00:00+00:00",
            "scheduled_end" => "2020-01-01T00:50:00+00:00",
            "actual_start" => "2020-01-01T00:04:00+00:00",
            "actual_end" => "2020-01-01T01:03:00+00:00",
            "duration" => "3540"
        ],
        [
            "registration" => "HA-AA",
            "from"=> "STN",
            "to" => "ZAG",
            "scheduled_start" => "2021-11-28T13:31:00+00:00",
            "scheduled_end" => "2021-11-28T15:31:00+00:00",
            "actual_start" => "2021-11-28T13:36:00+00:00",
            "actual_end" => "2021-11-28T15:42:00+00:00",
            "duration" => "7560"
        ],
        [
            "registration" => "HA-AAC",
            "from"=> "ZAG",
            "to" => "BUD",
            "scheduled_start" => "2021-11-26T04:49:00+00:00",
            "scheduled_end" => "2021-11-26T05:39:00+00:00",
            "actual_start" => "2021-11-26T04:50:00+00:00",
            "actual_end" => "2021-11-26T05:42:00+00:00",
            "duration" => "3120"
        ],
        [
            "registration" => "HA-AAA",
            "from"=> "MAD",
            "to" => "BER",
            "scheduled_start" => "2021-12-18T04:41:00+00:00",
            "scheduled_end" => "2021-12-18T07:21:00+00:00",
            "actual_start" => "2021-12-18T04:45:00+00:00",
            "actual_end" => "2021-12-18T07:35:00+00:00",
            "duration" => "10200"
        ],
    ];

    protected array $mockSortedDurationArray = [
        [
            "registration" => "HA-AAA",
            "from"=> "MAD",
            "to" => "BER",
            "scheduled_start" => "2021-12-18T04:41:00+00:00",
            "scheduled_end" => "2021-12-18T07:21:00+00:00",
            "actual_start" => "2021-12-18T04:45:00+00:00",
            "actual_end" => "2021-12-18T07:35:00+00:00",
            "duration" => "10200"
        ],
        [
            "registration" => "HA-AA",
            "from"=> "STN",
            "to" => "ZAG",
            "scheduled_start" => "2021-11-28T13:31:00+00:00",
            "scheduled_end" => "2021-11-28T15:31:00+00:00",
            "actual_start" => "2021-11-28T13:36:00+00:00",
            "actual_end" => "2021-11-28T15:42:00+00:00",
            "duration" => "7560"
        ],
        [
            "registration" => "OO-AAA",
            "from"=> "ZAG",
            "to" => "BUD",
            "scheduled_start" => "2020-01-01T00:00:00+00:00",
            "scheduled_end" => "2020-01-01T00:50:00+00:00",
            "actual_start" => "2020-01-01T00:04:00+00:00",
            "actual_end" => "2020-01-01T01:03:00+00:00",
            "duration" => "3540"
        ]
    ];

    public function setUp(): void
    {
        $this->flightDurationService = new FlightDurationService();
    }

    public function testCalculateAndAddDurationToFlights(): void
    {
        $flightWithDuration = $this->flightDurationService->calculateAndAddDurationToFlights($this->mockFlightsArray);

        $this->assertSame(3540, $flightWithDuration['duration']);
    }

    public function testSortFligtsByDuration(): void
    {
        $longestflight = $this->flightDurationService->sortFligtsByDuration($this->mockDurationArray);
        $this->assertSame($this->mockSortedDurationArray, $longestflight);
    }
}
