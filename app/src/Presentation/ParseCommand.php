<?php

declare(strict_types=1);

namespace App\Presentation;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Infrastructure\FlightDurationService;
use App\Infrastructure\ScheduledLandingsService;
use App\Infrastructure\OvernightStayService;

#[AsCommand(name: 'parse')]
final class ParseCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rawJson = file_get_contents('var/input.jsonl'); 
        $json = json_decode($rawJson, true);

        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON decoding error: " . json_last_error_msg();
            exit;
        }
        
        $flightDurationService = new FlightDurationService();
        $scheduledLandingsService = new ScheduledLandingsService();
        $overnightStayService = new OvernightStayService();   
        
        $flightsWithDuration = [];

        foreach ($json as $flight) {
            $flightsWithDuration[] = $flightDurationService->calculateAndAddDurationToFlights($flight);
            $registrationOfALateFlight = $scheduledLandingsService->getRegistrationOfLateFlights($flight);
            if(empty($registrationOfALateFlight)){
                continue;
            };
            $registrationsOfLateFlights[] = $registrationOfALateFlight;
        }

        
        $longestFlights = $flightDurationService->sortFligtsByDuration($flightsWithDuration);
        $registrationsOfLateFlights = $scheduledLandingsService->findAirlineWithMostLateLandings($registrationsOfLateFlights);
        $airportsWithMostOvernightStays = $overnightStayService->calculateOverNightStaysByDestination($json);

        $output->writeln('Three longest flights are:');
        foreach ($longestFlights as $flight) {
            $output->writeln(sprintf(
                '%s, %s, %s, %s, %s, %s, %s',
                $flight['registration'],
                $flight['from'], 
                $flight['to'], 
                $flight['scheduled_start'], 
                $flight['scheduled_end'], 
                $flight['actual_start'], 
                $flight['actual_end']
            ));
        }

        $output->writeln(sprintf('flight with most late landings is %s with %s late landings', array_key_last($registrationsOfLateFlights), array_pop($registrationsOfLateFlights)));

        $output->writeln(sprintf('Airport with most overnight stays is %s with %s stays', array_key_last($airportsWithMostOvernightStays), array_pop($airportsWithMostOvernightStays)));
                
        return Command::SUCCESS;
    }
}