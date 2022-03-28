<?php

namespace App\Commands;

use Exception;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Services\SalaryService;
class SalaryCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'start:command';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = new SalaryService();
        $this->info("Welcome!");
        $year = $this->ask("Please provide a year (before that please close csv
                                    file with the same year if there is!)");
        if ($this->confirm('Do you wish to continue with '.$year.' year ?')) {
            try {
                if(is_numeric($year))
                $dates = $service->searchForSalaryDays($year);
                $service->array2csv($dates, $year);
            } catch (\Exception $e){
                $this->warn("Error: ". $e);
            }

        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
