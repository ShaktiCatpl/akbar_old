<?php 
if(@$_REQUEST['agentCode']!=''){
	echo $agentCode = @$_REQUEST['agentCode'];
}	else	{
session_start();
   if ((trim(@$_SESSION["userName"])=="") || (@$_SESSION["userName"]=="0") || (trim($_SESSION["type"])=="") || (trim(@$_SESSION["userId"])==""))	{
		session_unset();
		session_destroy();
		$url="Location:  index.php";
		header($url);
		exit;
	}	
}
?>