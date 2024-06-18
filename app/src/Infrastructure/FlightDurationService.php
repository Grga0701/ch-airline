<?php

declare(strict_types=1);

namespace App\Infrastructure;

final class FlightDurationService
{
    public array $longestFlights = [];
    public function calculateAndAddDurationToFlights(array $flight): array
    {
        $flight['duration'] = strtotime($flight['actual_end'])-strtotime($flight['actual_start']);
        return $flight;
    }

    public function sortFligtsByDuration(array $longestFlights): array
    {
        usort($longestFlights, function ($a, $b) {
            return $b['duration'] <=> $a['duration'];
        });

        return array_slice($longestFlights, 0, 3);
    }

}