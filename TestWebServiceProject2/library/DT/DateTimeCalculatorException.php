<?php

/**
 * Exceptions for generating SOAP faults
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
require_once 'Zend/Exception.php';

class DT_DateTimeCalculatorException extends Zend_Exception {

    /**
     * 
     * @param type $pFaultCode // VersionMismatch, MustUnderstand, Client, Server
     * @param type $pFaultMessage // can be any human readable message
     * @throws SoapFault
     */
    function __construct($pFaultCode, $pFaultMessage) {
        throw new SoapFault($pFaultCode, $pFaultMessage);
    }

}
