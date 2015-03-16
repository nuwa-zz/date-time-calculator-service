<?php

/**
 * DateTimeCalculator class is used to calculate the duration between two moments
 * DO NOT USE THIS CLASS DIRECTLY
 *
 * @author Nuwan
 * @version 1.0
 * Date 2014-05-11
 *
 * ******************************************************************************
 * Change log
 *
 * Date / Time      Version     Issue ID        User        Description
 * 20140511_2010    1.0         -               ndesilva    Defined the code
 * ******************************************************************************
 */
abstract class DT_DateTimeCalculator {

    function __construct() {
        
    }

    function __destruct() {
        
    }

    /**
     * getNoOfWeekdaysInDateInterval
     * 
     * @param DateTime $fromDateTime
     * @param DateTime $toDateTime
     * @param $outputUnit
     * @return int
     */
    protected function getNoOfDaysInDateInterval(DateTime $pFromDateTime, DateTime $pToDateTime, $pOutputUnit = null) {
        $this->debug("Invoke getNoOfDaysInDateInterval function.");
        $dateInterval = $pToDateTime->diff($pFromDateTime);
        $this->debug("diff object./n" . print_r($dateInterval, true));

        $seconds = $dateInterval->days * 24 * 60 * 60; // total no of days
        $seconds += $dateInterval->h * 60 * 60; // hours
        $seconds += $dateInterval->i * 60; // minutes
        $seconds += $dateInterval->s; // seconds
        return $this->getResultFromOutputUnit($seconds, $pOutputUnit);
    }

    /**
     * getNoOfWeekdaysInDateInterval
     * 
     * @param DateTime $pFromDateTime
     * @param DateTime $pToDateTime
     * @param $pOutputUnit
     * @return int
     */
    protected function getNoOfWeekdaysInDateInterval(DateTime $pFromDateTime, DateTime $pToDateTime, $pOutputUnit = null) {
        $this->debug("Invoke getNoOfWeekdaysInDateInterval function.");
        $fromTimeStamp = $pFromDateTime->getTimestamp();
        $toTimeStamp = $pToDateTime->getTimestamp();

        $holidays = 0;
        for ($day = $fromTimeStamp; $day < $toTimeStamp; $day += 86400) { //(24 * 60 * 60) = 86400
            $whatDayOfTheWeek = date('N', $day); // 1 (for Monday) through 7 (for Sunday)
            if ($whatDayOfTheWeek > 5) { // 6 and 7 are weekend days(Sat n Sun)---holidays
                $holidays++;
            }
        }
        $weekDaysInSeconds = $toTimeStamp - $fromTimeStamp - ($holidays * 24 * 60 * 60); //(1 day = 24*60*60 seconds)
        return $this->getResultFromOutputUnit($weekDaysInSeconds, $pOutputUnit);
    }

    /**
     * getNoOfCompleteWeeksInDateInterval
     * 
     * @param DateTime $pFromDateTime
     * @param DateTime $pToDateTime
     * @param $pOutputUnit
     * @return int
     */
    protected function getNoOfCompleteWeeksInDateInterval(DateTime $pFromDateTime, DateTime $pToDateTime, $pOutputUnit = null) {
        $noOfDays = $this->getNoOfDaysInDateInterval($pFromDateTime, $pToDateTime);
        $noOfCompleteWeeks = floor($noOfDays / 7);
        if ($pOutputUnit == "null")
            return $noOfCompleteWeeks;
        else {
            $noOfCompleteWeeksInSeconds = $noOfCompleteWeeks * 7 * 24 * 60 * 60;
            return $this->getResultFromOutputUnit($noOfCompleteWeeksInSeconds, $pOutputUnit);
        }
    }

    /**
     * 
     * @param int $pNoOfSeconds
     * @param type $pOutputUnit
     * @return type
     */
    private function getResultFromOutputUnit($pNoOfSeconds, $pOutputUnit) {
        $returnDateDiff = null;
        $this->debug("Got a output unit - " . $pOutputUnit);
        switch ($pOutputUnit) {
            case "second":
                $returnDateDiff = $pNoOfSeconds;
                break;

            case "minute":
                $returnDateDiff = $pNoOfSeconds / 60;
                break;

            case "hour":
                $returnDateDiff = $pNoOfSeconds / ( 60 * 60 );
                break;

            case "day":
                $returnDateDiff = $pNoOfSeconds / ( 60 * 60 * 24);
                break;

            case "month":
                $returnDateDiff = $pNoOfSeconds / ( 60 * 60 * 24 * 30);
                break;

            case "year":
                $returnDateDiff = $pNoOfSeconds / ( 60 * 60 * 24 * 365.25);
                break;

            default:
                $returnDateDiff = $pNoOfSeconds / ( 60 * 60 * 24); // Default is the "day"
                break;
        }

        return number_format((float) $returnDateDiff, 2, '.', '');  // Outputs like -> 105.00 
    }

    /**
     * Only use for debuging purpose and this will log the messages and variables in runtime
     * @param type $pDebugMessage
     */
    protected function debug($pDebugMessage) {
        $writer = new Zend_Log_Writer_Stream('C:\xampp\htdocs\TestWebServiceProject2\logs\debug.txt');
        $logger = new Zend_Log($writer);
        $logger->log($pDebugMessage, Zend_Log::DEBUG);
    }

    /**
     * Any class that extends DT_DateTimeCalculator and is not abstract must implement getValidatedParameters
     * (To force developers to validate request attributes and use it)
     * 
     * @param DT_DateTimeCalculatorParams $pDtcParams
     * @return DT_DateTimeCalculatorParams
     * @throws DT_DateTimeCalculatorException
     */
    abstract protected function getValidatedParameters(DT_DateTimeCalculatorParams $pDtcParams);
}
