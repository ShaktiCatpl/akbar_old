<?php 
require_once 'api/api.php';
include_once("conf/fucts.php");
$useripadd = $_SERVER['REMOTE_ADDR'];
function returndate($var){
	$res	=	explode("-",$var);
	$end	= substr($res[2],0,2);
	$returndateres = $res[0].'-'.$res[1].'-'.$end;
	return $returndateres;
}
$entryTime = time();
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    extract($_POST);        
    if(isset($paymentMode) && $paymentMode != '' && isset($proposalNum) && $proposalNum !=''){
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
                                        <xsd:paymentMode>'.$paymentMode.'</xsd:paymentMode>
                                        <xsd:proposalNum>'.$proposalNum.'</xsd:proposalNum>
                                  </rel:intIO>
                               </rel:doChequeDDService>
                            </soap:Body>
                         </soap:Envelope>';
           $action = 'doChequeDDService';          
           $responseData  = soapReq($xmlReq, $action,'chkdd');           
           	//$responseData  = getXMLClaimResponse($xmlReq,'test','agentFloat');
		  	// print_r($responseData);
			$results = var_export($responseData, true); 
		  	//file_put_contents('data/chkdd/'.time()."_request.txt",$xmlReq);
			//file_put_contents('data/chkdd/'.time()."_response.txt",$results);
           $returnResponseArr = array();                      
           if(isset($responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['policy-num']['#text']) && isset($responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['policy-num']['#text'])!=''){               
               $returnResponseArr['policy-num'] = $responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['policy-num']['#text'];
           }
           
           if(isset($responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['proposal-status-cd']['#text']) && $responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['proposal-status-cd']['#text']!=''){
               $returnResponseArr['proposal-status'] = $responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['proposal-status-cd']['#text']; 
           }  else	{
			   $returnResponseArr['proposal-status'] =	'Error';
			   $returnResponseArr['err-description'] = $responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['error-lists']['err-description']['#text']; 			   
		   }
           if(($returnResponseArr['proposal-status']=='inforceTask')||($returnResponseArr['proposal-status']=='grpAsiaReqmntResolTask')) {
			  $satartdatevar	=	$responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['policy-commencement-dt']['#text'];
			  $enddatevar	=	$responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['policy-maturity-dt']['#text'];
			   $startdate	=	returndate($satartdatevar);
			   $enddate		=	returndate($enddatevar);
			   echo @$returnResponseArr['proposal-status']."@".@$returnResponseArr['policy-num']."@".$startdate."@".$enddate;          
		   }	elseif(($returnResponseArr['proposal-status']=='paymentEntryTask') ||($returnResponseArr['proposal-status']=='cpuReqmntResolTask')) {
			    echo 'Error@'.$responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['error-lists']['err-description']['#text'];      
		   }	else {
			   	//echo 'Error@Please try after some times';
				echo 'Error@'.$responseData['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['error-lists']['err-description']['#text']; 
		   }
     } else {
         echo "Error@Please provide valid credentials!";
         return false;
     }     
}
 else {
     echo "Error@Enable to proceed further!";
     return false;
 }
?>