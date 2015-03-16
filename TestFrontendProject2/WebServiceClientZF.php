<?php

//This class is not a ZF MVC based
//So, we need to load Zend libraries
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Soap_Client');

//setting options past into Zend_Soap_Client.
$options = array('location' => 'http://localhost/TestWebServiceProject2/public/index.php/datetime/soap',
    'uri' => 'http://localhost/TestWebServiceProject2/public/index.php/datetime/wsdl');

try {
    $fromDateTime = filter_var($_REQUEST['fromDateTime'], FILTER_SANITIZE_SPECIAL_CHARS);
    $toDateTime = filter_var($_REQUEST['toDateTime'], FILTER_SANITIZE_SPECIAL_CHARS);
    $fromTimeZone = filter_var($_REQUEST['fromTimeZone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $toTimeZone = filter_var($_REQUEST['toTimeZone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $outputUnit = filter_var($_REQUEST['outputUnit'], FILTER_SANITIZE_SPECIAL_CHARS);

    //Initilizing client object
    $client = new Zend_Soap_Client(null, $options);
    //calling the Web service functions.  
    $noOfDays = $client->getNoOfDaysBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit);
    $noOfWeekDays = $client->getNoOfWeekDaysBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit);
    $noOfCompleteWeeks = $client->getNoOfCompleteWeeksBetweenTwoMoments($fromDateTime, $toDateTime, $fromTimeZone, $toTimeZone, $outputUnit);

    $outputUnitView = "day";
    $outputUnitWeekView = "week";
    if ($outputUnit != null && !empty($outputUnit) && $outputUnit != 'null'){
        $outputUnitView = $outputUnit;
        $outputUnitWeekView = $outputUnit;
    }
    
    $data = array();
    $total = 0;
    $row1 = array(
        "Number of <strong>days</strong> => from ".$outputUnitView."(s)", $noOfDays
    );
    array_walk($row1, 'utf8_encode_array');
    $data[] = $row1;
    $total++;

    $row2 = array(
        "Number of <strong>weekdays</strong> => from ".$outputUnitView."(s)", $noOfWeekDays
    );
    array_walk($row2, 'utf8_encode_array');
    $data[] = $row2;
    $total++;

    $row3 = array(
        "Number of <strong>complete weeks</strong> => from ".$outputUnitWeekView."(s)", $noOfCompleteWeeks
    );
    array_walk($row3, 'utf8_encode_array');
    $data[] = $row3;
    $total++;

    echo json_encode(array("success" => true, "total" => $total, "data" => $data));
} catch (SoapFault $exp) { //catching exception and print out.
    die('ERROR: [' . $exp->faultcode . '] ' . $exp->faultstring);
} catch (Exception $exp2) {
    die('ERROR: ' . $exp2->getMessage());
}

function utf8_encode_array(&$item) {
    $item = utf8_encode($item);
    $item = trim($item);
}
?>
