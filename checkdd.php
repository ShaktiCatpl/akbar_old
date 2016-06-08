<?php 
require_once 'api/apicheckdd.php';
include_once("conf/fucts.php");
$useripadd = $_SERVER['REMOTE_ADDR'];
$entryTime = time();

/*$CHDRNUM	=	$_REQUEST['policynum'];
$SUBSNUM	=	$_REQUEST['subsnum'];
if($CHDRNUM!=""){ 
    extract($_POST);        
    if(isset($CHDRNUM) && $CHDRNUM != '' && isset($SUBSNUM) && $SUBSNUM !=''){*/


$xmlReq  = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:rel="http://relinterface.insurance.symbiosys.c2lbiz.com" xmlns:xsd="http://intf.insurance.symbiosys.c2lbiz.com/xsd">
   <soap:Header/>
   <soap:Body>
      <rel:doChequeDDService>
         <rel:intIO>
            <xsd:bankCd>00</xsd:bankCd>
            <xsd:insurerBankCd>00</xsd:insurerBankCd>
	    <xsd:bankBranch>00</xsd:bankBranch>
            <xsd:inwardAmount>00</xsd:inwardAmount>
            <xsd:paymentMethodCd>00</xsd:paymentMethodCd>
            <xsd:paymentSubTypeCd>00</xsd:paymentSubTypeCd>
	    <xsd:instrumentDt>00</xsd:instrumentDt>
	    <xsd:micrNum>00</xsd:micrNum>
	     <xsd:inwardNum>00</xsd:inwardNum>
	      <xsd:bankName>00</xsd:bankName>
              <xsd:paymentMode>AGENT_SUSPENSE</xsd:paymentMode>
            <xsd:proposalNum>1120000049969</xsd:proposalNum>
         </rel:intIO>
      </rel:doChequeDDService>
   </soap:Body>
</soap:Envelope>
';
$action = 'AgentFloatBpmWS'; 
$responseData  = getXMLClaimResponse($xmlReq,'test','test');
echo $responseData; 
        
        // return true;          
     	/*} else {
         echo "Please provide valid credentials!";
         return false;
     	}     
	} else {
     echo "Enable to proceed further!";
     return false;
 }*/
?>