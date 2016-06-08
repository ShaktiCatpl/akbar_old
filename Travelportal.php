<?php
//include_once("admin/conf/conf.php");
//include_once("admin/conf/fucts.php");
//$ageGroupOfEldestMemberArray = @$_POST['eachmember'];
//$noofTravellers = sanitize_data(@$_POST['noOfTravellers']);
//$enhancePortalProposal = "https://localhost/proposal/travel.php";
//$enhancePortalProposal = "https://buyuat.religare.com:7443/travel.php";



function no_of_days($startDate, $endDate) {
    $date1 = strtotime($endDate);
    $date2 = strtotime($startDate);
    $dateDiff = $date1 - $date2;
    $fullDays = floor($dateDiff / (60 * 60 * 24));
    return $fullDays + 1;
}

if (!empty($ageGroupOfEldestMemberArray)) {
    $finalArray = array_slice($ageGroupOfEldestMemberArray, 0, $noofTravellers);
    $ageGroupOfEldestMember = implode(',', $finalArray);
} else {
    header("Location: " . _SITEURL);
    exit;
}
$pedQuestion = sanitize_data(@$_POST['pedQuestion']);
if($pedQuestion == 'YES'){
    $pedQuestion = "YES";
} else {
    $pedQuestion = "NO";
}


$source = sanitize_data(@$_POST['source']);
$rmCode = sanitize_data(@$_REQUEST['rmCode']);
$branchCode = sanitize_data(@$_REQUEST['branchCode']);
$coverType = "INDIVIDUAL";
$travellingTo = sanitize_data(@$_POST['travellingTo']);
$tripTypeCd = sanitize_data(@$_POST['tripType']);
$goldplan = sanitize_data(@$_POST['goldplan']);
$tripStartDate = sanitize_data(@$_POST['startDate']);
$tripEndDate = sanitize_data(@$_POST['endDate']);
$mobileNumber = sanitize_data(@$_POST['mobilenotr']);
switch ($travellingTo) {
    case '1': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel70']);
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel1']);
            }
            $travelGeographyCd = '40001001';
            break;
        }
    case '2': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel70']);
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel1']);
            }
            $travelGeographyCd = '40001002';
            break;
        }
    case '3': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data("001");
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel3']);
            }
            $travelGeographyCd = '40001015';
            break;
        }
    case '4': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data("001");
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel4']);
            }
            $travelGeographyCd = '40001004';
            break;
        }
    case '5': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data("001");
            } else  if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                 $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel4']);
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel']);
            }
            if (($tripTypeCd == 'Single') && ($goldplan == 'gold')) {
                $travelGeographyCd = '40001011';
            } else if (($tripTypeCd == 'Single') && ($goldplan == 'platinum')) {
                $travelGeographyCd = '40001012';
            } else if (($tripTypeCd == 'Multi') && ($goldplan == 'gold')) {
                $travelGeographyCd = '40001007';
            } else if (($tripTypeCd == 'Multi') && ($goldplan == 'platinum')) {
                $travelGeographyCd = '40001008';
            }
            break;
        }
    case '6': {
            if (in_array("81-99", $finalArray)) {
                $sumInsured1 = sanitize_data("001");
            } else  if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                 $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel4']);
            } else {
                $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel']);
            }
            if (($tripTypeCd == 'Single') && ($goldplan == 'gold')) {
                $travelGeographyCd = '40001009';
            } else if (($tripTypeCd == 'Single') && ($goldplan == 'platinum')) {
                $travelGeographyCd = '40001010';
            } else if (($tripTypeCd == 'Multi') && ($goldplan == 'gold')) {
                $travelGeographyCd = '40001005';
            } else if (($tripTypeCd == 'Multi') && ($goldplan == 'platinum')) {
                $travelGeographyCd = '40001006';
            }
            break;
        }
    default : {
            header("Location: " . _SITEURL);
            exit;
            break;
        }
}
$productFamily = 'TRAVEL';
$quotationReferenceNum = time();
switch ($tripTypeCd) {
    case 'Multi': {
            $tenure = sanitize_data(@$_POST['maximumtripduration']);
            break;
        } default : {
            $tenure = no_of_days($tripStartDate, $tripEndDate);
            break;
        }
}
if ($tripTypeCd == 'Multi') {
    $tripTypeCd = 'MULTI';
} else {
    $tripTypeCd = 'SINGLE';
}
if (@$_REQUEST['agentId'] != '') {
    $agentId = sanitize_data(@$_REQUEST['agentId']);
} else if ($_SESSION['agentId'] != '') {
    $agentId = $_SESSION['agentId'];
} else {
    $agentId = "20008325";
//$agentId = AGENTID;
}

?>
<form name="PortalProposal" id="PortalProposal" method="GET" action="<?php echo $enhancePortalProposal; ?>">
    <input type="text" name="ageGroupOfEldestMember" value="<?=@$ageGroupOfEldestMember;?>" />
    <input type="text" name="agentId" value="<?php echo $agentId; ?>" />
    <input type="text" name="coverType" value="<?=@$coverType;?>" />
    <input type="text" name="noofTravellers" value="<?=@$noofTravellers;?>" />
    <input type="text" name="pCode" value="<?=@$travelGeographyCd;?>" />
    <input type="text" name="productFamily" value="<?=@$productFamily;?>" />
    <input type="text" name="quotationReferenceNum" value="<?=@$quotationReferenceNum;?>" />
    <input type="text" name="sumInsured" value="<?=@$sumInsured1;?>" />
    <input type="text" name="tenure" value="<?=@$tenure;?>" />
    <input type="text" name="travelGeographyCd" value="<?=@$travelGeographyCd;?>" />
    <input type="text" name="tripTypeCd" value="<?=@$tripTypeCd;?>" />
    <input type="text" name="tripStartDate" value="<?=@$tripStartDate;?>" />
    <input type="text" name="tripEndDate" value="<?=@$tripEndDate;?>"/>
    <input type="text" name="mobileNum" value="<?=@$mobileNumber;?>" />
    <input type="text" name="rmCode" value="<?php echo @$rmCode; ?>" />
    <input type="text" name="branchCode" value="<?php echo @$branchCode; ?>" />
    <input type="text" name="pedCd" value="<?php echo $pedQuestion; ?>" />
    <input type="text" name="source" value="<?php echo @$source; ?>" />
</form>
<script>
    document.PortalProposal.submit();
</script>
