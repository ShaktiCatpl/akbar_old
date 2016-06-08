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
            'soap_version' => SOAP_1_2,
        );

$client = new SoapClient(WSDLURL, $options);

$location = ENDPOINTURL;
//$utl = strtoupper(sha1(md5(microtime(true))));
                                
if(!@$_SESSION['loginstatus'])
{   
    $_SESSION['UTL'] = @$_SESSION['UTL'] ? $_SESSION['UTL'] : time();
    $utl = $_SESSION['UTL'];
    
    $action1 = "http://tempuri.org/IWCAPI/ProcessUserLogin";
    $xmlData1 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:wpb="http://schemas.datacontract.org/2004/07/WPBusinessLayer.WPTransactionLayer.WebconnectPlus.Corporate.Agent.User.Proxy">
       <soapenv:Header/>
       <soapenv:Body>
          <tem:ProcessUserLogin>
                <tem:ObjCRPUserLoginReq>
                <wpb:AUI>333</wpb:AUI>
                <wpb:Password>'.$password.'</wpb:Password>
                <wpb:SID>CRPUSERLOGIN</wpb:SID>
                <wpb:UTL>'.$utl.'</wpb:UTL>
                <wpb:UserName>'.$username.'</wpb:UserName>
             </tem:ObjCRPUserLoginReq>
          </tem:ProcessUserLogin>
       </soapenv:Body>
    </soapenv:Envelope>';

    $resLogin = $client->__doRequest($xmlData1, $location, $action1, SOAP_1_1);    

    //Create log file of Request & Response xml for the agent login.
    //file_put_contents("../data/".$fileNameRequest."_login_request.xml", $xmlData1);
    //file_put_contents("../data/".$fileNameRequest."_login_response.xml", $resLogin);

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
                            <wpb:FYearID>9</wpb:FYearID>
                            <wpb:Password>'.$password.'</wpb:Password>
                            <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
                            <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
                            <wpb:UTL>'.$responseUTL.'</wpb:UTL>
                            <wpb:UserName>'.$username.'</wpb:UserName>
                         </tem:ObjAgentProfileGetReq>
                      </tem:ProcessAgentProfileGet>
                   </soapenv:Body>
                </soapenv:Envelope>';
        
        $resDetail = $client->__doRequest($xmlData2, $location, $action2, SOAP_1_1);
        //Create log file of Request & Response xml for the agent balance.
        //file_put_contents("../data/".$fileNameRequest."_balance_request.xml", $xmlData2);
        //file_put_contents("../data/".$fileNameRequest."_balance_response.xml", $resDetail);
        
        $responseArray2 = xml2array($resDetail);
        $agentBalance = @$responseArray2['s:Envelope']['s:Body']['ProcessAgentProfileGetResponse']['ProcessAgentProfileGetResult']['a:CurrentBalance'];

        if(is_float($agentBalance) || is_numeric($agentBalance))
        {
            global $sdbc;
            
            $_SESSION["agentbalance"] = $agentBalance;   
            $_SESSION["balance"] = $agentBalance;  
            
            $createdOn = strtotime(date('Y-m-d H:i:s', time()));
            $sql = "INSERT INTO ATAGENTDETAIL (ID, USERNAME, AGENTUTL, AGENTBALANCE, STATUS, CREATEDON, UPDATEDON) VALUES
                    (ATAGENTDETAIL_SEQ.nextval, '". $username ."', ". $responseUTL .", '".$agentBalance. "', 1, '". $createdOn."', '" .$createdOn."')";    
            $stdid = @oci_parse($sdbc, $sql);                
            oci_execute($stdid)  or die(print_r(oci_error($stdid)));
    
            $afterloginSql = "UPDATE ATAGENTTRANSACTION SET STATUS=1, UPDATEDON=". $createdOn .", TRANSTYPE='quotation' WHERE AGENTUTL=". $responseUTL ." AND STATUS =2";
            $stdid = @oci_parse($sdbc, $afterloginSql);                
            oci_execute($stdid)  or die(print_r(oci_error($stdid)));
    
            
            if(@$_POST['premiumamount'] <= $_SESSION['agentbalance'])
            {
                $data=array(
                    'error' => '',
                    'spanwelcomeagent'=>'<span>Welcome, <strong>'.$username.'</strong></span><a href="signout.php" class="logout">Log Out</a><br>',
                    'spanagentbalance'=> ' Rs : '.@$agentBalance . ' '
                );
            }
            else
            {
                $data=array(
                    'error' => 'errorlessagentbalance',
                    'spanwelcomeagent'=>'<span>Welcome, <strong>'.$username.'</strong></span><a href="signout.php" class="logout">Log Out</a><br>',
                    'spanagentbalance'=> ' Rs : '.@$agentBalance . ' '
                );               
            }
            echo json_encode($data);
        }
        else
        {
            echo json_encode(array('error' => 'erroragentbalance'));
        }        
        // echo $agentBalance. ':;<span>Welcome, <strong>'.$username.'</strong></span><a href="signout.php" class="logout">Log Out</a><br>'.
        //':;Group Care Balance&nbsp;&nbsp;'.$agentBalance.'<span id="carefloatresult" style="width:50px; padding-right:5px;"></span><a id="carefloat" href="#" onclick="getagentfloat("care", 1)">';        
    }
    else
    {
        echo json_encode(array('error' => 'errorlogin'));
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
                        <wpb:FYearID>9</wpb:FYearID>
                        <wpb:Password>'.$password.'</wpb:Password>
                        <wpb:RequestedFrom>IMGAPI</wpb:RequestedFrom>
                        <wpb:SID>CRPAGTPROFILEGET</wpb:SID>
                        <wpb:UTL>'.$responseUTL.'</wpb:UTL>
                        <wpb:UserName>'.$username.'</wpb:UserName>
                     </tem:ObjAgentProfileGetReq>
                  </tem:ProcessAgentProfileGet>
               </soapenv:Body>
            </soapenv:Envelope>';
    $resDetail = $client->__doRequest($xmlData2, $location, $action2, SOAP_1_1);
    //Create log file of Request & Response xml for the agent balance.
    //file_put_contents("..//data/".$fileNameRequest."_balance_request.xml", $xmlData2);    
    //file_put_contents("../data/".$fileNameRequest."_balance_response.xml", $resDetail);

    $responseArray2 = xml2array($resDetail);
    $agentBalance = @$responseArray2['s:Envelope']['s:Body']['ProcessAgentProfileGetResponse']['ProcessAgentProfileGetResult']['a:CurrentBalance'];

    if(is_float($agentBalance) || is_numeric($agentBalance))
    {
        $_SESSION["agentbalance"] = $agentBalance;  
        if(@$_POST['premiumamount'] <= $agentBalance)
        {
            //echo 'premiumsuccess';
            echo $agentBalance;
        }
        else
        {
            echo 'Error';
        }
    }
    else
    {
        echo 'Error';
    }
}
exit;


?>
