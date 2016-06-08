<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/akbar/classes/sessionHandlerDB.php');
// echo $_SERVER['DOCUMENT_ROOT'].'/intermediary/destimoney/classes/sessionHandlerDB.php';

$_SESSION['travel'] = 'travel';
$handler = new sessionHandlerDB();
$timeout = 10 * 60;
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

session_start();

/* print_r($_SESSION);
  die; */
/* echo '<pre>';
  print_r($_SESSION); */

//if ((trim(@$_SESSION["userId"]) == "") || (trim(@$_SESSION["agentId"]) == "")) {
//    session_unset();
//    session_destroy();
//    $url = "Location:  index.php";
//    header($url);
//    exit;
//}

$TRAVELPLAN = array(
    "1" => "Asia",
    "2" => "Africa",
    "3" => "Europe",
    "4" => "Canada",
    "5" => "Worldwide",
    "6" => "WW-Excl. US / Canada",
);
?>