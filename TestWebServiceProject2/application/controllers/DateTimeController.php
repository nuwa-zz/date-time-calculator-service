<?php

/**
 * Controller class for generation soap and wsdl actions
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
class DateTimeController extends Zend_Controller_Action {

    /**
     * SOAP action named as soap.
     */
    public function soapAction() {
        // disable layouts and renderers
        $this->getHelper('viewRenderer')->setNoRender(true);

        // initialize server and set URI
        $server = new Zend_Soap_Server('http://localhost/TestWebServiceProject2/public/index.php/datetime/wsdl');

        // set SOAP service class
        $server->setClass('DT_DateTimeCalculatorService');

        // register exceptions for generating SOAP faults
        $server->registerFaultException(array('DT_DateTimeCalculatorException'));

        // handle request
        $server->handle();
    }

    /**
     * function to generate WSDL.
     */
    public function wsdlAction() {
        // You can add Zend_Auth code here if you do not want
        // everybody can access the WSDL file.
        // disable layouts and renderers
        $this->getHelper('viewRenderer')->setNoRender(true);

        // initilizing zend autodiscover object.
        $wsdl = new Zend_Soap_AutoDiscover();

        // register SOAP service class
        $wsdl->setClass('DT_DateTimeCalculatorService');

        // set a SOAP action URI. here, SOAP action is 'soap' as defined above.
        $wsdl->setUri('http://localhost/TestWebServiceProject2/public/index.php/datetime/soap');

        // handle request
        $wsdl->handle();
    }

}
