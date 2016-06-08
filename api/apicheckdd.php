<?php	
require_once 'apiObject2Array.php';
require_once 'xml2array.php';

function getXMLClaimResponse($data,$tagTitle,$fileName) {	
	$policyURL = "http://10.216.6.50/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devInst,o=religare.in";
	$soapaction="";
	$headers = array(
		"Content-Type: text/xml;charset=\"utf-8\"",
		"Content-length: ".strlen($data),
		"Authorization: Basic Q2F0YWJhdGljdXNlcjp1c2VyQDEyMzQ1"
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
	file_put_contents('data/float/'.time()."_".$fileName."_request.xml",$data);
	file_put_contents('data/float/'.time()."_".$fileName."_response.xml",$xmlResponse1);	
	//$result =  new  xml2array($xmlResponse1);
	$dataArr = object2array($xmlResponse1,$tagTitle);
	return $dataArr ;
}
?>