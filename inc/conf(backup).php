<?php
ob_start();
error_reporting(0);
define("SITEURL", "http://rhicluat.religare.com/religare/");
define("PROPOSALSITEURL", "https://buyuat.religare.com:7443/");
define("LEADURL","http://10.216.6.50:80/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devinst,o=religare.in");
define("WSDLURL","https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices?wsdl");
define("ENDPOINTURL","https://rhicluat.religare.com/relinterface/services/RelSymbiosysServices.RelSymbiosysServicesHttpSoap12Endpoint/");
define("PAYMENTURL","https://rhicluat.religare.com/portalui/PortalPayment.run");
define("RENEWALURL","https://rhicluat.religare.com/portalui/jsp/RenewalLogin.jsp");

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $propasalPage = "0";
} else {
    $propasalPage = "1";
}
function dbConnect() {
    $httphost = $_SERVER['HTTP_HOST'];
    if ($httphost == 'localhost') {         
        $db_hostName = "localhost"; //defined host name
        $db_hostPort = "1521"; //defined host name
        $db_serviceName = "XE"; //defined db name
        $db_username = "prashant";  // define db username
        $db_password = "prashant"; // define db password
    } else {
    $db_hostName = "10.216.9.197"; //defined host name
    $db_hostPort = "1521"; //defined host name
    $db_serviceName = "orcl"; //defined db name
    $db_username = "Proposal";  // define db username
    $db_password = "proposal"; // define db password
    }
    $conn = oci_connect("$db_username", "$db_password", "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
            (HOST=" . $db_hostName . ")(PORT=" . $db_hostPort . "))
            (CONNECT_DATA=(SERVICE_NAME=" . $db_serviceName . ")))") or die("can not connect to database");
    return $conn;
}
function dbMicrConnect() {
    $db_hostName = "10.216.9.197"; //defined host name
    $db_hostPort = "1521"; //defined host name
    $db_serviceName = "orcl"; //defined db name
    $db_username = "rhstage";  // define db username
    $db_password = "rhstage"; // define db password
    
    $conn = oci_connect("$db_username", "$db_password", "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
            (HOST=" . $db_hostName . ")(PORT=" . $db_hostPort . "))
            (CONNECT_DATA=(SERVICE_NAME=" . $db_serviceName . ")))") or die("can not connect to database");
    return $conn;
}
function fetchAllMicrData($table) {
    $connC = dbMicrConnect();
    $dataArray = array();
    if (isset($table)) {
      $query = "SELECT MICRNUM FROM $table";
        $sql = oci_parse($connC, $query);
        // Execute Query
        oci_execute($sql);
        $i = 0;
        while (($row = oci_fetch_assoc($sql))) {
            foreach ($row as $key => $value) {
                $dataArray[$i][$key] = $value;
            }
            $i++;
        }
    }
    return $dataArray;
}
function fetchListByMicr($table, $id) {
    $connC = dbMicrConnect();
    $dataArray = array();
    if (isset($table)) {
      $query = "SELECT * FROM $table WHERE MICRNUM = '" . $id."'";
        $sql = oci_parse($connC, $query);
        // Execute Query
        oci_execute($sql);
        $i = 0;
        while (($row = oci_fetch_assoc($sql))) {
            foreach ($row as $key => $value) {
                $dataArray[$i][$key] = $value;
            }
            $i++;
        }
    }
    return $dataArray;
}
function sanitize_data_email($input_data) {
    $searchArr = array("document", "write", "alert", "%", "$", ";", "+", "|", "#", "<", ">", ")", "(", "'", "\'");
    $input_data = str_replace("script", "", $input_data);
    $input_data = str_replace("iframe", "", $input_data);
    $input_data = str_replace($searchArr, "", $input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function sanitize_data($input_data) {
    $searchArr = array("document", "write", "alert", "%", "@", "$", ";", "+", "|", "#", "<", ">", ")", "(", "'", "\'", ",");
    $input_data = str_replace("script", "", $input_data);
    $input_data = str_replace("iframe", "", $input_data);
    $input_data = str_replace($searchArr, "", $input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function moneyFormatIndia($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function fetchListByColumnName($table, $id) {
    $conn = dbConnect();
    $dataArray = array();
    if (isset($table)) {
        $query = "SELECT * FROM $table WHERE REFERENCE_ID=" . $id;
        $sql = oci_parse($conn, $query);
        // Execute Query
        oci_execute($sql);
        $i = 0;
        while (($row = oci_fetch_assoc($sql))) {
            foreach ($row as $key => $value) {
                $dataArray[$i][$key] = $value;
            }
            $i++;
        }
    }
    return $dataArray;
}

function fetchListByPinCode($table, $id) {
    $conn = dbConnect();
    $dataArray = array();
    if (isset($table)) {
       $query = "SELECT * FROM $table WHERE " . $id; 
        $sql = oci_parse($conn, $query);
        // Execute Query
        oci_execute($sql);
        $i = 0;
        while (($row = oci_fetch_assoc($sql))) {
            foreach ($row as $key => $value) {
                $dataArray[$i][$key] = $value;
            }
            $i++;
        }
    }

    //echo '<pre>';print_r($dataArray);exit;


    return $dataArray;
}

function fetchAllData($table) {
    $conn = dbConnect();
    $dataArray = array();
    if (isset($table)) {
        $query = "SELECT * FROM $table";
        $sql = oci_parse($conn, $query);
        // Execute Query
        oci_execute($sql);
        $i = 0;
        while (($row = oci_fetch_assoc($sql))) {
            foreach ($row as $key => $value) {
                $dataArray[$i][$key] = $value;
            }
            $i++;
        }
    }

    //echo '<pre>';print_r($dataArray);exit;


    return $dataArray;
}

function getDeductible($sumInsured, $coverType, $productCode) {
    // echo $sumInsured.'<br>'.$coverType.'<br>'.$productCode;exit;

    $resultArray = array();
    if ($productCode == 11001001) {
        if ($coverType == 'FAMILYFLOATER') {
            switch ($sumInsured) {
                case '002': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '004': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '006': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '008': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '010': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '012': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '014': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '016': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '018': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '020': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '022': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '024': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '026': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '028': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '030': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '032': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '034': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '036': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '038': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '040': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }

                case '042': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '044': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '046': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '048': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '050': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '052': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '054': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '056': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '058': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '060': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '062': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '064': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '066': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '068': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '070': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '072': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '074': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '076': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '078': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '080': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
            }
        } else if ($coverType == 'INDIVIDUAL') {
            switch ($sumInsured) {
                case '001': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '003': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '005': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '007': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '009': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '011': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '013': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '015': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '017': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '019': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '021': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '023': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '025': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '027': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '029': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '031': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '033': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '035': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '037': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '039': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }

                case '041': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '043': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '045': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '047': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 400000;
                        break;
                    }
                case '049': {
                        $resultArray['deductible'] = 500000;
                        $resultArray['sumInsured'] = 500000;
                        break;
                    }
                case '051': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '053': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '055': {
                        $resultArray['deductible'] = 600000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '057': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '059': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '061': {
                        $resultArray['deductible'] = 700000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '063': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '065': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '067': {
                        $resultArray['deductible'] = 800000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '069': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '071': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '073': {
                        $resultArray['deductible'] = 900000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
                case '075': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '077': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '079': {
                        $resultArray['deductible'] = 1000000;
                        $resultArray['sumInsured'] = 300000;
                        break;
                    }
            }
        }
    } else if ($productCode == 11001002) {
        if ($coverType == 'FAMILYFLOATER') {
            switch ($sumInsured) {
                case '002': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '004': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '006': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '008': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '010': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '012': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '014': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '016': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
            }
        } else if ($coverType == 'INDIVIDUAL') {
            switch ($sumInsured) {
                case '001': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '003': {
                        $resultArray['deductible'] = 100000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '005': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '007': {
                        $resultArray['deductible'] = 200000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '009': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '011': {
                        $resultArray['deductible'] = 300000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
                case '013': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 100000;
                        break;
                    }
                case '015': {
                        $resultArray['deductible'] = 400000;
                        $resultArray['sumInsured'] = 200000;
                        break;
                    }
            }
        }
    }
    return $resultArray;
}

function encryptProposal($string, $key) {
    $result = "";
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result.=$char;
    }
    $salt_string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxys0123456789~!@#$^&*()_+`-={}|:<>?[]\;',./";
    $length = rand(1, 15);
    $salt = "";
    for ($i = 0; $i <= $length; $i++) {
        $salt .= substr($salt_string, rand(0, strlen($salt_string)), 1);
    }
    $salt_length = strlen($salt);
    $end_length = strlen(strval($salt_length));
    return base64_encode($result . $salt . $salt_length . $end_length);
}

function decryptProposal($string, $key) {
    $result = "";
    $string = base64_decode($string);
    $end_length = intval(substr($string, -1, 1));
    $string = substr($string, 0, -1);
    $salt_length = intval(substr($string, $end_length * -1, $end_length));
    $string = substr($string, 0, $end_length * -1 + $salt_length * -1);
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result.=$char;
    }
    return $result;
}

$questionArray = array(
    "205" => "Diabetes",
    "207" => "Hypertension / High blood pressure",
    '147' => "HIV/ AIDS/ STD",
    "232" => "Liver Disease",
    "114" => "Cancer / Tumor",
    "143" => "Cardiac Disease",
    "105" => "Arthritis / Joint pain",
    "129" => "Kidney Disease",
    "164" => "Paralysis / stroke",
    "122" => "Congenital Disorder",
    "210" => "Any other diseases or ailments not mentioned above"
);

$monthArray = array(
    '1' => "01",
    '2' => "02",
    '3' => "03",
    '4' => "04",
    '5' => "05",
    '6' => "06",
    '7' => "07",
    '8' => "08",
    '9' => "09",
    '10' => "10",
    '11' => "11",
    '12' => "12"
);

$questionIDArray = array(
    "205" => array("qSetId" => "PEDdiabetesDetails", "yearQId" => "diabetesExistingSince"),
    "207" => array("qSetId" => "PEDhyperTensionDetails", "yearQId" => "hyperTensionExistingSince"),
    '147' => array("qSetId" => "PEDHivaidsDetails", "yearQId" => "hivaidsExistingSince"),
    "232" => array("qSetId" => "PEDliverDetails", "yearQId" => "liverExistingSince"),
    "114" => array("qSetId" => "PEDcancerDetails", "yearQId" => "cancerExistingSince"),
    "143" => array("qSetId" => "PEDcardiacDetails", "yearQId" => "cardiacExistingSince"),
    "105" => array("qSetId" => "PEDjointpainDetails", "yearQId" => "jointpainExistingSince"),
    "129" => array("qSetId" => "PEDkidneyDetails", "yearQId" => "kidneyExistingSince"),
    "164" => array("qSetId" => "PEDparalysisDetails", "yearQId" => "paralysisExistingSince"),
    "122" => array("qSetId" => "PEDcongenitalDetails", "yearQId" => "congenitalExistingSince"),
    "210" => array("qSetId" => "PEDotherDetails", "yearQId" => "otherExistingSince"),
    "1" => array("qSetId" => "PEDdiabetesDetails", "yearQId" => "diabetesExistingSince")
);

$sunInsuredEnhganceOneArray = array(
    "001" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "100000", "deductible" => "100000"),
    "002" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "100000", "deductible" => "100000"),
    "003" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "200000", "deductible" => "100000"),
    "004" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "200000", "deductible" => "100000"),
    "005" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "300000", "deductible" => "100000"),
    "006" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "300000", "deductible" => "100000"),
    "007" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "400000", "deductible" => "100000"),
    "008" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "400000", "deductible" => "100000"),
    "009" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "500000", "deductible" => "100000"),
    "010" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "500000", "deductible" => "100000"),
    "011" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "200000", "deductible" => "200000"),
    "012" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "200000", "deductible" => "200000"),
    "013" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "400000", "deductible" => "200000"),
    "014" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "400000", "deductible" => "200000"),
    "015" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "600000", "deductible" => "200000"),
    "016" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "600000", "deductible" => "200000"),
    "017" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "800000", "deductible" => "200000"),
    "018" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "800000", "deductible" => "200000"),
    "019" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1000000", "deductible" => "200000"),
    "020" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1000000", "deductible" => "200000"),
    "021" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "300000", "deductible" => "300000"),
    "022" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "300000", "deductible" => "300000"),
    "023" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "600000", "deductible" => "300000"),
    "024" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "600000", "deductible" => "300000"),
    "025" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "900000", "deductible" => "300000"),
    "026" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "900000", "deductible" => "300000"),
    "027" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1200000", "deductible" => "300000"),
    "028" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1200000", "deductible" => "300000"),
    "029" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1500000", "deductible" => "300000"),
    "030" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1500000", "deductible" => "300000"),
    "031" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "400000", "deductible" => "400000"),
    "032" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "400000", "deductible" => "400000"),
    "033" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "800000", "deductible" => "400000"),
    "034" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "800000", "deductible" => "400000"),
    "035" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1200000", "deductible" => "400000"),
    "036" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1200000", "deductible" => "400000"),
    "037" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1600000", "deductible" => "400000"),
    "038" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1600000", "deductible" => "400000"),
    "039" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2000000", "deductible" => "400000"),
    "040" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2000000", "deductible" => "400000"),
    "041" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "500000", "deductible" => "500000"),
    "042" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "500000", "deductible" => "500000"),
    "043" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1000000", "deductible" => "500000"),
    "044" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1000000", "deductible" => "500000"),
    "045" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1500000", "deductible" => "500000"),
    "046" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1500000", "deductible" => "500000"),
    "047" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2000000", "deductible" => "500000"),
    "048" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2000000", "deductible" => "500000"),
    "049" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2500000", "deductible" => "500000"),
    "050" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2500000", "deductible" => "500000"),
    "051" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "600000", "deductible" => "600000"),
    "052" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "600000", "deductible" => "600000"),
    "053" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1200000", "deductible" => "600000"),
    "054" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1200000", "deductible" => "600000"),
    "055" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1800000", "deductible" => "600000"),
    "056" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1800000", "deductible" => "600000"),
    "057" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "700000", "deductible" => "700000"),
    "058" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "700000", "deductible" => "700000"),
    "059" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1400000", "deductible" => "700000"),
    "060" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1400000", "deductible" => "700000"),
    "061" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2100000", "deductible" => "700000"),
    "062" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2100000", "deductible" => "700000"),
    "063" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "800000", "deductible" => "800000"),
    "064" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "800000", "deductible" => "800000"),
    "065" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1600000", "deductible" => "800000"),
    "066" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1600000", "deductible" => "800000"),
    "067" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2400000", "deductible" => "800000"),
    "068" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2400000", "deductible" => "800000"),
    "069" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "900000", "deductible" => "900000"),
    "070" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "900000", "deductible" => "900000"),
    "071" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1800000", "deductible" => "900000"),
    "072" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1800000", "deductible" => "900000"),
    "073" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2700000", "deductible" => "900000"),
    "074" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2700000", "deductible" => "900000"),
    "075" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "1000000", "deductible" => "1000000"),
    "076" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "1000000", "deductible" => "1000000"),
    "077" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "2000000", "deductible" => "1000000"),
    "078" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "2000000", "deductible" => "1000000"),
    "079" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "3000000", "deductible" => "1000000"),
    "080" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "3000000", "deductible" => "1000000")
);
$sunInsuredEnhganceTwoArray = array(
    "001" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "4500000", "deductible" => "500000"),
    "002" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "4500000", "deductible" => "500000"),
    "003" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "5500000", "deductible" => "500000"),
    "004" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "5500000", "deductible" => "500000"),
    "005" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "4000000", "deductible" => "1000000"),
    "006" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "4000000", "deductible" => "1000000"),
    "007" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "4000000", "deductible" => "1000000"),
    "008" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "4000000", "deductible" => "1000000"),
    "009" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "3500000", "deductible" => "1500000"),
    "010" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "3500000", "deductible" => "1500000"),
    "011" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "4500000", "deductible" => "1500000"),
    "012" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "4500000", "deductible" => "1500000"),
    "013" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "3000000", "deductible" => "2000000"),
    "014" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "3000000", "deductible" => "2000000"),
    "015" => array("coverTypeCode" => "INDIVIDUAL", "sumInsured" => "4000000", "deductible" => "2000000"),
    "016" => array("coverTypeCode" => "FAMILYFLOATER", "sumInsured" => "4000000", "deductible" => "2000000")
);

function saveContinueMail($titleCd, $firstName, $lastName, $saveandcontinueemail, $subject, $proposalTenourCode, $totalChildMember, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId, $productData,$query) {
    
    if ($titleCd != '' && $titleCd != '0') {
        $titleCd = ucfirst($titleCd);
    } else {
        $titleCd = '';
    }
    if ($firstName != '') {
        $firstName = ucfirst($firstName);
    } else {
        $firstName = '';
    }
    if ($lastName != '') {
        $lastName = ucfirst($lastName);
    } else {
        $lastName = '';
    }
    
	if($productData	==	'CARE'){
		$producturl	=	'care.php';
	}
	if($productData	==	'ENHANCE'){
		$producturl	=	'enhance.php';
	}	//
	if($productData	==	'ASSURE'){
		$producturl	=	'assure.php';
	}
	if($productData	==	'Joy'){
		$producturl	=	'joy.php';
	}
	if($productData	==	'SECURE'){
		$producturl	=	'secure.php';
	}

    $body1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="' . PROPOSALSITEURL . 'images/top_banner.jpg" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#397628;"><strong>Go ahead and make a wise decision by choosing us!</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Dear  ' . $titleCd . ' <span style="color:#548dd4;">' . $firstName . ' ' . $lastName . ',</span></td>
      </tr>
      <tr>
        <td height="39" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">We thank you for your interest in Religare Health Insurance. We have saved your proposal information so that you can continue to
buy your policy, Here is a recap of the details provided by you - 
</td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="780" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Plan
              name</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . ucfirst(strtolower($productData)) . ',  ' . getRepeesVal($proposalDummySi) . ' </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Total
              members</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Children
              (less than 25 years)</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalChildMember . '</td>
          </tr>
          <tr>
            <td width="193" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Age
              of eldest member</td>
            <td width="20" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td width="567" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $proposalageGroupOfEldestMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Premium</strong></td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Rs. ' . $PREMIUM_AMOUNT . ',
                for ' . $proposalTenourCode . ' year(s)</strong> (inclusive of Taxes)</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td height="80" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Please  click here to <a href="' . PROPOSALSITEURL.$producturl.'?id=' . $policyId . '&code=' . hash('sha256', "proposal-$policyId") . '" style="color:#ff0600; font-weight:bold;"> Buy Now</a>  or Call <span style="color:#1c8400;font-weight: bold;">1800-200-4488 (Toll free)</span> for  any assistance in buying. </td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><br /><br />
          <br />Wishing you Health...Hamesha! <br /><br />
          
          Team Religare Health insurance.<br /><br /><br />
          
          
          Kindly ignore this mail if you have already bought. *Terms and Conditions apply. </td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="760" border="0" align="left" cellpadding="0" cellspacing="0" style="border-top:1px solid #000000; border-bottom:1px solid #999999;">
     
      <tr>
        <td width="250" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong style=" padding-left:15px;">About Us</strong><br />
          <a href="' . SITEURL . '?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333; padding-left:15px;">Religare Health Insurance</a><br />
          <a href="http://www.religare.com/" style="color:#333333; padding-left:15px;">Religare Enterprises Ltd.</a><br />
          <a href="' . SITEURL . 'buy-top-up-medical-insurance-policy.html" style="color:#333333; padding-left:15px;">Enhance - Comprehensive Health Insurance</a></td>
        <td width="52" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="215" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Reach Us</strong><br />
          <span style=" font-weight: bold;">Call us 1800-200-4488</span><br />
          <a href="mailto:customerfirst@religarehealthinsurance.com" style="color:#333333;">E-mail us</a><br />
          <a href="' . SITEURL . 'health-insurance-branch-locator.html?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Nearest Branch</a></td>
        <td width="45" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="198" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Customer First</strong><br />
        <a href="' . SITEURL . 'religare-customer-support.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Customer Service</a><br />
          <a href="' . SITEURL . 'health-plan-network-hospitals.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Network Hospitals</a><br />
          <a href="' . SITEURL . 'health-bmi-calculator.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Health Calculator</a></td>
      </tr>
       <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr valign="middle">
    <td height="70" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#cccccc;">You are receiving this mail as you requested a premium quote from our website.<br />
Insurance is a subject matter of solicitation. IRDA Registration Number - 148<br />
Copyright &copy; 2014. Religare Health Insurance Co. Ltd., GYS Global, Plot No. A3, A4, A5, Sector - 125, Noida, U.P. - 201301<br />
Please visit our <a href="' . SITEURL . 'privacy.html" style="color:#cccccc;">Privacy policy</a> in case of any questions.</td>
  </tr>
</table>
</body>
</html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Religare Health Insurance <rhiclportaladmin@religarehealthinsurance.com>' . " \r\n";
    mail($saveandcontinueemail, $subject, $body1, $headers);
    
    $query['emailaddress1'] = sanitize_data_email($saveandcontinueemail);
    $query['firstname'] = sanitize_data($firstName);
    $query['lastname'] = sanitize_data($lastName);
    $query['rhi_proposalid'] = "";
    
   // saveContinueLeadCreation($query);
    $_SESSION['errorMSGE'] = "The proposal has been sent. We thank you for showing interest in Religare Health Insurance.";	
    header("LOCATION:".$producturl."?id=$policyId&code=".hash('sha256', "proposal-".$policyId));
    exit;
   // header("LOCATION:enhance.php?id=$policyId&code=".hash('sha256', "proposal-".$policyId));
   // exit;
}

function getXMLResponse1($data, $tagTitle, $fileName) {
   
    $soapaction = "";
    $headers = array(
        "Content-Type: text/xml;charset=\"utf-8\"",
        "SOAPAction: \"http://CrmService/WebService/Createlead\"",
        "Content-length: " . strlen($data),
        "Authorization: Basic Y2F0YWJhdGljdXNlcjp1c2VyQDEyMzQ1"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, LEADURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $xmlResponse1 = curl_exec($ch);
    $ch_info = curl_getinfo($ch);
    curl_close($ch);
    file_put_contents('data/en-semiproposal/' . time() . "_" . $tagTitle . "_request.xml", $data);
    file_put_contents('data/en-semiproposal/' . time() . "_" . $tagTitle . "_response.xml", $xmlResponse1);
   
    return $xmlResponse1;
}
function saveContinueMailJoy($titleCd, $firstName, $lastName, $saveandcontinueemail, $subject, $proposalTenourCode, $totalChildMember, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId, $productData,$query) {
    
    if ($titleCd != '' && $titleCd != '0') {
        $titleCd = ucfirst($titleCd);
    } else {
        $titleCd = '';
    }
    if ($firstName != '') {
        $firstName = ucfirst($firstName);
    } else {
        $firstName = '';
    }
    if ($lastName != '') {
        $lastName = ucfirst($lastName);
    } else {
        $lastName = '';
    }
    


    $body1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="' . PROPOSALSITEURL . 'images/top_banner.jpg" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#397628;"><strong>Go ahead and make a wise decision by choosing us!</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Dear  ' . $titleCd . ' <span style="color:#548dd4;">' . $firstName . ' ' . $lastName . ',</span></td>
      </tr>
      <tr>
        <td height="39" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">We thank you for your interest in Religare Health Insurance. We have saved your proposal information so that you can continue to
buy your policy, Here is a recap of the details provided by you - 
</td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="780" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Plan
              name</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . ucfirst(strtolower($productData)) . ',  ' . getRepeesVal($proposalDummySi) . ' </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Total
              members</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Children
              (less than 25 years)</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalChildMember . '</td>
          </tr>
          <tr>
            <td width="193" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Age
              of eldest member</td>
            <td width="20" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td width="567" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $proposalageGroupOfEldestMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Premium</strong></td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Rs. ' . $PREMIUM_AMOUNT . ',
                for ' . $proposalTenourCode . ' year(s)</strong> (inclusive of Taxes)</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td height="80" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Please  click here to <a href="' . PROPOSALSITEURL . 'joy.php?id=' . $policyId . '&code=' . hash('sha256', "proposal-$policyId") . '" style="color:#ff0600; font-weight:bold;"> Buy Now</a>  or Call <span style="color:#1c8400;font-weight: bold;">1800-200-4488 (Toll free)</span> for  any assistance in buying. </td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><br /><br />
          <br />Wishing you Health...Hamesha! <br /><br />
          
          Team Religare Health insurance.<br /><br /><br />
          
          
          Kindly ignore this mail if you have already bought. *Terms and Conditions apply. </td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="760" border="0" align="left" cellpadding="0" cellspacing="0" style="border-top:1px solid #000000; border-bottom:1px solid #999999;">
     
      <tr>
        <td width="250" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong style=" padding-left:15px;">About Us</strong><br />
          <a href="' . SITEURL . '?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333; padding-left:15px;">Religare Health Insurance</a><br />
          <a href="http://www.religare.com/" style="color:#333333; padding-left:15px;">Religare Enterprises Ltd.</a><br />
          <a href="' . SITEURL . 'buy-maternity-health-insurance-plan.html" style="color:#333333; padding-left:15px;">Joy - Comprehensive Health Insurance</a></td>
        <td width="52" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="215" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Reach Us</strong><br />
          <span style=" font-weight: bold;">Call us 1800-200-4488</span><br />
          <a href="mailto:customerfirst@religarehealthinsurance.com" style="color:#333333;">E-mail us</a><br />
          <a href="' . SITEURL . 'health-insurance-branch-locator.html?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Nearest Branch</a></td>
        <td width="45" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="198" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Customer First</strong><br />
        <a href="' . SITEURL . 'religare-customer-support.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Customer Service</a><br />
          <a href="' . SITEURL . 'health-plan-network-hospitals.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Network Hospitals</a><br />
          <a href="' . SITEURL . 'health-bmi-calculator.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Health Calculator</a></td>
      </tr>
       <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr valign="middle">
    <td height="70" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#cccccc;">You are receiving this mail as you requested a premium quote from our website.<br />
Insurance is a subject matter of solicitation. IRDA Registration Number - 148<br />
Copyright &copy; 2014. Religare Health Insurance Co. Ltd., GYS Global, Plot No. A3, A4, A5, Sector - 125, Noida, U.P. - 201301<br />
Please visit our <a href="' . SITEURL . 'privacy.html" style="color:#cccccc;">Privacy policy</a> in case of any questions.</td>
  </tr>
</table>
</body>
</html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Religare Health Insurance <rhiclportaladmin@religarehealthinsurance.com>' . " \r\n";
    mail($saveandcontinueemail, $subject, $body1, $headers);
    
    $query['emailaddress1'] = sanitize_data_email($saveandcontinueemail);
    $query['firstname'] = sanitize_data($firstName);
    $query['lastname'] = sanitize_data($lastName);
    $query['rhi_proposalid'] = "";
    
    //saveContinueLeadCreation($query);
    $_SESSION['errorMSGE'] = "The proposal has been sent. We thank you for showing interest in Religare Health Insurance.";
    header("LOCATION:joy.php?id=$policyId&code=".hash('sha256', "proposal-".$policyId));
    exit;
}
function saveContinueMailAssure($titleCd, $firstName, $lastName, $saveandcontinueemail, $subject, $proposalTenourCode, $totalChildMember, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId, $productData,$query) {
    
    if ($titleCd != '' && $titleCd != '0') {
        $titleCd = ucfirst($titleCd);
    } else {
        $titleCd = '';
    }
    if ($firstName != '') {
        $firstName = ucfirst($firstName);
    } else {
        $firstName = '';
    }
    if ($lastName != '') {
        $lastName = ucfirst($lastName);
    } else {
        $lastName = '';
    }
    


    $body1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="' . PROPOSALSITEURL . 'images/top_banner.jpg" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#397628;"><strong>Go ahead and make a wise decision by choosing us!</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Dear  ' . $titleCd . ' <span style="color:#548dd4;">' . $firstName . ' ' . $lastName . ',</span></td>
      </tr>
      <tr>
        <td height="39" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">We thank you for your interest in Religare Health Insurance. We have saved your proposal information so that you can continue to
buy your policy, Here is a recap of the details provided by you - 
</td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="780" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Plan
              name</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . ucfirst(strtolower($productData)) . ',  ' . getRepeesVal($proposalDummySi) . ' </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Total
              members</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Children
              (less than 25 years)</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalChildMember . '</td>
          </tr>
          <tr>
            <td width="193" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Age
              of eldest member</td>
            <td width="20" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td width="567" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $proposalageGroupOfEldestMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Premium</strong></td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Rs. ' . $PREMIUM_AMOUNT . ',
                for ' . $proposalTenourCode . ' year(s)</strong> (inclusive of Taxes)</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td height="80" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Please  click here to <a href="' . PROPOSALSITEURL . 'assure.php?id=' . $policyId . '&code=' . hash('sha256', "proposal-$policyId") . '" style="color:#ff0600; font-weight:bold;"> Buy Now</a>  or Call <span style="color:#1c8400;font-weight: bold;">1800-200-4488 (Toll free)</span> for  any assistance in buying. </td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><br /><br />
          <br />Wishing you Health...Hamesha! <br /><br />
          
          Team Religare Health insurance.<br /><br /><br />
          
          
          Kindly ignore this mail if you have already bought. *Terms and Conditions apply. </td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="760" border="0" align="left" cellpadding="0" cellspacing="0" style="border-top:1px solid #000000; border-bottom:1px solid #999999;">
     
      <tr>
        <td width="250" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong style=" padding-left:15px;">About Us</strong><br />
          <a href="' . SITEURL . '?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333; padding-left:15px;">Religare Health Insurance</a><br />
          <a href="http://www.religare.com/" style="color:#333333; padding-left:15px;">Religare Enterprises Ltd.</a><br />
          <a href="' . SITEURL . 'buy-critical-illness-insurance-policy.html" style="color:#333333; padding-left:15px;">Assure - Comprehensive Health Insurance</a></td>
        <td width="52" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="215" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Reach Us</strong><br />
          <span style=" font-weight: bold;">Call us 1800-200-4488</span><br />
          <a href="mailto:customerfirst@religarehealthinsurance.com" style="color:#333333;">E-mail us</a><br />
          <a href="' . SITEURL . 'health-insurance-branch-locator.html?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Nearest Branch</a></td>
        <td width="45" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="198" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Customer First</strong><br />
        <a href="' . SITEURL . 'religare-customer-support.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Customer Service</a><br />
          <a href="' . SITEURL . 'health-plan-network-hospitals.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Network Hospitals</a><br />
          <a href="' . SITEURL . 'health-bmi-calculator.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Health Calculator</a></td>
      </tr>
       <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr valign="middle">
    <td height="70" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#cccccc;">You are receiving this mail as you requested a premium quote from our website.<br />
Insurance is a subject matter of solicitation. IRDA Registration Number - 148<br />
Copyright &copy; 2014. Religare Health Insurance Co. Ltd., GYS Global, Plot No. A3, A4, A5, Sector - 125, Noida, U.P. - 201301<br />
Please visit our <a href="' . SITEURL . 'privacy.html" style="color:#cccccc;">Privacy policy</a> in case of any questions.</td>
  </tr>
</table>
</body>
</html>';
    
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Religare Health Insurance <rhiclportaladmin@religarehealthinsurance.com>' . " \r\n";
    mail($saveandcontinueemail, $subject, $body1, $headers);
    
    $query['emailaddress1'] = sanitize_data_email($saveandcontinueemail);
    $query['firstname'] = sanitize_data($firstName);
    $query['lastname'] = sanitize_data($lastName);
    $query['rhi_proposalid'] = "";
    
    //saveContinueLeadCreation($query);
    $_SESSION['errorMSGE'] = "The proposal has been sent. We thank you for showing interest in Religare Health Insurance.";
    header("LOCATION:assure.php?id=$policyId&code=".hash('sha256', "proposal-".$policyId));
    exit;
}
function saveContinueMailSecure5($titleCd, $firstName, $lastName, $saveandcontinueemail, $subject, $proposalTenourCode, $totalChildMember, $totalMember, $proposalageGroupOfEldestMember, $PREMIUM_AMOUNT, $proposalDummySi, $policyId, $productData,$query) {
    
    if ($titleCd != '' && $titleCd != '0') {
        $titleCd = ucfirst($titleCd);
    } else {
        $titleCd = '';
    }
    if ($firstName != '') {
        $firstName = ucfirst($firstName);
    } else {
        $firstName = '';
    }
    if ($lastName != '') {
        $lastName = ucfirst($lastName);
    } else {
        $lastName = '';
    }
    


    $body1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><img src="' . PROPOSALSITEURL . 'images/top_banner.jpg" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#397628;"><strong>Go ahead and make a wise decision by choosing us!</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Dear  ' . $titleCd . ' <span style="color:#548dd4;">' . $firstName . ' ' . $lastName . ',</span></td>
      </tr>
      <tr>
        <td height="39" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">We thank you for your interest in Religare Health Insurance. We have saved your proposal information so that you can continue to
buy your policy, Here is a recap of the details provided by you - 
</td>
      </tr>
      <tr>
        <td align="left" valign="top"><table width="780" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Plan
              name</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . ucfirst(strtolower($productData)) . ',  ' . getRepeesVal($proposalDummySi) . ' </td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Total
              members</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Children
              (less than 25 years)</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $totalChildMember . '</td>
          </tr>
          <tr>
            <td width="193" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Age
              of eldest member</td>
            <td width="20" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td width="567" height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">' . $proposalageGroupOfEldestMember . '</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Premium</strong></td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">:</td>
            <td height="30" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Rs. ' . $PREMIUM_AMOUNT . ',
                for ' . $proposalTenourCode . ' year(s)</strong> (inclusive of Taxes)</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td height="80" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">Please  click here to <a href="' . PROPOSALSITEURL . 'secure5.php?id=' . $policyId . '&code=' . hash('sha256', "proposal-$policyId") . '" style="color:#ff0600; font-weight:bold;"> Buy Now</a>  or Call <span style="color:#1c8400;font-weight: bold;">1800-200-4488 (Toll free)</span> for  any assistance in buying. </td>
      </tr>
      <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><br /><br />
          <br />Wishing you Health...Hamesha! <br /><br />
          
          Team Religare Health insurance.<br /><br /><br />
          
          
          Kindly ignore this mail if you have already bought. *Terms and Conditions apply. </td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="760" border="0" align="left" cellpadding="0" cellspacing="0" style="border-top:1px solid #000000; border-bottom:1px solid #999999;">
     
      <tr>
        <td width="250" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong style=" padding-left:15px;">About Us</strong><br />
          <a href="' . SITEURL . '?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333; padding-left:15px;">Religare Health Insurance</a><br />
          <a href="http://www.religare.com/" style="color:#333333; padding-left:15px;">Religare Enterprises Ltd.</a><br />
          <a href="' . SITEURL . 'buy-critical-illness-insurance-policy.html" style="color:#333333; padding-left:15px;">Assure - Comprehensive Health Insurance</a></td>
        <td width="52" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="215" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Reach Us</strong><br />
          <span style=" font-weight: bold;">Call us 1800-200-4488</span><br />
          <a href="mailto:customerfirst@religarehealthinsurance.com" style="color:#333333;">E-mail us</a><br />
          <a href="' . SITEURL . 'health-insurance-branch-locator.html?utm_source=save-proposal&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Nearest Branch</a></td>
        <td width="45" align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td width="198" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;"><strong>Customer First</strong><br />
        <a href="' . SITEURL . 'religare-customer-support.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Customer Service</a><br />
          <a href="' . SITEURL . 'health-plan-network-hospitals.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Network Hospitals</a><br />
          <a href="' . SITEURL . 'health-bmi-calculator.html?utm_source=save-proposa&utm_medium=edm&utm_term=footer-link&utm_campaign=save-proposal" style="color:#333333;">Health Calculator</a></td>
      </tr>
       <tr>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
        <td align="left" valign="middle" style="border-left:1px solid #999999;">&nbsp;</td>
        <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333333;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr valign="middle">
    <td height="70" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#cccccc;">You are receiving this mail as you requested a premium quote from our website.<br />
Insurance is a subject matter of solicitation. IRDA Registration Number - 148<br />
Copyright &copy; 2014. Religare Health Insurance Co. Ltd., GYS Global, Plot No. A3, A4, A5, Sector - 125, Noida, U.P. - 201301<br />
Please visit our <a href="' . SITEURL . 'privacy.html" style="color:#cccccc;">Privacy policy</a> in case of any questions.</td>
  </tr>
</table>
</body>
</html>';
    
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Religare Health Insurance <rhiclportaladmin@religarehealthinsurance.com>' . " \r\n";
    mail($saveandcontinueemail, $subject, $body1, $headers);
    
    $query['emailaddress1'] = sanitize_data_email($saveandcontinueemail);
    $query['firstname'] = sanitize_data($firstName);
    $query['lastname'] = sanitize_data($lastName);
    $query['rhi_proposalid'] = "";
    
    //saveContinueLeadCreation($query);
    $_SESSION['errorMSGE'] = "The proposal has been sent. We thank you for showing interest in Religare Health Insurance.";
    header("LOCATION:secure5.php?id=$policyId&code=".hash('sha256', "proposal-".$policyId));
    exit;
}
function saveContinueLeadCreation($query) {
    foreach ($query as $key => $value) {
        $$key = $value;
    }
    $xml_data =
            "<SOAP:Envelope xmlns:SOAP=\"http://schemas.xmlsoap.org/soap/envelope/\">
            <SOAP:Body>
            <Createlead xmlns=\"http://CrmService/WebService\">
            <Lead>
            <leadsourcecode>Web</leadsourcecode>
            <subject>".@$leadstage."</subject>
            <firstname>".@$firstname."</firstname>
            <lastname>".@$lastname."</lastname>
            <emailaddress1>".@$emailaddress1."</emailaddress1>
            <telephone1 />
            <mobilephone>".@$mobilephone."</mobilephone>
            <rhi_plan />
            <rhi_product>".@$rhiproduct."</rhi_product>
            <rhi_suminsured>".@$rhi_suminsured."</rhi_suminsured>
            <rhi_premium>".@$rhi_premium."</rhi_premium>
            <rhi_quoteid />	  
            <rhi_proposalid>".@$rhi_proposalid."</rhi_proposalid>
            <rhi_leadstage>".$leadstage."</rhi_leadstage>
            <rhi_agentid>".$agentid."</rhi_agentid>
            <rhi_noofyears>".$rhi_noofyears."</rhi_noofyears>
            </Lead>
            <OrganizationName>Rhicl</OrganizationName>
            </Createlead>
            </SOAP:Body>
            </SOAP:Envelope>";
    $fileName = 'Confusion_Enquiry_' . time();
    $dataArr = getXMLResponse1($xml_data, 'LEADCREATION', $fileName);
    return $dataArr;
}
function getRepeesVal($number){ 
$number = str_replace(',', '', $number);
 if($number >= 100000)
{
    $num = ((float)$number) / 100000;
    $num = $num.' Lac(s)';
}
return $num;
}
$questionIDArrayJoy = array(
    "205" => array("qSetId" => "PEDdiabetesDetails", "yearQId" => "diabetesExistingSince"),
    "207" => array("qSetId" => "hypertensionHigh", "yearQId" => "cancerExistingSince"),
    '147' => array("qSetId" => "PEDHivaidsDetails", "yearQId" => "hivaidsExistingSince"),
    "232" => array("qSetId" => "PEDliverDetails", "yearQId" => "liverExistingSince"),
    "114" => array("qSetId" => "cancerTumor", "yearQId" => "cancerExistingSince"),
    "143" => array("qSetId" => "heartDisease", "yearQId" => "cancerExistingSince"),
    "105" => array("qSetId" => "arthritisJoint", "yearQId" => "cancerExistingSince"),
    "129" => array("qSetId" => "kidneyDisease", "yearQId" => "cancerExistingSince"),
    "164" => array("qSetId" => "paralysisStroke", "yearQId" => "cancerExistingSince"),
    "122" => array("qSetId" => "congenitalDisease", "yearQId" => "cancerExistingSince"),
    "210" => array("qSetId" => "PEDotherDetails", "yearQId" => "otherExistingSince"),
    "1" => array("qSetId" => "PEDdiabetesDetails", "yearQId" => "diabetesExistingSince")
);
function fetchListCond($table,$cond){
	$conn = dbConnect();
	$dataArray=array();
		$query="SELECT * FROM $table $cond";
		$sql = @oci_parse($conn, $query);
		// Execute Query
		@oci_execute($sql);
		$i=0;
		while (($row = oci_fetch_array($sql))) {
			foreach($row as $key=>$value){
				$dataArray[$i][$key] = $value;				
			}
			$i++;
		}
	return $dataArray;
}
?>