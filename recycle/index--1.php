<?php
error_reporting(0);
include_once($_SERVER['DOCUMENT_ROOT'].'/travel/classes/sessionHandlerDB.php');
//echo $_SERVER['DOCUMENT_ROOT'].'/travel/classes/sessionHandlerDB.php';

$_SESSION['destimoney']='destimoney';
$handler = new sessionHandlerDB();
$timeout = 10*60; 

/*
if (isset($_SESSION['start_time'])) {
    //$elapsed_time = time() - $_SESSION['start_time'];
    if ($_SESSION['start_time'] + $timeout < time()) {
	session_destroy();
     // session timed out
  } else {
  $_SESSION['start_time'] = time();
  }
} else {
$_SESSION['start_time'] = time();
}
*/

session_start();
$_SESSION['userId']	=	'';
$_SESSION["name"]	=	'';
$_SESSION["agentId"]	=	'';
$_SESSION["emailId"]	=	'';
$_SESSION["lastLogin"]	=	'';
setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

foreach (@$_COOKIE as $key => $value )
{
  setcookie( $key, '', 1, '/' );
}

include_once("conf/conf.php");
include_once("conf/fucts.php");
$useripadd = $_SERVER['REMOTE_ADDR'];
$entryTime = time();

if($_SERVER["REQUEST_METHOD"] == "POST"){

session_regenerate_id();
$username =	sanitize_email(@$_POST['username']);
$password =	sanitize_password(base64_decode(@$_POST['password']));			
$array_exists = fetchListCond('DESTIMONEYUSER'," WHERE USERNAME = '".@$username."' AND PASSWORD = '".@$password."' AND STATUS = 'ACTIVE' ");
			
    /*echo '<pre>';
    print_r($array_exists);
    die();*/
                        
    if($array_exists[0]['ID']>0) {	
    $lastLoginTime 	= $array_exists[0]['LASTLOGINTIME']; //LASTLOGINTIME TOTALLOGIN
    $totalLogin 	= $array_exists[0]['TOTALLOGIN'];
    $agentId 	= $array_exists[0]['AGENTID'];
    $totalLoginVar 	= $totalLogin+1;
        
    $_SESSION['userId'] =	base64_encode(@$array_exists[0]['ID']);				
    $_SESSION["name"]   =	base64_encode(@$array_exists[0]['NAME']);
    $_SESSION["agentId"] =	$array_exists[0]['AGENTID'];
    $_SESSION["lastLogin"] = base64_encode(@$lastLoginTime);

    $sql = "INSERT INTO DESTIMONEYUSERLOGINLOG (ID,USERID,USERNAME,PASSWORD,NAME,EMAILID,IPADDRESS,CREATEDON,CREATEDBY,UPDATEDON) 
    values(RMPORTALUSERLOGINLOG_SEQ.nextval,'".@$array_exists[0]['ID']."','".@$username."','".@$password."','".@$name."','".@$emailId."','".@$useripadd."','".@$entryTime."','".@$username."','".@$entryTime."') ";//query to insert records
    $stdid	= @oci_parse($conn, $sql);
    $r = @oci_execute($stdid);

    if($totalLogin<1) {
    $url = "Location:change_password.php";
    } else {
    $entrytime = time();
    $querynew = "UPDATE DESTIMONEYUSER SET TOTALLOGIN = '".@$totalLoginVar."',LASTLOGINTIME = '".@$entrytime."' WHERE ID = '".$array_exists[0]['ID']."' ";
    $sqlnew = oci_parse($conn, $querynew);
    oci_execute($sqlnew);
    $url = "Location:travel.php";
    }				
    } else {
      $url="Location: index.php?message=User name or Password are incorrect.";				
    }			
    header($url);
    exit;
}
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Travel</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/encrypt.js"></script>




<script language="JavaScript">
function  validate()
{
	var username=document.loginForm.username.value;
	if (username == "")
	{
		alert("\nPleaser enter Username.")
		document.loginForm.username.focus();
		return false;
	}
	var password = document.loginForm.password.value;
	if ((password == "")||(password.length < 4))
	{
		alert("\nThe PASSWORD field is either empty or less than 4 chars.\n\nPlease re-enter your Password.")
		document.loginForm.password.focus();
		return false;
	}
        
	/*var code=document.loginForm.code.value;
	if (code == "")
	{
            alert("\nPleaser enter verification code.")
            document.loginForm.code.focus();
            return false;
	}*/
        
	 var encoded_val=base64_encode(password);
	 $('#password').val(encoded_val);
	 document.getElementById("loginForm").submit();
}
        $(document).ready(function(){
        $('#errorMsg').fadeOut(10000);
})
function resetbuttn(){
	window.location = "index.php";
}
</script>
<style>
.message {
	text-align:center; 
	color:red;
	padding:10px;
}
</style>
</head>
<body style="background:#b7db82;">
<div class="login_header" style="margin: auto; padding: 50px 30px 10px; width: 930px;"><img src="images/Auxilium-Logo01.png" alt="tractus" class="fl" />
  <div class="cl"></div>
</div>
<div class="login_container">
<?php if(sanitize_data(@$_REQUEST['message'])!=''){?>
	<div id="errorMsg" class="message" ><?php echo sanitize_data(@$_REQUEST['message']);?></div>
	<?php } ?>
        
 <form name="loginForm" id="loginForm" method="post" onsubmit="return validate()">
  <table width="470" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="general_txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="440" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="102" height="30" align="left" valign="middle" class="general_txt">User Id&nbsp;<span style="color:red; vertical-align:text-top;">*</span></td>
                  <td width="49" height="30" align="center" valign="middle" class="general_txt">&nbsp;</td>
                  <td width="289" height="30" align="left" valign="middle"><input type="text" name="username" id="username" AUTOCOMPLETE="OFF"/></td>
                </tr>
                <tr>
                  <td height="30" align="left" valign="middle" class="general_txt">Password&nbsp;<span style="color:red; vertical-align:text-top;">*</span></td>
                  <td height="30" align="center" valign="middle" class="general_txt">&nbsp;</td>
                  <td height="30" align="left" valign="middle"><input type="password" name="password" id="password" AUTOCOMPLETE="OFF"/></td>
                </tr>				
                <tr>
                  <td align="left" valign="middle" class="general_txt">&nbsp;</td>
                  <td align="center" valign="middle" class="general_txt">&nbsp;</td>
                  <td height="45" align="left" valign="top">
                  <input type="image" src="images/login_btn.png" style="cursor:pointer;" />
                <!--<img src="images/login_btn.png" style="cursor:pointer;" onclick="validate()" />-->&nbsp;&nbsp;
                  <!--<img src="images/reset_btn.png" style="cursor:pointer;" onclick="resetbuttn()" />--></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
  </form>
</div>
<div align="center" style="position: absolute; bottom: 10; font-size: xx-small; width: 100%; padding-top:80px;"><label> Copyrights <?php echo date('Y');?>, All right reserved by Religare Health Insurance " </label> </div>
<!--<div class="footer_container"> Copyrights <?php echo date('Y');?>, All right reserved by Religare Health Insurance Company Ltd.</div>-->
</body>
</html>