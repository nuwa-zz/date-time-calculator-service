<?php

/**
 * Data holder for DateTime calculation service
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
class DT_DateTimeCalculatorParams {

    // private data holder attibutes
    private $fromDateTime;
    private $toDateTime;
    private $fromTimeZone;
    private $toTimeZone;
    private $outputUnit;
    private $validationPassed;
    private $validationMessage;

    // default construtor
    function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        } else {
            $this->debug('__construct with 0 param called: ' . PHP_EOL);
            $this->fromTimeZone = null;
            $this->toTimeZone = null;
            $this->outputUnit = null;
            $this->validationPassed = false;
            $this->validationMessage = null;
        }
    }

    // programatical constructor for five parameters
    function __construct5($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit) {
        $this->debug('__construct with 5 param called: ' . PHP_EOL);
        $this->fromDateTime = $fromDateTime;
        $this->toDateTime = $toDateTime;
        $this->fromTimeZone = $fromTimeZone;
        $this->toTimeZone = $toTimeZone;
        $this->outputUnit = $outputUnit;
        $this->validationPassed = false;
        $this->validationMessage = null;
    }

    // public getters and setters
    public function getFromDateTime() {
        return $this->fromDateTime;
    }

    public function setFromDateTime($fromDateTime) {
        $this->fromDateTime = $fromDateTime;
    }

    public function getToDateTime() {
        return $this->toDateTime;
    }

    public function setToDateTime($toDateTime) {
        $this->toDateTime = $toDateTime;
    }

    public function getFromTimeZone() {
        return $this->fromTimeZone;
    }

    public function setFromTimeZone($fromTimeZone) {
        $this->fromTimeZone = $fromTimeZone;
    }

    public function getToTimeZone() {
        return $this->toTimeZone;
    }

    public function setToTimeZone($toTimeZone) {
        $this->toTimeZone = $toTimeZone;
    }

    public function getOutputUnit() {
        return $this->outputUnit;
    }

    public function setOutputUnit($outputUnit) {
        $this->outputUnit = $outputUnit;
    }

    public function getValidationPassed() {
        return $this->validationPassed;
    }

    public function setValidationPassed($validationPassed) {
        $this->validationPassed = $validationPassed;
    }

    public function getValidationMessage() {
        return $this->validationMessage;
    }

    public function setValidationMessage($validationMessage) {
        $this->validationMessage = $validationMessage;
    }

    /**
     * Only use for debuging purpose and this will log the messages and variables in runtime
     * @param type $debugMessage
     */
    private function debug($debugMessage) {
        $writer = new Zend_Log_Writer_Stream('C:\xampp\htdocs\TestWebServiceProject2\logs\debug.txt');
        $logger = new Zend_Log($writer);
        $logger->log($debugMessage, Zend_Log::DEBUG);
    }

}
