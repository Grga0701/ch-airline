<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure;

use App\Infrastructure\OvernightStayService;
use PHPUnit\Framework\TestCase;

final class OvernightStayServiceTest extends TestCase
{
    protected OvernightStayService $overnightStayService;

    protected array $mockArray = [
        ["registration" => 'HA-AAC', "from"=>'STN', "to" => 'BUD', "scheduled_start" => '2021-11-23T02:22:00+00:00', "scheduled_end" => '2021-11-23T04:32:00+00:00', "actual_start" => '2021-11-23T02:23:00+00:00', "actual_end" => '2021-11-23T04:35:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'BUD', "to" => 'MAD', "scheduled_start" => '2021-11-23T09:35:00+00:00', "scheduled_end" => '2021-11-23T12:25:00+00:00', "actual_start" => '2021-11-23T09:36:00+00:00', "actual_end" => '2021-11-23T12:30:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'MAD', "to" => 'ZAG', "scheduled_start" => '2021-11-23T16:30:00+00:00', "scheduled_end" => '2021-11-23T19:00:00+00:00', "actual_start" => '2021-11-23T16:34:00+00:00', "actual_end" => '2021-11-23T19:07:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'ZAG', "to" => 'BER', "scheduled_start" => '2021-11-24T00:07:00+00:00', "scheduled_end" => '2021-11-24T01:37:00+00:00', "actual_start" => '2021-11-24T00:08:00+00:00', "actual_end" => '2021-11-24T01:44:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'BER', "to" => 'BUD', "scheduled_start" => '2021-11-24T08:44:00+00:00', "scheduled_end" => '2021-11-24T10:04:00+00:00', "actual_start" => '2021-11-24T08:47:00+00:00', "actual_end" => '2021-11-24T10:08:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'BUD', "to" => 'STN', "scheduled_start" => '2021-11-24T17:08:00+00:00', "scheduled_end" => '2021-11-24T19:18:00+00:00', "actual_start" => '2021-11-24T17:12:00+00:00', "actual_end" => '2021-11-24T19:30:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'STN', "to" => 'BER', "scheduled_start" => '2021-11-25T02:30:00+00:00', "scheduled_end" => '2021-11-25T04:00:00+00:00', "actual_start" => '2021-11-25T02:32:00+00:00', "actual_end" => '2021-11-25T04:05:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'BER', "to" => 'BUD', "scheduled_start" => '2021-11-25T06:05:00+00:00', "scheduled_end" => '2021-11-25T07:25:00+00:00', "actual_start" => '2021-11-25T06:06:00+00:00', "actual_end" => '2021-11-25T07:27:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'BUD', "to" => 'MAD', "scheduled_start" => '2021-11-25T08:27:00+00:00', "scheduled_end" => '2021-11-25T11:17:00+00:00', "actual_start" => '2021-11-25T08:33:00+00:00', "actual_end" => '2021-11-25T11:30:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'MAD', "to" => 'STN', "scheduled_start" => '2021-11-25T16:30:00+00:00', "scheduled_end" => '2021-11-25T18:30:00+00:00', "actual_start" => '2021-11-25T16:34:00+00:00', "actual_end" => '2021-11-25T18:39:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'STN', "to" => 'ZAG', "scheduled_start" => '2021-11-26T00:39:00+00:00', "scheduled_end" => '2021-11-26T02:39:00+00:00', "actual_start" => '2021-11-26T00:44:00+00:00', "actual_end" => '2021-11-26T02:49:00+00:00'],
        ["registration" => 'HA-AAC', "from"=>'ZAG', "to" => 'BUD', "scheduled_start" => '2021-11-26T04:49:00+00:00', "scheduled_end" => '2021-11-26T05:39:00+00:00', "actual_start" => '2021-11-26T04:50:00+00:00', "actual_end" => '2021-11-26T05:42:00+00:00']        
    ];

    public function setUp(): void
    {
        $this->overnightStayService = new OvernightStayService();
    }

    public function testcalculateOverNightStaysByDestination(): void
    {
        $overnightStaysByDestination = $this->overnightStayService->calculateOverNightStaysByDestination($this->mockArray);

        $this->assertSame(['ZAG' => 1,'STN' => 2], $overnightStaysByDestination);
    }
}
