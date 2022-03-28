<?php

namespace App\Services;

class ValidationService
{
    public function checkYearInput($input){
        if(!is_numeric($input)){
            $this->warn("Please provide a year(only numbers)");
        }elseif ($input < 1900 || $input > 3000){
            $this->warn("Please provide a year in range of 1900 - 3000");
        }
    }
}
