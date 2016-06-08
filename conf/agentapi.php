<?php
include_once("../conf/session.php");
include_once("../admin/fucts.php");

define('WSDLURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc?wsdl');
define('ENDPOINTURL', 'http://test.benzyinfotech.com:8013/WCAPI.svc');

$fileNameRequest = time();

$username = @$_SESSION['username']? $_SESSION['username'] : @$_POST['username'];
$password = @$_SESSION['password']? base64_encode($_SESSION['password']) : @$_POST['password'];

$options = array(
            'trace' => true,
            'exceptions' => 1,
            'style' => SOAP_DOCUMENT,
            'use' => SOAP_LITERAL,
            'soap_version' => SOAP_1_1,
        );

$client = new SoapClient(WSDLURL, $options);

$location = ENDPOINTURL;
		
if(!@$_SESSION['loginstatus'])
{   
$action1 = "http://tempuri.org/IWCAPI/ProcessUserLogin";
$xmlData1 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.User.Proxy">
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

//file_put_contents("..//data/".$fileNameRequest."_login_request.xml", $xmlData);
$resLogin = $client->__doRequest($xmlData1, $location, $action1, SOAP_1_1);
//file_put_contents("../data/".$fileNameRequest."_login_response.xml", $res);

    $responseArray1 = xml2array($resLogin);
    $responseMessage = @$responseArray1['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:TransactionDetails']['a:ResponseMessage'];
    $responseStatus = @$responseArray1['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:TransactionDetails']['a:ResponseStatus'];
    $responseUTL = @$responseArray1['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:UTL'];
    $loginStatus = @$responseArray1['s:Envelope']['s:Body']['ProcessUserLoginResponse']['ProcessUserLoginResult']['a:LoginStatus'];
    if($responseMessage == 'You have logged in successfully' && $responseStatus=='false')
    {
        $_SESSION['loginstatus']    = $loginStatus;
        $_SESSION['UTL']            = $responseUTL;
        $_SESSION['username']       = $username;
        $_SESSION['password']       = $password;//base64_decode($password);
        
        $action2 = "http://tempuri.org/IWCAPI/ProcessAgentProfileGet";
        $xmlData2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.Profile.Proxy">
                   <soapenv:Header/>
                   <soapenv:Body>
                      <tem:ProcessAgentProfileGet>
                         <tem:ObjAgentProfileGetReq>
                            <wpb:AUI>333</wpb:AUI>
                            <wpb:AdminCustIdentifier> </wpb:AdminCustIdentifier>
                            <wpb:AdminCustType> </wpb:AdminCustType>
                            <wpb:FYearID>8</wpb:FYearID>
                            <wpb:Password>'.$password.'</wpb:Password>
                            <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
                            <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
                            <wpb:UTL>'.$responseUTL.'</wpb:UTL>
                            <wpb:UserName>'.$username.'</wpb:UserName>
                         </tem:ObjAgentProfileGetReq>
                      </tem:ProcessAgentProfileGet>
                   </soapenv:Body>
                </soapenv:Envelope>';
        //file_put_contents("..//data/".$fileNameRequest."_login_request.xml", $xmlData);
        $resDetail = $client->__doRequest($xmlData2, $location, $action2, SOAP_1_1);
        //file_put_contents("../data/".$fileNameRequest."_login_response.xml", $res);
        
        $responseArray2 = xml2array($resDetail);
        $agentBalance = @$responseArray2['s:Envelope']['s:Body']['ProcessAgentProfileGetResponse']['ProcessAgentProfileGetResult']['a:CurrentBalance'];

        if($agentBalance)
        {
            $_SESSION["agentbalance"] = $agentBalance;      
             $mysql_server	=	"localhost";
            $mysql_uesrname	=	"root";
            $mysql_password     =        "";
            $mysql_dbname       = "travel";
            
            mysql_connect($mysql_server,$mysql_uesrname,$mysql_password) or die("cannot connect to database");
            mysql_select_db($mysql_dbname) or die("cannot select database");
            
            $createdOn = strtotime(date('Y-m-d H:i:s', time()));
            $insquery = "INSERT INTO agentdetail (username, agentUTL, agentbalance, createdon, updatedon) values
                    ('". $username ."',". $responseUTL .",'".$agentBalance. "','". $createdOn."','" .$createdOn."')";
            mysql_query($insquery) or mysql_error();
        }
        $data=array(
            'spanwelcomeagent'=>'<span>Welcome, <strong>'.$username.'</strong></span><a href="signout.php" class="logout">Log Out</a><br>',
            'spanagentbalance'=>'<span id="carefloatresult" style="width:50px; padding-right:5px;">: Rs '.@$agentBalance.'</span><a id="carefloat" href="#" onclick="getagentfloat("care", 1)">'
        );
       echo json_encode($data);
       // echo $agentBalance. ':;<span>Welcome, <strong>'.$username.'</strong></span><a href="signout.php" class="logout">Log Out</a><br>'.
        //':;Group Care Balance&nbsp;&nbsp;'.$agentBalance.'<span id="carefloatresult" style="width:50px; padding-right:5px;"></span><a id="carefloat" href="#" onclick="getagentfloat("care", 1)">';
        
        
    }
    else
    {
        echo '';
    }
}
else
{
    $password = $_SESSION['password'];
    $responseUTL = $_SESSION['UTL'];
    
    $action2 = "http://tempuri.org/IWCAPI/ProcessAgentProfileGet";
    $xmlData2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.Profile.Proxy">
               <soapenv:Header/>
               <soapenv:Body>
                  <tem:ProcessAgentProfileGet>
                     <tem:ObjAgentProfileGetReq>
                        <wpb:AUI>333</wpb:AUI>
                        <wpb:AdminCustIdentifier> </wpb:AdminCustIdentifier>
                        <wpb:AdminCustType> </wpb:AdminCustType>
                        <wpb:FYearID>8</wpb:FYearID>
                        <wpb:Password>'.$password.'</wpb:Password>
                        <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
                        <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
                        <wpb:UTL>'.$responseUTL.'</wpb:UTL>
                        <wpb:UserName>'.$username.'</wpb:UserName>
                     </tem:ObjAgentProfileGetReq>
                  </tem:ProcessAgentProfileGet>
               </soapenv:Body>
            </soapenv:Envelope>';
    //file_put_contents("..//data/".$fileNameRequest."_login_request.xml", $xmlData);
    $resDetail = $client->__doRequest($xmlData2, $location, $action2, SOAP_1_1);
    //file_put_contents("../data/".$fileNameRequest."_login_response.xml", $res);

    $responseArray2 = xml2array($resDetail);
    $agentBalance = @$responseArray2['s:Envelope']['s:Body']['ProcessAgentProfileGetResponse']['ProcessAgentProfileGetResult']['a:CurrentBalance'];

    if($agentBalance)
    {
        $_SESSION["agentbalance"] = ' : Rs '.$agentBalance;   
        echo $agentBalance;
    }
    else
    {
        echo 'Error';
    }
}
exit;


?>
