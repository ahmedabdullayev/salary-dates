<?php

namespace App\Repository;
use App\Interfaces\ToCsvInterface;
use App\Services\SalaryService;
use App\Services\ValidationService;
use LaravelZero\Framework\Commands\Command;
class ToCsvRepository extends Command implements ToCsvInterface
{
    public function generateSalaries(){
        $service = new SalaryService();
        $this->info("Welcome!");
        $year = $this->ask("Please provide a year (before that please close csv
                                    file with the same year if there is!)");
        if ($this->confirm('Do you wish to continue with '.$year.' year ?')) {
            try {
                if(ValidationService::checkYearInput($year) != null){
                    $this->warn("Warn: ". ValidationService::checkYearInput($year));
                    return;
                }
                $dates = $service->searchForSalaryDays($year);
                $service->array2csv($dates, $year);
            } catch (\Exception $e){
                $this->warn("Error: ". $e);
            }

        }
    }
}
