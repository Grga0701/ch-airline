<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure;

use App\Infrastructure\ScheduledLandingsService;
use PHPUnit\Framework\TestCase;

final class ScheduledLandingsServiceTest extends TestCase
{
    protected ScheduledLandingsService $scheduledLandingsService;

    protected array $mockLateFlightArray =   ["registration" => 'HA-AAC', "from"=>'MAD', "to" => 'ZAG', "scheduled_start" => '2021-11-23T16:30:00+00:00', "scheduled_end" => '2021-11-23T19:00:00+00:00', "actual_start" => '2021-11-23T16:34:00+00:00', "actual_end" => '2021-11-23T19:07:00+00:00'];
    protected array $mockOnTimeFlightArray = ["registration" => 'HA-AAC', "from"=>'BUD', "to" => 'MAD', "scheduled_start" => '2021-11-23T09:35:00+00:00', "scheduled_end" => '2021-11-23T12:25:00+00:00', "actual_start" => '2021-11-23T09:36:00+00:00', "actual_end" => '2021-11-23T12:30:00+00:00'];
    protected array $mockLateRegistrationsArray = ['HA-AAB','OO-AAB','D-AAC','D-AAC','HA-AAC','D-AAA','D-AAC','D-AAA','HA-AAB','OO-AAC','OO-AAC','OO-AAB','OO-AAB','HA-AAB','D-AAC','D-AAA','OO-AAA','OO-AAA','HA-AAC','D-AAB','HA-AAC','HA-AAB','HA-AAA'];

    public function setUp(): void
    {
        $this->scheduledLandingsService = new ScheduledLandingsService();
    }

    public function testGetRegistrationOfLateFlights(): void
    {
        $registrationOfALateFlight = $this->scheduledLandingsService->getRegistrationOfLateFlights($this->mockLateFlightArray);
        $registrationOfOnTimeFlight = $this->scheduledLandingsService->getRegistrationOfLateFlights($this->mockOnTimeFlightArray);

        $this->assertSame('HA-AAC', $registrationOfALateFlight);
        $this->assertSame('', $registrationOfOnTimeFlight);
    }

    public function testFindAirlineWithMostLateLandings(): void
    {
        $mockLateRegistrationsArray = $this->scheduledLandingsService->findAirlineWithMostLateLandings($this->mockLateRegistrationsArray);
 
        $this->assertSame(
            [
                'D-AAB' => 1,
                'HA-AAA' => 1,
                'OO-AAC' => 2,
                'OO-AAA' => 2,
                'OO-AAB' => 3,
                'HA-AAC' => 3,
                'D-AAA' => 3,
                'HA-AAB' => 4,
                'D-AAC' => 4
            ], 
            $mockLateRegistrationsArray);
    }
}
