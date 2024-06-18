<?php

declare(strict_types=1);

namespace App\Infrastructure;

final class ScheduledLandingsService
{
    public array $registrationsOfLateFlights = [];

    public function getRegistrationOfLateFlights(array $flight): string 
    {
        if((strtotime($flight['actual_end'])-strtotime($flight['scheduled_end'])) > (5 * 60)){
            return $flight['registration'];
        }
        return '';
    }

    public function findAirlineWithMostLateLandings(array $registrationsOfLateFlights): array
    {
        $countedValuesOfFlights = array_count_values($registrationsOfLateFlights);
        asort($countedValuesOfFlights);
        return $countedValuesOfFlights;
    }
}