<?php
error_reporting(0);
function sanitize_data($input_data) {
    $searchArr = array("document", "write", "alert", "%", "@", "$", ";", "+", "|", "#", "<", ">", ")", "(", "'", "\'", ",");
    $input_data = str_replace("script", "", $input_data);
    $input_data = str_replace("iframe", "", $input_data);
    $input_data = str_replace($searchArr, "", $input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function csvToArray($csvFileName) {
    $row = 1;
    $dataArray = array();
    $columnArray = array();
    $k = 0;
    $i = 0;
    if (($handle = fopen($csvFileName, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
            $num = count($data);
            if ($k == 0) {
                for ($c = 0; $c < $num; $c++) {
                    $columnArray[$c] = @$data[$c];
                }
            } else {
                for ($c = 0; $c < $num; $c++) {
                    $columnName = $columnArray[$c];
                    $dataArray[$i][$columnName] = @$data[$c];
                }
                $i++;
            }
            $k++;
            $row++;
        }
        fclose($handle);
    }
    return $dataArray;
}

function search($array, $key, $value) {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search($subarray, $key, $value));
    }

    return $results;
}

$INDIVIDUAL = array(
    "200000" => "001",
    "300000" => "003",
    "400000" => "005",
    "500000" => "007",
    "700000" => "009",
    "1000000" => "011",
    "1500000" => "013",
    "2000000" => "015",
    "2500000" => "017",
    "5000000" => "019",
    "6000000" => "021"
);
$FAMILYFLOATER = array(
    "200000" => "002",
    "300000" => "004",
    "400000" => "006",
    "500000" => "008",
    "700000" => "010",
    "1000000" => "012",
    "1500000" => "014",
    "2000000" => "016",
    "2500000" => "018",
    "5000000" => "020",
    "6000000" => "022"
);

$totalMB = (sanitize_data(@$_REQUEST['numberOfAdult']) + sanitize_data(@$_REQUEST['numberOfChildren']));
$query['ageGroupOfEldestMember'] = @$_REQUEST['ageGroupOfEldestMember'];
$query['coverTypeCd'] = sanitize_data(@$_REQUEST['coverTypeCd']);
$query['productId'] = @$productId1;
$query['productTerm'] = sanitize_data(@$_REQUEST['productTerm']);
$query['sumInsured'] = sanitize_data(@$_REQUEST['sumInsured']);
$query['tenure'] = sanitize_data(@$_REQUEST['tenure']);
if (sanitize_data(@$_REQUEST['coverTypeCd']) == "INDIVIDUAL") {
    $sumInsured = sanitize_data(@$_REQUEST['sumInsured']);
    if (@$sumInsured > 0) {
        $sumInsured1 = $INDIVIDUAL[@$sumInsured];
    }
    $query['numberOfAdult'] = 1;
    $query['numberOfChildren'] = 0;
    $totalMem = sanitize_data(@$_REQUEST['numberOfAdult']) + sanitize_data(@$_REQUEST['numberOfChildren']);
} else {
    $sumInsured = sanitize_data(@$_REQUEST['sumInsured']);
    if (@$sumInsured > 0) {
        $sumInsured1 = $FAMILYFLOATER[@$sumInsured];
    }
    $query['numberOfAdult'] = sanitize_data(@$_REQUEST['numberOfAdult']);
    $query['numberOfChildren'] = sanitize_data(@$_REQUEST['numberOfChildren']);
}
$query['sumInsured1'] = @$sumInsured1;

$_SESSION['ageGroupOfEldestMember'] = @$query['ageGroupOfEldestMember']; // assign value to session for product tab
$_SESSION['coverTypeCd'] = @$query['coverTypeCd']; // assign value to session for product tab
$_SESSION['numberOfAdult'] = @$query['numberOfAdult'] + $query['numberOfChildren']; // assign value to session for product tab
$_SESSION['numberOfChildren'] = @$query['numberOfChildren']; // assign value to session for product tab
$_SESSION['sumInsured'] = @$sumInsured; // assign value to session for product tab

$carePremium = 0;
$totalPremier = 0;
if ($query['coverTypeCd'] == 'INDIVIDUAL') {

    $dept = explode(',', $query['ageGroupOfEldestMember']);

    //  echo '<pre>';print_r($dept);exit;

    for ($ip = 0; $ip < $totalMem; $ip++) {
        $premiumArray = csvToArray('care_premium_agent.csv');
        $totalMember = $query['numberOfAdult'] + $query['numberOfChildren'];
        $planKey = $query['coverTypeCd'] . ":" . $dept[$ip] . ":" . @$totalMember . ":" . $query['numberOfChildren'] . ":" . $query['sumInsured1'];
        $exactPremiumArray = search(@$premiumArray, 'Plan', @$planKey);
        $exactCarePremiumArray = explode(":", $exactPremiumArray[0]['Premium']);
        $tenureidx = $_REQUEST['tenure'] - 1;
        $carePremiumTest = $exactCarePremiumArray[@$tenureidx];
        $addCarePremium = str_replace(',', '', @$carePremiumTest);
        $carePremium +=$addCarePremium;
        //print_r($exactCarePremiumArray);

        $ncppremiumArray = csvToArray('ncb_premium_agent.csv');
        $ncbtotalMember = $query['numberOfAdult'] + $query['numberOfChildren'];
        $ncbplanKey = $query['coverTypeCd'] . ":" . $dept[$ip] . ":" . @$ncbtotalMember . ":" . $query['numberOfChildren'] . ":" . $query['sumInsured1'];
        $ncbexactPremiumArray = search(@$ncppremiumArray, 'Plan', @$ncbplanKey);
//        echo '<pre>';
//        print_r($ncbexactPremiumArray);
//        exit;
        $exactNCBPremiumArray = explode(":", $ncbexactPremiumArray[0]['Premium']);
        //$tenureidx = $_REQUEST['tenure']-1;
        $ncbPremium = $exactNCBPremiumArray[@$tenureidx];

        $addNCBPremium = str_replace(',', '', @$ncbPremium);
        //$totalPremier+= $addNCBPremium+$addCarePremium;
        $totalPremier+= $addNCBPremium;
    }
} else {

    $premiumArray = csvToArray('care_premium_agent.csv');
    $totalMember = $query['numberOfAdult'] + $query['numberOfChildren'];
    $planKey = $query['coverTypeCd'] . ":" . $query['ageGroupOfEldestMember'] . ":" . @$totalMember . ":" . $query['numberOfChildren'] . ":" . $query['sumInsured1'];
    $exactPremiumArray = search(@$premiumArray, 'Plan', @$planKey);
    $exactCarePremiumArray = explode(":", $exactPremiumArray[0]['Premium']);
    $tenureidx = $_REQUEST['tenure'] - 1;
    $carePremium = $exactCarePremiumArray[@$tenureidx];
    //print_r($exactCarePremiumArray);
    $carePremium = str_replace(',', '', $carePremium);
    $ncppremiumArray = csvToArray('ncb_premium_agent.csv');
    $ncbtotalMember = $query['numberOfAdult'] + $query['numberOfChildren'];
    $ncbplanKey = $query['coverTypeCd'] . ":" . $query['ageGroupOfEldestMember'] . ":" . @$ncbtotalMember . ":" . $query['numberOfChildren'] . ":" . $query['sumInsured1'];
    $ncbexactPremiumArray = search(@$ncppremiumArray, 'Plan', @$ncbplanKey);
    $exactNCBPremiumArray = explode(":", $ncbexactPremiumArray[0]['Premium']);
    //$tenureidx = $_REQUEST['tenure']-1;
    $ncbPremium = $exactNCBPremiumArray[@$tenureidx];
    //$addCarePremium = str_replace(',','',@$carePremium);
    $addNCBPremium = str_replace(',', '', @$ncbPremium);
    //$totalPremier = $addNCBPremium+$carePremium;
    $totalPremier = $addNCBPremium;
}
//print_r($exactNCBPremiumArray);


if ($totalMB == 1 || $query['coverTypeCd'] == 'FAMILYFLOATER') {
    // echo $carePremium;
    @$carePremium = number_format(@$carePremium);
    $finalNcbPremium = number_format($totalPremier);
    echo trim(@$carePremium) . ':' . trim(@$finalNcbPremium);
} else if (($totalMB == 2) || ($totalMB == 3)) {
    // echo "jkdfhgjkdf";
    @$finalNcbPremium1CAL = @$carePremium - (@$carePremium * .05);
    @$finalNcbPremium2CAL = @$totalPremier - (@$totalPremier * .05);
    //  @$finalNcbPremium2CAL = (@$totalPremier -  (@$totalPremier*.05))."+".@$totalPremier;
    @$finalNcbPremium1CAL = number_format(@$finalNcbPremium1CAL);
    @$finalNcbPremium2CAL = number_format(@$finalNcbPremium2CAL);
    echo trim(@$finalNcbPremium1CAL) . ':' . trim(@$finalNcbPremium2CAL);
} else if ($totalMB > 3) {
    @$finalNcbPremium1CAL = @$carePremium - (@$carePremium * .1);
    @$finalNcbPremium2CAL = @$totalPremier - (@$totalPremier * .1);
    @$finalNcbPremium1CAL = number_format(@$finalNcbPremium1CAL);
    @$finalNcbPremium2CAL = number_format(@$finalNcbPremium2CAL);
    echo trim(@$finalNcbPremium1CAL) . ':' . trim(@$finalNcbPremium2CAL);
} else {
    
}
?>