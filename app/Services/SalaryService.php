<?php

namespace App\Services;

use DatePeriod;
use DateTime;
use DateInterval;
class SalaryService
{
    private HolidaysArray $holidaysArray;
    function __construct(){
        $this->holidaysArray = new HolidaysArray();
    }
    public function TestService(String $data): string
    {
        return $data." kek";
    }

    /**
     * @throws \Exception
     */
        public function searchForSalaryDays(int $year): array
        {
            $iter = 1;
            $array = array();
            $nextYear = $year + 1;
            $period = new DatePeriod(
            new DateTime($year.'-01-01'),
            new DateInterval('P1D'),
            new DateTime($nextYear.'-01-01')
            );
            foreach ($period as $key => $value) {
                $fullDate = $value->format('Y-m-d');
                $month = $value->format('F');
                $days = $value->format('t');
                $dateMinus = $fullDate;
                $timestamp = strtotime($dateMinus);
                if($iter >= $days){
                $iter = 0;
                }
                if($iter == 10){
                    while(date("l", $timestamp) == "Saturday" || date("l", $timestamp) == "Sunday"
                            || in_array(date("m-d", $timestamp), $this->holidaysArray->getHolidays())){
                        $array[$month][$dateMinus] = '';
                        $dateMinus = date('Y-m-d', strtotime($dateMinus .' -1 day'));
                        $timestamp = strtotime($dateMinus);
                    }
                    $array[$month][$dateMinus] = "Salary day";
                }else{
                    $array[$month][$dateMinus] = '';
                }

                $iter++;
            }
        return $array;
    }

    function array2csv($data, $year)
    {
        $fp = fopen($year.'.csv', 'w+');
        foreach ($data as $item=>$value){
            foreach ($value as $some=> $val){
                fputcsv($fp, array($some, $val), ",");
            }
        }
        rewind($fp);
        return stream_get_contents($fp);
    }
}
