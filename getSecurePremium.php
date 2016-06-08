<?php
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
function csvToArray($csvFileName){
			$row = 1;
			$dataArray=array();
			$columnArray=array();
			$k=0;
			$i=0;
			if (($handle = fopen($csvFileName, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
					$num = count($data);
					if($k==0){
						 for ($c=0; $c < $num; $c++) {
							$columnArray[$c]=@$data[$c];
						}
					}else{	
						 for ($c=0; $c < $num; $c++) {
							$columnName=$columnArray[$c];
							$dataArray[$i][$columnName]=@$data[$c];
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
        function search($array, $key, $value){
	$results = array();

	if (is_array($array))
	{
		if (isset($array[$key]) && $array[$key] == $value)
			$results[] = $array;

		foreach ($array as $subarray)
			$results = array_merge($results, search($subarray, $key, $value));
	}

	return $results;
}
$query['sumInsuredSecure']=sanitize_data(@$_REQUEST['sumInsuredSecure']);
$query['sI']='';
$query['queryPlanOption'] = '';
switch($query['sumInsuredSecure']){
    case '1000000':{
        $query['sI'] = '10 Lac';
        $query['queryPlanOption'] = '001';
        break;
    }
     case '1500000':{
        $query['sI'] = '15 Lac';
        $query['queryPlanOption'] = '001';
        break;
    }
     case '2000000':{
        $query['sI'] = '20 Lac';
        $query['queryPlanOption'] = '002';
        break;
    }
     case '2500000':{
         $query['sI'] = '25 Lac';
         $query['queryPlanOption'] = '003';
         break;
    }
     case '3000000':{
         $query['sI'] = '30 Lac';
         $query['queryPlanOption'] = '004';
         break;
    }
     case '5000000':{
         $query['sI'] = '50 Lac';
         $query['queryPlanOption'] = '001';
         break;
    }
     case '10000000':{
         $query['sI'] = '1 Crore';
         $query['queryPlanOption'] = '002';
         break;
    }
     case '20000000':{
         $query['sI'] = '2 Crore';
         $query['queryPlanOption'] = '003';
         break;
    }
     case '30000000':{
         $query['sI'] = '3 Crore';
         $query['queryPlanOption'] = '004';
         break;
    }
    
}
$query['tenure']=sanitize_data(@$_REQUEST['tenure']);
$premiumArray=csvToArray('cr_abacus_secure.csv');
$planKey=$query['queryPlanOption'].':'.$query['tenure'].':'.$query['sI'];
$exactPremiumArray=search(@$premiumArray,'Plan',@$planKey);
$exactCarePremiumArray=explode(":",$exactPremiumArray[0]['Premium']);
echo $exactCarePremiumArray[0].'|'.$exactCarePremiumArray[1];
?>
