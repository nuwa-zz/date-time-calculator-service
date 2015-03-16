<?php

/**
 * SOAP service class - Zend DateTimeController will look for this class
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
require_once 'DateTimeCalculator.php';
require_once 'DateTimeCalculatorException.php';
require_once 'DateTimeCalculatorParams.php';

class DT_DateTimeCalculatorService extends DT_DateTimeCalculator {
    /**
     * <i>Note : </i>
     * Assert comment is use by the PHPUnit_SkeletonGenerator to generate the test cases
     *
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00") == 365
     * 
     * PHPDoc style return comment below is very
     * important as Zend_Soap_AutoDiscover use it to generate WSDL.
     * 
     * @return string
     */
    /* public function sayHelloWorld() {
      return "HelloWorld";
      } */

    /**
     * Return no of days between two moments and output unit is parameterized
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00") == 365 // days without timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "second") == 31536000
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "minute") == 525600
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "hour") == 8760
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "year") == 1
     * 
     * @assert ("2013-02-28 00:00:00", "2013-03-01 00:00:00") == 1 //leap year support
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Australia/Adelaide", "Asia/Colombo", null) == 365.21 // days with timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Australia/Adelaide", "Asia/Colombo", "second") == 31554000
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Australia/Adelaide", "Asia/Colombo", "minute") == 525900
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Australia/Adelaide", "Asia/Colombo", "hour") == 8765
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Australia/Adelaide", "Asia/Colombo", "year") == 1 
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Asia/Colombo", "Australia/Adelaide", null) == 364.79 // switch timezones
     * 
     * @param string $fromDateTime
     * @param string $toDateTime
     * @param string $fromTimeZone
     * @param string $toTimeZone
     * @param string $outputUnit
     * @return int
     */
    public function getNoOfDaysBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone = null, $toTimeZone = null, $outputUnit = null) {
        try {
            $dtcParams = $this->getValidatedParameters(new DT_DateTimeCalculatorParams($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit));
            $this->debug(print_r($dtcParams, true));
            $this->debug("validation - " . $dtcParams->getValidationPassed());
            if ($dtcParams->getValidationPassed()) {
                return $this->getNoOfDaysInDateInterval($dtcParams->getFromDateTime(), $dtcParams->getToDateTime(), $dtcParams->getOutputUnit());
            }
        } catch (DT_DateTimeCalculatorException $dtcEx) {
            throw $dtcEx;
        } catch (Exception $exp) {
            $this->debug("ERROR :: " . $exp->getTraceAsString());
            throw new DT_DateTimeCalculatorException('Server', $exp->getMessage());
        }
    }

    /**
     * Return no of week days between two moments and output unit is parameterized
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00") == 261 // week days without timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "second") == 22550400
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "minute") == 375840
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "hour") == 6264
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "year") == 0.71
     * 
     * @assert ("2013-02-28 00:00:00", "2013-03-01 00:00:00") == 1 //leap year support
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", null) == 261.75 // week days with timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "second") == 22615200
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "minute") == 376920
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "hour") == 6282
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "year") == 0.72
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "America/New_York", "Pacific/Auckland", null) == 260.25 // switch timezones
     * 
     * @param string $fromDateTime
     * @param string $toDateTime
     * @param string $fromTimeZone
     * @param string $toTimeZone
     * @param string $outputUnit
     * @return int
     */
    public function getNoOfWeekDaysBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone = null, $toTimeZone = null, $outputUnit = null) {
        try {
            $dtcParams = $this->getValidatedParameters(new DT_DateTimeCalculatorParams($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit));
            $this->debug(print_r($dtcParams, true));
            $this->debug("validation - " . $dtcParams->getValidationPassed());
            if ($dtcParams->getValidationPassed()) {
                return $this->getNoOfWeekdaysInDateInterval($dtcParams->getFromDateTime(), $dtcParams->getToDateTime(), $dtcParams->getOutputUnit());
            }
        } catch (DT_DateTimeCalculatorException $dtcEx) {
            throw $dtcEx;
        } catch (Exception $exp) {
            $this->debug("ERROR :: " . $exp->getTraceAsString());
            throw new DT_DateTimeCalculatorException('Server', $exp->getMessage());
        }
    }

    /**
     * Return no of complete weeks between two moments and output unit is parameterized
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00") == 52 // complete weeks without timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "second") == 31449600
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "minute") == 524160
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "hour") == 8736
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", null, null, "year") == 1
     * 
     * @assert ("2013-02-28 00:00:00", "2013-03-01 00:00:00") == 0 //leap year support
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", null) == 52 // complete weeks with timezones
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "second") == 31449600
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "minute") == 524160
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "hour") == 8736
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "Pacific/Auckland", "America/New_York", "year") == 1 
     * 
     * @assert ("2013-01-01 00:00:00", "2014-01-01 00:00:00", "America/New_York", "Pacific/Auckland", null) == 52 // switch timezones
     * 
     * @param string $fromDateTime
     * @param string $toDateTime
     * @param string $fromTimeZone
     * @param string $toTimeZone
     * @param string $outputUnit
     * @return int
     */
    public function getNoOfCompleteWeeksBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone = null, $toTimeZone = null, $outputUnit = null) {
        try {
            $dtcParams = $this->getValidatedParameters(new DT_DateTimeCalculatorParams($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit));
            $this->debug(print_r($dtcParams, true));
            $this->debug("validation - " . $dtcParams->getValidationPassed());
            if ($dtcParams->getValidationPassed()) {
                return $this->getNoOfCompleteWeeksInDateInterval($dtcParams->getFromDateTime(), $dtcParams->getToDateTime(), $dtcParams->getOutputUnit());
            }
        } catch (DT_DateTimeCalculatorException $dtcEx) {
            throw $dtcEx;
        } catch (Exception $exp) {
            $this->debug("ERROR :: " . $exp->getTraceAsString());
            throw new DT_DateTimeCalculatorException('Server', $exp->getMessage());
        }
    }

    /**
     * 
     * @param DT_DateTimeCalculatorParams $pDtcParams
     * @return DT_DateTimeCalculatorParams
     * @throws DT_DateTimeCalculatorException
     */
    protected function getValidatedParameters(DT_DateTimeCalculatorParams $pDtcParams) {
        $this->debug("inside getValidatedParameters() function");
        $this->debug(print_r($pDtcParams, true));
        $dtcParamsReturn = new DT_DateTimeCalculatorParams();

        // Don't trust request parameters..validate
        // from and to datetime specific validations
        $dateValidator = new Zend_Validate_Date('YYYY-MM-DD H:i:s'); // Or php checkdate(int $month,int $day,int $year) can be use 
        if (!$dateValidator->isValid($pDtcParams->getFromDateTime())) {
            throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the fromDateTime format/existence.');
        }
        if (!$dateValidator->isValid($pDtcParams->getToDateTime())) {
            throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the toDateTime format/existence.');
        }

        // time zone specific validations
        if (($pDtcParams->getFromTimeZone() != null && !empty($pDtcParams->getFromTimeZone())) && ($pDtcParams->getToTimeZone() != null && !empty($pDtcParams->getToTimeZone())) && ($pDtcParams->getFromTimeZone() != $pDtcParams->getToTimeZone())) {
            $this->debug("Got time zone from the request and using that");
            // validate for existance in local PHP enviroment
            if (!in_array($pDtcParams->getFromTimeZone(), DateTimeZone::listIdentifiers())) {
                throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the fromTimeZone.');
            }
            if (!in_array($pDtcParams->getToTimeZone(), DateTimeZone::listIdentifiers())) {
                throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the toTimeZone.');
            }

            $objFromDateTime = new DateTime($pDtcParams->getFromDateTime(), new DateTimeZone($pDtcParams->getFromTimeZone()));
            $objToDateTime = new DateTime($pDtcParams->getToDateTime(), new DateTimeZone($pDtcParams->getToTimeZone()));
        } else {
            $this->debug("Only from and to datetimes");
            $objFromDateTime = new DateTime($pDtcParams->getFromDateTime());
            $objToDateTime = new DateTime($pDtcParams->getToDateTime());
        }

        // fromDateTime should be in past than toDateTime..validate
        $fromTimeStamp = $objFromDateTime->getTimestamp();
        $toTimeStamp = $objToDateTime->getTimestamp();
        if ($fromTimeStamp > $toTimeStamp) {
            $this->debug("From DateTime is in the future!");
            $dtcParamsReturn->setValidationPassed(false);
            $dtcParamsReturn->setValidationMessage("From DateTime is in the future..!");

            throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the fromDateTime. It is in the future.!!');
        }

        // Output unit specific validations
        $outputUnit = "null";
        if ($pDtcParams->getOutputUnit() != null && !empty($pDtcParams->getOutputUnit()) && $pDtcParams->getOutputUnit() != 'null') {
            if (!Zend_Validate::is($pDtcParams->getOutputUnit(), 'Alpha') || !in_array($pDtcParams->getOutputUnit(), array('second', 'minute', 'hour', 'year'))) {
                throw new DT_DateTimeCalculatorException('Client', 'Invalid input - please check the outputUnit.');
            } else {
                $outputUnit = $pDtcParams->getOutputUnit();
            }
        }

        $dtcParamsReturn->setFromDateTime($objFromDateTime);
        $dtcParamsReturn->setToDateTime($objToDateTime);
        $dtcParamsReturn->setOutputUnit($outputUnit);
        $dtcParamsReturn->setValidationPassed(true);
        return $dtcParamsReturn;
    }

}
