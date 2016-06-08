<?php
include_once("inc/travelConf.php");

dbConnectMysql();
function sanitize_data($input_data) {
    $searchArr = array("document", "write", "alert", "%", "@", "$", ";", "+", "|", "#", "<", ">", ")", "(", "'", "\'", ",");
    $input_data = str_replace("script", "", $input_data);
    $input_data = str_replace("iframe", "", $input_data);
    $input_data = str_replace($searchArr, "", $input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
function servicesTax($pre){
    return round(trim(sanitize_data($pre)) * 1.014596); 
}


function sanitize_data_travel($input_data) {
	$searchArr=array("document","write","alert","%",";","+","|","#","<",">",")","(","'","\'");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

                $travellingTo=@$_POST['travellingTo'];
		$tripType=sanitize_data(@$_POST['tripType']);
		$coverType=sanitize_data(@$_POST['coverType']);
		$noOfTravellers=sanitize_data(@$_POST['noOfTravellers']);
                $maximumtripduration = sanitize_data(@$_POST['maximumtripduration']);
                $sumInsured=sanitize_data_travel(@$_POST['sumInsured']);
		$startDate=sanitize_data(@$_POST['startDate']);
		$endDate=sanitize_data(@$_POST['endDate']);
		$ageBand=sanitize_data_travel(@$_POST['ageBand']);
		$ageBand1=explode(",",@$ageBand);
                
                
                if($tripType != 'Multi'){
		if($startDate!='Start Date' && $startDate!='End Date' ){
			$no_of_days=no_of_days($startDate,$endDate);
		}else{
			$no_of_days=0;
                } } else {
                    $no_of_days=$maximumtripduration;
                }
                if($no_of_days >180 || $no_of_days < 1){
                    $no_of_days = 2;
                }
                $panid = array();
		$premium="";
                $premium1="";
		if($noOfTravellers>0){
                    
                    $sqlId = mysql_query("SELECT distinct(td.id) from travelplandetails td left join travel t on td.id = t.planCode  where td.planId = '".@$travellingTo."' and tripType='".@$tripType."'");
                    while($rowid = mysql_fetch_array($sqlId)){
                        $panid[] = $rowid['id'];
                    }
                  
			if(@$coverType=="INDIVIDUAL"){
				$m=0;
				for($i=1;$i<=$noOfTravellers;$i++)	{
				 $ageRange=explode("-",$ageBand1[$m]);			
				 $minAge=$ageRange[0];
				 $maxAge=$ageRange[1];
                                 $sql = "SELECT premium from travel where planCode ='".@$panid[0]."' and  planType = '".@$travellingTo."' and tripType='".@$tripType."' and coverType='".@$coverType."'  and siCode='".@$sumInsured."' and minAge='".@$minAge."'  and maxAge='".@$maxAge."' and days='".$no_of_days."'   limit 1"; 
                                 $db = mysql_query($sql);
				 while($row = mysql_fetch_array($db)){
                                        $pR = str_replace(',','',@$row['premium']);
                                        $premium=$premium+($pR*1.014596);
					}
					$m++;
                                      
				}
                    
                                // echo number_format(@$premium);
                           if(count($panid) > 1){ 
                                $m1=0;
				for($i1=1;$i1<=$noOfTravellers;$i1++)	{
				 $ageRange=explode("-",$ageBand1[$m1]);			
				 $minAge=$ageRange[0];
				 $maxAge=$ageRange[1];
                                 $sql = "SELECT premium from travel where planCode ='".@$panid[1]."' and  planType = '".@$travellingTo."' and tripType='".@$tripType."' and coverType='".@$coverType."'  and siCode='".@$sumInsured."' and minAge='".@$minAge."'  and maxAge='".@$maxAge."' and days='".$no_of_days."'   limit 1"; 
				 $db = mysql_query($sql);
				 while($row = mysql_fetch_array($db)){
                                    $pR1 = str_replace(',','',@$row['premium']);
                                    $premium1=$premium1+($pR1*1.014596);
                                    }
					$m1++;
				} 
                            }   
                             
			}

		 }
       if(count($panid) > 1){
           switch ($noOfTravellers){
               case 2: {
                    $premiumDiscount = (@$premium-(@$premium*.05)); 
                    $premiumDiscount1 = (@$premium1-(@$premium1*.05)); 
                    break;
               } 
               case 3: {
                    $premiumDiscount = (@$premium-(@$premium*.1)); 
                    $premiumDiscount1 = (@$premium1-(@$premium1*.1)); 
                    break;
               }
               case 4: {
                    $premiumDiscount = (@$premium-(@$premium*.15)); 
                    $premiumDiscount1 = (@$premium1-(@$premium1*.15)); 
                    break;
               }
               case 5: {
                    $premiumDiscount = (@$premium-(@$premium*(.175)));
                    $premiumDiscount1 = (@$premium1-(@$premium1*(.175))); 
                    break;
               }
               case 6: {
                    $premiumDiscount = (@$premium-(@$premium*.2)); 
                    $premiumDiscount1 = (@$premium1-(@$premium1*.2)); 
                    break;
               }
               default :{
                    $premiumDiscount = @$premium;
                    $premiumDiscount1 = @$premium1;
                    break;
               }
           }
           
           
           //echo $premiumDiscount;
           echo @number_format(@$premiumDiscount,@$decimal=0).'|'.@number_format(@$premiumDiscount1,@$decimal=0); 
       } else {
           switch ($noOfTravellers){
               case 2: {
                    $premiumDiscount = (@$premium-(@$premium*.05)); 
                    break;
               } 
               case 3: {
                    $premiumDiscount = (@$premium-(@$premium*.1)); 
                    break;
               }
               case 4: {
                    $premiumDiscount = (@$premium-(@$premium*.15)); 
                    break;
               }
               case 5: {
                    $premiumDiscount = (@$premium-(@$premium*(.175))); 
                    break;
               }
               case 6: {
                    $premiumDiscount = (@$premium-(@$premium*.2)); 
                    break;
               }
               default :{
                    $premiumDiscount = @$premium;
                    break;
               }
           }
           
           
            echo @number_format(@$premiumDiscount,$decimal=0);
           //$_SESSION['travelpremium'] = number_format(@$premiumDiscount,$decimal=0);
           //echo $_SESSION['travelpremium'];
       }
?>
