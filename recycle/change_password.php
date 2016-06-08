<?php
error_reporting(0);
include_once("conf/session.php");
include_once("conf/conf.php");
include_once("conf/fucts.php");
$pagetype = 'changepassword';
if(!empty($_POST['password'])){
$userId			=	base64_decode($_SESSION['userId']);
$oldpassword		=	$_POST['old_password'];
$entrytime		=	time();
$array_exists		=	fetchListCond('DESTIMONEYUSER'," WHERE ID = '".@$userId."' AND PASSWORD = '".@$oldpassword."' AND STATUS = 'ACTIVE' ");

if($array_exists[0]['ID']>0) {	
$query 		= 	"UPDATE DESTIMONEYUSER SET PASSWORD = '".$_POST['password']."',TOTALLOGIN = '1',LASTLOGINTIME = '".@$entrytime."' WHERE ID = '".$userId."' AND PASSWORD =	'".$oldpassword."' ";
$sql		= 	oci_parse($conn, $query);
oci_execute($sql);
$url = "Location: index.php?message=Password has been changed, Please login again.";
} else {
$url = "Location: index.php?message=Old Password did not match, Please login again.";
}

header($url);
exit();
}
?>

<!doctype html>
<html lang="en">
<head>
<title>Religare</title>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jqueryslidemenu.css" />
<script type="text/javascript" src="js/jqueryslidemenu.js"></script>
<script type="text/javascript">
function validateForm() {
   var old_password=document.changepass.old_password.value;
	if (old_password == "")
	{
		alert("\nPleaser enter old password.")
		document.changepass.old_password.focus();
		return false;
	}
	var password = document.changepass.password.value;
	if ((password == "")||(password.length < 4))
	{
		alert("\nThe Password field is either empty or less than 4 chars.\n\nPlease re-enter your Password.")
		document.changepass.password.focus();
		return false;
	}
	var confirm_password = document.changepass.confirm_password.value;
	if ((confirm_password == "")||(confirm_password.length < 4))
	{
		alert("\nThe Confirm Password field is either empty or less than 4 chars.\n\nPlease re-enter your Password.")
		document.changepass.confirm_password.focus();
		return false;
	}
	if(password!=confirm_password)
	{
		alert("\nThe Password and Confirm Password did not match.")
		document.changepass.confirm_password.focus();
		return false;
	}
}
</script>
</head>
<body>
<?php include 'inc/header.php'; ?>
<?php include 'inc/navigation.php'; ?>
<div class="mid_inner_container_otc" id="getSearch">
  <div class="quoteBoxgreen">Change Password</div>
  <div class="quoteBoxgreenBottom fl">
    <form method="post" name="changepass" id="changepass" onSubmit="return validateForm()">
      <table width="959" border="0" cellspacing="0" cellpadding="0" class="fl">
        <tr>
          <td><table width="959" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="middle"><strong>Old Password:</strong></td>
                <td height="40" align="left" valign="middle" ><div>
												<input name="old_password" id="old_password" type="password" placeholder="Old Password"  class="txtfield_OTC" style="width:170px;" maxlength="20"/>											
												</div></td>                
              </tr>
              <tr>
                <td height="40" align="left" valign="middle"><strong>New Password:</strong></td>
                <td height="40" align="left" valign="middle"><div>
												<input name="password" id="password" type="password" placeholder="Password"  class="txtfield_OTC" style="width:170px;" maxlength="20"/>											
												</div></td>               
              </tr>
              <tr>
                <td height="40" align="left" valign="middle"><strong>Confirm Password:</strong></td>
                <td height="40" align="left" valign="middle"><div>
												<input name="confirm_password" id="confirm_password" type="password" placeholder="Confirm Password"  class="txtfield_OTC" style="width:170px;" maxlength="20"/>											
												</div></td>                
              </tr>
              <tr>
                <td height="40" align="left" valign="middle"><strong>&nbsp;</strong></td>
                <td height="40" align="left" valign="middle"><div>
												<input type="image" src="images/Faveo-OTC_submit.jpg" style="cursor:pointer;">									
												</div></td>                
              </tr>
            </table></td>
        </tr>             
      </table>
    </form>
  </div>
  <div class="cl"></div>
</div>
<?php include_once("inc/footer.php");	?>
</body>
</html>