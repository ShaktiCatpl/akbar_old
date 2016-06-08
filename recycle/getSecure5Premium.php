<?php
/*include_once("conf/conf.php");
include_once("conf/fucts.php");*/
function sanitize_data($input_data) {
	$searchArr=array("document","write","alert","%","@","$",";","+","|","#","<",">",")","(","'","\'",",");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
$suminsuredAmount	=	sanitize_data(@$_POST['sumInsuredSecure']);
$secureTenure		=	sanitize_data(@$_POST['tenure']);
$discountingarray		=	array();
$discountingarray[1]	=	'0';
$discountingarray[2]	=	'0.075';
$discountingarray[3]	=	'0.1';

if($suminsuredAmount>=100000 && $suminsuredAmount<=1000000) {
	$sival		=	$suminsuredAmount/100000;
	$sipremium	=	$sival*92;
}
if($suminsuredAmount>=1000001 && $suminsuredAmount<=1500000) {
	$sival		=	$suminsuredAmount/100000;
	$sipremium	=	$sival*92;
}
if($suminsuredAmount>=1500001 && $suminsuredAmount<=2000000) {
	$sival		=	$suminsuredAmount/100000;
	$sipremium	=	$sival*92;
}
if($suminsuredAmount>=2000001 && $suminsuredAmount<=2500000) {
	$sival		=	$suminsuredAmount/100000;
	$sipremium	=	$sival*92;
}
if($suminsuredAmount>=2500001 && $suminsuredAmount<=3000000) {
	$sival		=	$suminsuredAmount/100000;
	$sipremium	=	$sival*92;
}
if($sipremium=='') {
	echo "Please modify your search|Please modify your search";
}	else {
	$discountingFactor = $discountingarray[@$secureTenure];
	$discountingFactorMultiple = 1-@$discountingFactor;
	//Premium	= ((SI/100000)*Premium for 1 year * Policy Tenure * (1-Discounting factor))*1.1236
	//	Premium= ((SI/100000)*Premium for 1 year * Policy Tenure * (1-Discounting factor))*1.1236
	//	Premium= (((SI/100000)*Premium for 1 year * Policy Tenure * (1-Discounting factor))+976)*1.1236	
	//	Premium= ((((SI/100000)*Premium for 1 year )+976)* Policy Tenure * (1-Discounting factor))*1.1236
	//echo 	$sival.'-'.$sipremium.'-'.$secureTenure.'-'.$discountingFactorMultiple;
	//die();
	$totalAmount                            =	$sipremium*$secureTenure*$discountingFactorMultiple;
	$totalAmountWithServiceTax		=	round(@$totalAmount*1.1236,0);// Premium including Service tax	
	$totalAmountBenefits			=	($sipremium +976)*$secureTenure*$discountingFactorMultiple;
	$totalAmountBenefitsWithServiceTax	=	round(@$totalAmountBenefits*1.1236,0);// Premium including Service tax
	echo number_format(trim($totalAmountWithServiceTax)).'|'.number_format(trim($totalAmountBenefitsWithServiceTax));
}
?>
