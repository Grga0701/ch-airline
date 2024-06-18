<?php

declare(strict_types=1);

namespace App\Infrastructure;

use DateTime;

final class OvernightStayService
{
    public array $airportsWithMostOvernightStays = [];

    public function calculateOverNightStaysByDestination(array $flights): array
    {
        $sortedFlightsByRegistration = [];
        foreach ($flights as $flight) {
            $sortedFlightsByRegistration[$flight['registration']][] = $flight;
        }

        foreach ($sortedFlightsByRegistration as $registration => $flights) {
            $previousFlight = [];
            foreach ($flights as $flight) {
                if(!empty($previousFlight)){
                    $this->checkIfFlightStayOvverNight($previousFlight, $flight);
                }
                $previousFlight = $flight;
            }
        }

        $airports = $this->airportsWithMostOvernightStays;
        asort($airports);
        return $airports;
    }

    protected function checkIfFlightStayOvverNight(array $previousFlight, array $flight): void
    {
        $arivalTime = new DateTime($previousFlight['actual_end']);
        $leavTime = new DateTime($flight['scheduled_start']);

        $arivalTime->setTime(0, 0, 0);
        $leavTime->setTime(0, 0, 0);

        $arivalTime->format('Y-m-d');
        $arivalTime->modify('+1 day');
        $leavTime->format('Y-m-d');

        if($arivalTime == $leavTime && $previousFlight['to'] === $flight['from'] ){
            if(!isset($this->airportsWithMostOvernightStays[$previousFlight['to']])){
                $this->airportsWithMostOvernightStays[$previousFlight['to']] = 0;
            }
            $this->airportsWithMostOvernightStays[$previousFlight['to']] ++;
        }
    }
}