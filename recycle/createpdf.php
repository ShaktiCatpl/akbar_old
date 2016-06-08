<?php
include_once('inc/conf.php');
include_once('api/apiObject2Array.php');
$clientNo= sanitize_data($_REQUEST['clientNo']);
if($clientNo!='') {
$data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://web.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <web:GET_PDF>
         <!--Optional:-->
         <policyNo>'.$clientNo.'</policyNo>
         <!--Optional:-->
         <ltype>POLSCHD</ltype>
      </web:GET_PDF>
   </soapenv:Body>
</soapenv:Envelope>';
function getXMLResponsePdf($data, $tagTitle, $fileName) {
    $policyURL = LEADURL;
	$fileno = time();
    //global $policyURL;
    $soapaction = "";
    $headers = array(
        "Content-Type: text/xml;charset=\"utf-8\"",
        "Content-length: " . strlen($data),
        "Authorization: Basic U3ltYmlvc3lzVXNlcjpQYXNzd29yZC0x"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $policyURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $xmlResponse1 = curl_exec($ch);
    $ch_info = curl_getinfo($ch);
    curl_close($ch);
   	file_put_contents('data/policypdf/'.$fileno."_request.xml",$data);
	file_put_contents('data/policypdf/'.$fileno."_response.xml",$xmlResponse1);
    return $xmlResponse1;

}
$fileName = $clientNo.".pdf";
$resultData = getXMLResponsePdf($data, 'GETPDF', $fileName);
$xml = object2array($resultData,'GETPDF');  
file_put_contents("data/".$fileName,base64_decode($xml['StreamData']));
$file = "data/$fileName";
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header( "Content-Disposition: attachment; filename=".basename($file));
header( "Content-Description: File Transfer");
@readfile($file); 
exit;
} else {
	echo 'Please enter policy number.';
}
?>