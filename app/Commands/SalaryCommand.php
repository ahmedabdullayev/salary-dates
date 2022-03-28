<?php

namespace App\Commands;

use App\Repository\ToCsvRepository;
use LaravelZero\Framework\Commands\Command;
class SalaryCommand extends Command
{
    private ToCsvRepository $toCsvRepository;
    function __construct(){
        $this->toCsvRepository = new ToCsvRepository();
    }
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
    protected $description = 'Command to create list of salaries';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->toCsvRepository->generateSalaries();
    }

}
