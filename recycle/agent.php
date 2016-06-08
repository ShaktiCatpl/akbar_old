<?php 
require_once 'api/apiAgent.php';
include_once("conf/fucts.php");
$useripadd = $_SERVER['REMOTE_ADDR'];
$entryTime = time();
$CHDRNUM	=	$_REQUEST['policynum'];
$SUBSNUM	=	$_REQUEST['subsnum'];
if($CHDRNUM!=""){ 
    extract($_POST);        
    if(isset($CHDRNUM) && $CHDRNUM != '' && isset($SUBSNUM) && $SUBSNUM !=''){
            $xmlReq  = '<SOAP:Envelope xmlns:SOAP="http://schemas.xmlsoap.org/soap/envelope/">
                <SOAP:Body>
                  <AgentFloatBpmWS xmlns="http://schemas.cordys.com/default">
                    <CHDRNUM>'.$CHDRNUM.'</CHDRNUM>
                    <SUBSNUM>'.$SUBSNUM.'</SUBSNUM>
                  </AgentFloatBpmWS>
                </SOAP:Body>
              </SOAP:Envelope>';
           $action = 'AgentFloatBpmWS'; 
           $responseData  = getXMLClaimResponse($xmlReq,'test','test');
           echo $responseData; 
		   return true;          
     	} else {
         echo "Please provide valid credentials!";
         return false;
     	}     
	} else {
     echo "Enable to proceed further!";
     return false;
 }
?>