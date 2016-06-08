<?php
session_start();
session_destroy();
$_SESSION['userId']		=	'';
$_SESSION["name"]		=	'';
$_SESSION["agentId"]	=	'';
$_SESSION["emailId"]	=	'';
$_SESSION["lastLogin"]	=	'';
setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.
foreach (@$_COOKIE as $key => $value )
{
    setcookie( $key, '', 1, '/' );
}
$url='Location: index.php';
header($url);
exit;
?>