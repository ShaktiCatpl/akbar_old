<?php
include_once("../conf/session.php");
include_once("../admin/fucts.php");
$fileNameRequest = time();
//$client = new SoapClient('http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl');


/*
$xmlData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.AgentRecharge.Proxy">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:ProcessDeleteDebitNote>
           <tem:ObjCRPAgentDeleteDebitNoteReq>
           <wpb:AUI>333</wpb:AUI>
           <wpb:DebitCreditType>OC</wpb:DebitCreditType>
           <wpb:Password>apitest</wpb:Password>
           <wpb:SID>CRPAGTDEBITNOTEDELETE</wpb:SID>
           <wpb:SrNo>302727</wpb:SrNo>
           <wpb:UTL>6068</wpb:UTL>
           <wpb:UserName>apitest</wpb:UserName>
         </tem:ObjCRPAgentDeleteDebitNoteReq>
      </tem:ProcessDeleteDebitNote>
   </soapenv:Body>
</soapenv:Envelope>';
*/


/*
$xmlData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.Profile.Proxy">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:ProcessAgentProfileGet>
            <tem:ObjAgentProfileGetReq>
             <wpb:AUI>333</wpb:AUI>
             <wpb:AdminCustIdentifier> </wpb:AdminCustIdentifier>
             <wpb:AdminCustType></wpb:AdminCustType>
             <wpb:FYearID>8</wpb:FYearID>
             <wpb:Password>apitest</wpb:Password>
             <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
             <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
             <wpb:UTL>6068</wpb:UTL>
             <wpb:UserName>apitest</wpb:UserName>
         </tem:ObjAgentProfileGetReq>
      </tem:ProcessAgentProfileGet>
   </soapenv:Body>
</soapenv:Envelope>';
*/


/*$xmlData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.AgentRecharge.Proxy">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:ProcessSaveDebitNote>
         <tem:ObjCRPAgentDebitNoteReq>
            <wpb:AUI>333</wpb:AUI>
            <wpb:Amount>444</wpb:Amount>
            <wpb:DebitCreditType>Master</wpb:DebitCreditType>
            <wpb:Password>apitest</wpb:Password>
            <wpb:PaxName>222</wpb:PaxName>
            <wpb:PnrNo>1212122</wpb:PnrNo>
            <wpb:Remarks>sdsds</wpb:Remarks>
           <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
            <wpb:SID>CRPAGTDEBITNOTE</wpb:SID>
            <wpb:ServiceType>IMG</wpb:ServiceType>
            <wpb:TransactionDate>12/01/2015</wpb:TransactionDate>
            <wpb:UTL>6068</wpb:UTL>
            <wpb:UserName>apitest</wpb:UserName>
         </tem:ObjCRPAgentDebitNoteReq>
      </tem:ProcessSaveDebitNote>
   </soapenv:Body>
</soapenv:Envelope>';
*/

$username = @$_SESSION['username']? $_SESSION['username'] : $_POST['username'];
$password = @$_SESSION['password']? $_SESSION['password'] : $_POST['password'];

$xmlData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.User.Proxy">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:ProcessUserLogin>
            <tem:ObjCRPUserLoginReq>
            <wpb:AUI>333</wpb:AUI>
            <wpb:Password>'.$password.'</wpb:Password>
            <wpb:SID>CRPUSERLOGIN</wpb:SID>
            <wpb:UTL>333</wpb:UTL>
            <wpb:UserName>'.$username.'</wpb:UserName>
         </tem:ObjCRPUserLoginReq>
      </tem:ProcessUserLogin>
   </soapenv:Body>
</soapenv:Envelope>';


//$xmlData = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.User.Proxy">
//   <soapenv:Header/>
//   <soapenv:Body>
//      <tem:ProcessUserLogin>
//            <tem:ObjCRPUserLoginReq>
//            <wpb:AUI>333</wpb:AUI>
//            <wpb:Password>testapi</wpb:Password>
//            <wpb:SID>CRPUSERLOGIN</wpb:SID>
//            <wpb:UTL>333</wpb:UTL>
//            <wpb:UserName>testapi</wpb:UserName>
//         </tem:ObjCRPUserLoginReq>
//      </tem:ProcessUserLogin>
//   </soapenv:Body>
//</soapenv:Envelope>';

define('WSDLURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc?wsdl');
define('ENDPOINTURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc');

$options = array(
            'trace' => true,
            'exceptions' => 1,
            'style' => SOAP_DOCUMENT,
            'use' => SOAP_LITERAL,
            'soap_version' => SOAP_1_1,
        );

$client = new SoapClient(WSDLURL, $options);
$location = ENDPOINTURL;
		
//$action = "http://tempuri.org/IWCAPI/ProcessDeleteDebitNote";

//$action ="http://tempuri.org/IWCAPI/ProcessAgentProfileGet";
//$action = "http://tempuri.org/IWCAPI/ProcessSaveDebitNote";
$action = "http://tempuri.org/IWCAPI/ProcessUserLogin";
//$action = "urn:ProcessUserLogin";

file_put_contents("../data/".$fileNameRequest."_login_request.xml", $xmlData);

$res = $client->__doRequest($xmlData, $location, $action, SOAP_1_1);

file_put_contents("../data/".$fileNameRequest."_login_response.xml", $res);
//echo '<pre>';
//print_r($res);
//exit;
if(@$_SESSION['UTL']==null)
{
    $responseArray = xml2array($res);
    $responseMessage = @$responseArray['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:TransactionDetails']['a:ResponseMessage'];
    $responseStatus = @$responseArray['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:TransactionDetails']['a:ResponseStatus'];
    $responseUTL = @$responseArray['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:UTL'];
    $loginStatus = @$responseArray['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:LoginStatus'];
    if($responseMessage == 'You have logged in successfully' && $responseStatus=='false')
    {
        $_SESSION['loginstatus']    = $loginStatus;
        $_SESSION['UTL']            = $responseUTL;
        $_SESSION['username']       = $username;
        $_SESSION['password']       = $password;
        
        echo htmlentities($res);
    }
    else
    {
        echo 'fail';
    } 
    exit;
}

?>
