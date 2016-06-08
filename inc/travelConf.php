<?php

define("TRAVELTBL", "travel");
date_default_timezone_set('Asia/Calcutta');
function no_of_days($startDate, $endDate) {
    $date1 = strtotime($endDate);
    $date2 = strtotime($startDate);
    $dateDiff = $date1 - $date2;
    $fullDays = floor($dateDiff / (60 * 60 * 24));
    return $fullDays + 1;
}
function dbConnectMysql() {
    $httphost = $_SERVER['HTTP_HOST'];
    if ($httphost == 'localhost') {
        $db_hostName = "localhost"; //defined host name
        $dbName = "travel"; //defined db name
        $db_username = "root";  // define db username
        $db_password = ""; // define db password
    } else {
        $db_hostName = "10.216.9.159"; //defined host name
        $dbName = "travel"; //defined db name
        $db_username = "cat_lms";  // define db username
        $db_password = "LaserCut319"; // define db password
    }
    $conn = mysql_connect($db_hostName, $db_username, $db_password) or die("connection fail");
    return mysql_select_db($dbName, $conn) or die("does not select database");
}

function travelToDropDown($val) {
    switch ($val) {
        case '40001001' : {
                $resultVal = 1;
                break;
            }
        case '40001002' : {
                $resultVal = 2;
                break;
            }
        case '40001004' : {
                $resultVal = 4;
                break;
            }
        case '40001015' : {
                $resultVal = 3;
                break;
            }
        case '40001005' : {
                $resultVal = 6;
                break;
            }
        case '40001006' : {
                $resultVal = 6;
                break;
            }
        case '40001007' : {
                $resultVal = 5;
                break;
            }
        case '40001008' : {
                $resultVal = 5;
                break;
            }
        case '40001009' : {
                $resultVal = 6;
                break;
            }
        case '40001010' : {
                $resultVal = 6;
                break;
            }
        case '40001011' : {
                $resultVal = 5;
                break;
            }
        case '40001012' : {
                $resultVal = 5;
                break;
            }
    }
    return $resultVal;
}

function selectPlan($val) {
    switch ($val) {
        case '40001001' : {
                $resultVal = "ONE";
                break;
            }
        case '40001002' : {
                $resultVal = "ONE";
                break;
            }
        case '40001004' : {
                $resultVal = "ONE";
                break;
            }
        case '40001015' : {
                $resultVal = "ONE";
                break;
            }
        case '40001005' : {
                $resultVal = "ONE";
                break;
            }
        case '40001006' : {
                $resultVal = "TWO";
                break;
            }
        case '40001007' : {
                $resultVal = "ONE";
                break;
            }
        case '40001008' : {
                $resultVal = "TWO";
                break;
            }
        case '40001009' : {
                $resultVal = "ONE";
                break;
            }
        case '40001010' : {
                $resultVal = "TWO";
                break;
            }
        case '40001011' : {
                $resultVal = "ONE";
                break;
            }
        case '40001012' : {
                $resultVal = "TWO";
                break;
            }
    }
    return $resultVal;
}

function travelToText($val) {
    switch ($val) {
        case '40001001' : {
                $resultVal = "Explore - Asia";
                break;
            }
        case '40001002' : {
                $resultVal = "Explore - Africa";
                break;
            }
        case '40001004' : {
                $resultVal = "Explore - Canada";
                break;
            }
        case '40001015' : {
                $resultVal = "Explore - Europe";
                break;
            }
        case '40001005' : {
                $resultVal = "Explore - Gold Worldwide - Excluding US & Canada";
                break;
            }
        case '40001006' : {
                $resultVal = "Explore - Platinum -Worldwide - Excluding US & Canada";
                break;
            }
        case '40001007' : {
                $resultVal = "Explore - Gold - Worldwide";
                break;
            }
        case '40001008' : {
                $resultVal = "Explore - Platinum -Worldwide";
                break;
            }
        case '40001009' : {
                $resultVal = "Explore - Gold Worldwide - Excluding US & Canada";
                break;
            }
        case '40001010' : {
                $resultVal = "Explore - Platinum -Worldwide - Excluding US & Canada";
                break;
            }
        case '40001011' : {
                $resultVal = "Explore - Gold - Worldwide";
                break;
            }
        case '40001012' : {
                $resultVal = "Explore - Platinum -Worldwide";
                break;
            }
    }
    return $resultVal;
}

function travelToSumInsured($val, $sum) {
    $OptionalVal = travelToDropDown($val);
    switch ($OptionalVal) {
        case '1' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "25000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "50000";
                            break;
                        }
                    case '003': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                }
                break;
            }
        case '2' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "25000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "50000";
                            break;
                        }
                    case '003': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                }
                break;
            }
        case '3' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "30000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                }
                break;
            }
        case '4' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "50000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                }
                break;
            }
        case '5' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "50000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                    case '003': {
                            $sumInsuredVal = "300000";
                            break;
                        }
                    case '004': {
                            $sumInsuredVal = "500000";
                            break;
                        }
                }
                break;
            }
        case '6' : {
                switch ($sum) {
                    case '001': {
                            $sumInsuredVal = "50000";
                            break;
                        }
                    case '002': {
                            $sumInsuredVal = "100000";
                            break;
                        }
                    case '003': {
                            $sumInsuredVal = "300000";
                            break;
                        }
                    case '004': {
                            $sumInsuredVal = "500000";
                            break;
                        }
                }
                break;
            }
    }
    return $sumInsuredVal;
}

function getSumIns($val) {
    switch ($val) {
        case '001': {
                $sumInsuredVal = "300000";
                break;
            }
        case '002': {
                $sumInsuredVal = "400000";
                break;
            }
        case '003': {
                $sumInsuredVal = "500000";
                break;
            }
        case '004': {
                $sumInsuredVal = "600000";
                break;
            }
    }
    return $sumInsuredVal;
}

function getMultiSumInsured($travellingTo, $ageGroupOfEldestMember, $sumInsured, $pedQuestion) {
    $finalArray = explode(',', $ageGroupOfEldestMember);
    $sumInsuredArray = array();
    switch ($travellingTo) {
        case '1': {
                if (in_array("81-99", $finalArray)) {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = $sumInsured;
                } else {
                    $sumInsuredArray['sumInsured4'] = $sumInsured;
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = "001";
                }
                break;
            }
        case '2': {
                if (in_array("81-99", $finalArray)) {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = $sumInsured;
                } else {
                    $sumInsuredArray['sumInsured4'] = $sumInsured;
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = "001";
                }
                break;
            }
        case '3': {
                $sumInsuredArray['sumInsured4'] = "001";
                $sumInsuredArray['sumInsured2'] = "001";
                $sumInsuredArray['sumInsured3'] = $sumInsured;
                break;
            }
        case '4': {
                $sumInsuredArray['sumInsured4'] = "001";
                $sumInsuredArray['sumInsured2'] = "001";
                $sumInsuredArray['sumInsured3'] = $sumInsured;
                break;
            }
        case '5': {
                if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = $sumInsured;
                } else {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = $sumInsured;
                    $sumInsuredArray['sumInsured3'] = "001";
                }
                break;
            }
        case '6': {

                if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = "001";
                    $sumInsuredArray['sumInsured3'] = $sumInsured;
                } else {
                    $sumInsuredArray['sumInsured4'] = "001";
                    $sumInsuredArray['sumInsured2'] = $sumInsured;
                    $sumInsuredArray['sumInsured3'] = "001";
                }
                break;
            }
    }
    return $sumInsuredArray;
}

?>
