<?php
function birthday($birthday){ 
    $age = strtotime($birthday);    
    if($age === false){ 
        return false; 
    }     
    list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));     
    $now = strtotime("now");     
    list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));     
    $age = $y2 - $y1;     
    if((int)($m2.$d2) < (int)($m1.$d1)) 
        $age -= 1;         
    return $age; 
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
function sanitize_data($input_data) {
	$searchArr=array("document","write","alert","%","@","$",";","+","|","#","<",">",")","(","'","\'",",");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
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

  $assureSI = array(
	"500000" 	=> "005",
	"1000000" 	=> "010",
	"1500000" 	=> "011",
	"2000000" 	=> "012",
	"3000000" 	=> "014",
	"5000000" 	=> "018",
	"7500000" 	=> "022",
	"10000000" 	=> "023"	
	);
	/*$age		=	sanitize_data(@$_REQUEST['ageGroupOfEldestMember']);
	$agearray	=	explode("/",$age);
	$yyyy		=	$agearray[2];
	$mm			=	$agearray[1];
	$dd			=	$agearray[0];
	$ageyear	=	birthday($yyyy.'-'.$mm.'-'.$dd); 
	$ageGroupOfEldestMember	=	'';
	if($ageyear>=18 && $ageyear<=25) {
   		$ageGroupOfEldestMember	=	'18 - 25';
	}
	if($ageyear>=26 && $ageyear<=30) {
   		$ageGroupOfEldestMember	=	'26 - 30';
	}
	if($ageyear>=31 && $ageyear<=35) {
   		$ageGroupOfEldestMember	=	'31 - 35';
	}
	if($ageyear>=36 && $ageyear<=40) {
   		$ageGroupOfEldestMember	=	'36 - 40';
	}
	if($ageyear>=41 && $ageyear<=45) {
   		$ageGroupOfEldestMember	=	'41 - 45';
	}
	if($ageyear>=46 && $ageyear<=50) {
   		$ageGroupOfEldestMember	=	'46 - 50';
	}
	if($ageyear>=51 && $ageyear<=55) {
   		$ageGroupOfEldestMember	=	'51 - 55';
	}
	if($ageyear>=56 && $ageyear<=60) {
   		$ageGroupOfEldestMember	=	'56 - 60';
	}
	if($ageyear>=61 && $ageyear<=65) {
   		$ageGroupOfEldestMember	=	'61 - 65';
	}
	if($ageGroupOfEldestMember==''){
		echo 'ageerror';
		exit;
	} */	
    $sumInsuredCode = $assureSI[@sanitize_data(@$_REQUEST['sumInsured'])];
    //echo $sumInsuredCode; die;    
    $query['ageGroupOfEldestMember'] =	sanitize_data(@$_REQUEST['ageGroupOfEldestMember']);
    $query['coverTypeCd'] = "INDIVIDUAL";
    $query['productId'] = "20001004";
    $totalMember = 1;
    //$query['sumInsured'] = sanitize_data(@$_REQUEST['sumInsured']);
    $query['sumInsured'] = $sumInsuredCode;
    $query['tenure'] = sanitize_data(@$_REQUEST['tenure']);
    $query['numberOfChildren'] = 0;
    //print_r($query); die;
    $premiumArray = csvToArray('assure_premium.csv');
    $planKey = $query['coverTypeCd'] . ":" . $query['ageGroupOfEldestMember'] . ":" . @$totalMember . ":" . $query['numberOfChildren'] . ":" . $query['sumInsured'];
    $exactPremiumArray = search($premiumArray, 'Plan', $planKey);
    $exactCarePremiumArray = @explode(":", $exactPremiumArray[0]['Premium']);
    
  
    
    $tenureidx = $query['tenure']-1;
    $sumInsured_val = moneyFormatIndia(@$_REQUEST['sumInsured']);
    $exactCarePremiumnew = trim(str_replace(',', '', @$exactCarePremiumArray[@$tenureidx]));
    $exactCarePremium=moneyFormatIndia($exactCarePremiumnew);
    echo $carePremium = $exactCarePremium.':'.$sumInsured_val.':'.$query['sumInsured'].':'.$query['ageGroupOfEldestMember'];
    //die;
?>