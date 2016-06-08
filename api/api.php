<?php	
$policyURL="http://10.216.7.215/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=defaultInst,o=religare.in";
include('apiObject2Array.php');
require_once 'xml2array.php';

$location = 'https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices.RelSymbiosysServicesHttpSoap12Endpoint/';
$version = SOAP_1_2;

function soapReq($xmlReq, $action,$dir=NULL){
    global $location, $version;
    $opts = array(
//    'trace' => true,
//    'exceptions' => 1,
//    'style' => SOAP_DOCUMENT,
//    'use' => SOAP_LITERAL ,
//    'soap_version' => SOAP_1_2 
  );
    
    $objSoapClient = new SoapClient('https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices?wsdl',$opts);
    
    $response = $objSoapClient->__doRequest($xmlReq, $location, $action, $version);
    
    $fileName = $action.'_log_'.time();
	makeLog($xmlReq,$fileName,$response,$dir); 
    $result =  new  xml2array($response);    
    return $result->getResult();
    
//    $sop = simplexml_load_string($response);     
//    $str = (string)$sop->soapBody->GetAuthTokenResponse->GetAuthTokenResult;
//    $str = html_entity_decode($str);    
//    return $str;
    
}
function getGroupPDFURL($query){
		foreach($query as $key=>$value)	{
			$$key=$value;
		}
		$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://web.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <web:GET_PDF>
         <!--Optional:-->
         <policyNo>'.@$policyNo.'</policyNo>
         <!--Optional:-->
         <ltype>GPOLSCHD</ltype>
      </web:GET_PDF>
   </soapenv:Body>
</soapenv:Envelope>';
			
		$fileName='GET_PDF_'.@$policyNo.'_'.time();
		$dataArr = getXMLResponse($xml_data,'GETPDF',$fileName);
		return $dataArr;
}
function getRetailPDFURL($query){
		foreach($query as $key=>$value)	{
			$$key=$value;
		}

 $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://web.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <web:GET_PDF>
         <!--Optional:-->
         <policyNo>'.@$policyNo.'</policyNo>
         <!--Optional:-->
         <ltype>POLSCHD</ltype>
      </web:GET_PDF>
   </soapenv:Body>
</soapenv:Envelope>';
			
		$fileName='GET_PDF_'.@$policyNo.'_'.time();
		$dataArr = getXMLResponse($xml_data,'GETPDF',$fileName);
		return $dataArr;
}

function getCDStatement($query){
		foreach($query as $key=>$value)	{
			$$key=$value;
		}
$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://web.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <web:GET_PDF>
         <!--Optional:-->
         <policyNo>'.@$policyNo.'</policyNo>
         <!--Optional:-->
         <ltype>GENDORSM</ltype>
      </web:GET_PDF>
   </soapenv:Body>
</soapenv:Envelope>';
			
		$fileName='CD_'.@$policyNo.'_'.time();
		$dataArr = getXMLResponse($xml_data,'GETPDF',$fileName);
		return $dataArr;
}
function getLTRStatement($query){
		foreach($query as $key=>$value)	{
			$$key=$value;
		}
		$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://web.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <web:GET_PDF>
         <!--Optional:-->
         <policyNo>'.@$policyNo.'</policyNo>
         <!--Optional:-->
         <ltype>GENDORSM</ltype>
      </web:GET_PDF>
   </soapenv:Body>
</soapenv:Envelope>';
			
    $fileName='ENDORSEMENT_'.@$policyNo.'_'.time();
    $dataArr = getXMLResponse($xml_data,'GETPDF',$fileName);
    return $dataArr;
    
}
function getXMLResponse($data,$tagTitle,$fileName){		
	//$policyURL="http://203.160.138.164/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devinst,o=religare.in";
	global $policyURL;
	$soapaction="";
    $headers = array("Content-Type: text/xml;charset=\"utf-8\"",
                    "Content-length: ".strlen($data),"Authorization: Basic Q2F0YWJhdGljdXNlcjp1c2VyQDEyMzQ1"
            );
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, @$policyURL );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt ( $ch, CURLOPT_VERBOSE, true );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 60);
	$xmlResponse1 = curl_exec ( $ch );
	$ch_info=curl_getinfo($ch);
	curl_close($ch);
	file_put_contents('data/'.$fileName."_request.xml",$data);
	file_put_contents('data/'.$fileName."_response.xml",$xmlResponse1);
	$dataArr = object2array($xmlResponse1,$tagTitle);
	return $dataArr ;
}
function makeLog($xmlReq,$fileName,$response,$dir=null)
{
    if(isset($dir) && $dir!= null){
        file_put_contents('data/chkdd/'.time()."_".$fileName."_request.xml",$xmlReq);
        file_put_contents('data/chkdd/'.time()."_".$fileName."_response.xml",$response);        
    } else {
        
        file_put_contents('data/'.time()."_".$fileName."_request.xml",$xmlReq);
        file_put_contents('data/'.time()."_".$fileName."_response.xml",$response);
    }
    
    
    
   // return object2array($response,$tagTitle);    
}

?>