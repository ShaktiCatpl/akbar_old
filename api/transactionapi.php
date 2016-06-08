<?php
include_once("../conf/session.php");
include_once("../admin/fucts.php");

define('WSDLURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc?wsdl');
define('ENDPOINTURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc');

$username = @$_SESSION['username'];
$password = @$_SESSION['password'];
$utl      = @$_SESSION['UTL'];
$premium  = @$_POST['premiumno'];
$proposalNum = @$_POST['proposalno'];

/**
 * Request Soap Client
 * @param sml $xmlData
 * @param string $action
 */
function requestSoapClient($actionName, $xmlData)
{
    $action = "http://tempuri.org/IWCAPI/".$actionName;
    $fileNameRequest = time();
    $options = array(
            'trace' => true,
            'exceptions' => 1,
            'style' => SOAP_DOCUMENT,
            'use' => SOAP_LITERAL,
            'soap_version' => SOAP_1_1,
        );

    $client = new SoapClient(WSDLURL, $options);

    $location = ENDPOINTURL;	
    
    $resDetail = $client->__doRequest($xmlData, $location, $action, SOAP_1_1);
    //Uncomment below to generate log file of xml request and response.
    //Create log file of Request & Response xml.
    file_put_contents("../data/".$fileNameRequest."_".$actionName."_request.xml", $xmlData);    
    file_put_contents("../data/".$fileNameRequest."_".$actionName."_response.xml", $resDetail);       
    return $resDetail;    
}

/**
 * Get Api Response.
 * @param string $action
 * @param string $key
 * @param xml $responseXml
 * @return string
 */
function getApiResponse($action, $key, $resonseXml)
{
    $actionResponse = $action.'Response'; 
    $actionResult = $action.'Result';
    $responseArray = xml2array($resonseXml);   
    return @$responseArray['s:Envelope']['s:Body'][$actionResponse][$actionResult][$key];
}

/**
 * Save Transaction Remark. 
 * @param string $transdetail
 */
function saveTransactionRemark($transRemark)
{
    global $sdbc;
    $createdOn = strtotime(date('Y-m-d H:i:s', time()));
    $sql = "UPDATE ATAGENTTRANSACTION SET TRANSREMARK='". $transRemark ."', UPDATEDON=". $createdOn ." WHERE AGENTUTL=". $_SESSION['UTL'] ." AND STATUS =1"; 
    
    $stdid = @oci_parse($sdbc, $sql);	
    oci_execute($stdid)  or die(print_r(oci_error($stdid)));
}

function requestSoapClient_1_2($actionName, $xmlData)
{
    $location = 'https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices.RelSymbiosysServicesHttpSoap12Endpoint/';
    $version = SOAP_1_2;
    

    $opts = array(
                    'trace' => true,
                    'exceptions' => 1,
                    'style' => SOAP_DOCUMENT,
                    'use' => SOAP_LITERAL ,
                    'soap_version' => SOAP_1_2 
                  );
    
    $action = $actionName;
    $objSoapClient = new SoapClient('https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices?wsdl',$opts);
    
    $response = $objSoapClient->__doRequest($xmlData, $location, $action, $version);
    
    $fileNameRequest = time();
    //Create log file of Request & Response xml.
    file_put_contents("../data/".$fileNameRequest."_".$actionName."_request.xml", $xmlData);    
    file_put_contents("../data/".$fileNameRequest."_".$actionName."_response.xml", $response); 
    return $response;        
}

//Get Agent Balance.
$action1 = 'ProcessAgentProfileGet';

$xmlData1 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.Profile.Proxy">
           <soapenv:Header/>
           <soapenv:Body>
              <tem:ProcessAgentProfileGet>
                 <tem:ObjAgentProfileGetReq>
                    <wpb:AUI>333</wpb:AUI>
                    <wpb:AdminCustIdentifier> </wpb:AdminCustIdentifier>
                    <wpb:AdminCustType> </wpb:AdminCustType>
                    <wpb:FYearID>9</wpb:FYearID>
                    <wpb:Password>'.$password.'</wpb:Password>
                    <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
                    <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
                    <wpb:UTL>'.$utl.'</wpb:UTL>
                    <wpb:UserName>'.$username.'</wpb:UserName>
                 </tem:ObjAgentProfileGetReq>
              </tem:ProcessAgentProfileGet>
           </soapenv:Body>
        </soapenv:Envelope>';
if(@$_SESSION['loginstatus'])
{
    $resDetail1 = requestSoapClient($action1, $xmlData1);
    $remarkResponse = $resDetail1;
    $agentBalance = getApiResponse($action1, 'a:CurrentBalance', $resDetail1);
    
    //Deduct premium from agent balance if agent balance is sufficient.
    if(is_float($agentBalance) || is_numeric($agentBalance))
    {
        if($premium <= $agentBalance)
        {
           $action2 = 'ProcessSaveDebitNote';

           $xmlData2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.AgentRecharge.Proxy">
                           <soapenv:Header/>
                           <soapenv:Body>
                              <tem:ProcessSaveDebitNote>
                                 <tem:ObjCRPAgentDebitNoteReq>
                                    <wpb:AUI>333</wpb:AUI>
                                    <wpb:Amount>'.$premium.'</wpb:Amount>
                                    <wpb:DebitCreditType>OD</wpb:DebitCreditType>
                                    <wpb:Password>'.$password.'</wpb:Password>
                                    <wpb:PaxName>222</wpb:PaxName>
                                    <wpb:PnrNo>1212122</wpb:PnrNo>
                                    <wpb:Remarks>Catabatic Testing</wpb:Remarks>
                                    <wpb:RequestedFrom>IMGC</wpb:RequestedFrom>
                                    <wpb:SID>CRPAGTDEBITNOTE</wpb:SID>
                                    <wpb:ServiceType>IMG</wpb:ServiceType>
                                    <wpb:TransactionDate>'.  date('d-m-Y').'</wpb:TransactionDate>
                                    <wpb:UTL>'.$utl.'</wpb:UTL>
                                    <wpb:UserName>'.$username.'</wpb:UserName>
                                 </tem:ObjCRPAgentDebitNoteReq>
                              </tem:ProcessSaveDebitNote>
                           </soapenv:Body>
                        </soapenv:Envelope>';

            $resDetail2 = requestSoapClient($action2, $xmlData2); 
            $remarkResponse = $resDetail2;
            $responseArray = xml2array($resDetail2);

            $deductionResponse = getApiResponse($action2, 'a:TransDetails', $resDetail2);
            $deductionMsg = $deductionResponse['a:ResponseMessage'];
            $deductionStatus = $deductionResponse['a:ResponseStatus'];
            
            if($deductionMsg == 'Save Success' && $deductionStatus=='false' && 1!=1)
            {
                $paymentMode = 'AGENT_SUSPENSE';
                //$proposalNum = '4120000092812';//'4120000092807';//'2220000064294';

                $action4 = 'doChequeDDService';
                $xmlData4  = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:rel="http://relinterface.insurance.symbiosys.c2lbiz.com" xmlns:xsd="http://intf.insurance.symbiosys.c2lbiz.com/xsd">
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

                $resDetail4 = requestSoapClient_1_2($action4, $xmlData4);
                $remarkResponse = $resDetail4;
                $detail = xml2array($resDetail4);
                $checkDDResponse = $remarkResponse['soapenv:Envelope']['soapenv:Body']['ns:doChequeDDServiceResponse']['ns:return']['cheque-dDReq-res-iO']['error-lists']['err-description'];
                
                if($checkDDResponse=='Error invoking the interface. Please try again.')
                {
                    $ajaxMsg = 'checkDDDone';
                }
                else
                {
                    $ajaxMsg = 'checkDDError';
                }
            }
            else 
            {
                $serialNo = getApiResponse($action2, 'a:SrNo', $resDetail2);
                $action5 = 'ProcessDeleteDebitNote';

                $xmlData5 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.AgentRecharge.Proxy">
                                <soapenv:Header/>
                                <soapenv:Body>
                                   <tem:ProcessDeleteDebitNote>
                                      <tem:ObjCRPAgentDeleteDebitNoteReq>
                                         <wpb:AUI>333</wpb:AUI>
                                         <wpb:DebitCreditType>OC</wpb:DebitCreditType>
                                         <wpb:Password>'.$password.'</wpb:Password>
                                         <wpb:SID>CRPAGTDEBITNOTEDELETE</wpb:SID>
                                         <wpb:SrNo>'.$serialNo.'</wpb:SrNo>
                                         <wpb:UTL>'.$utl.'</wpb:UTL>
                                         <wpb:UserName>'.$username.'</wpb:UserName>
                                      </tem:ObjCRPAgentDeleteDebitNoteReq>
                                   </tem:ProcessDeleteDebitNote>
                                </soapenv:Body>
                             </soapenv:Envelope>';

                 $resDetail5 = requestSoapClient($action5, $xmlData5);
                 $remarkResponse = $resDetail5;

                 $additionResponse = getApiResponse($action5, 'a:TransDetails', $resDetail5);
                 $additionMsg = $additionResponse['a:ResponseMessage'];
                 $additionStatus = $additionResponse['a:ResponseStatus'];

                 if($additionMsg == 'Delete Failed' && $additionStatus=='true')
                 {
                     $ajaxMsg = 'agentadditiondone';
                 }
                 else
                 {
                     $ajaxMsg = 'agentaddtionfail';                         
                 }           
            }
        }
        else
        {
            $ajaxMsg = 'Agent balance is insufficient';
        }
    }
    else
    {
        $ajaxMsg = 'balanceerror';        
    }
}
else
{
    $ajaxMsg = 'loginerror'; 
}
echo $ajaxMsg;
saveTransactionRemark($ajaxMsg.'::'.$remarkResponse);
exit;

?>
