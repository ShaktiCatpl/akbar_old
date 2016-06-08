<?php
//ini_set("display_errors",1);
include_once("conf/session.php");
include 'inc/conf.php';


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








function no_of_days($startDate, $endDate) {
    $date1 = strtotime($endDate);
    $date2 = strtotime($startDate);
    $dateDiff = $date1 - $date2;
    $fullDays = floor($dateDiff / (60 * 60 * 24));
    return $fullDays + 1;
}



$propasalPage = "0";


if (isset($_REQUEST['id'])) {
    $requestedId = sanitize_data($_REQUEST['id']);
    $checkCode = sanitize_data($_REQUEST['code']);
    $checkId = hash('sha256', "proposal-$requestedId");
    
    if ($checkCode != $checkId) {
        $propasalPage = "1";
    }

    $resultAllData = fetchListByColumnName('REFERENCE_TRAVELDATA', $requestedId);

    if (!empty($resultAllData)) {
        $resultData = $resultAllData[0];
        $cont = $resultData['QNA']->load();
        $t = base64_decode($cont);
        $questionArrayResult = json_decode($t, true);
        $UTM_SOURCE = json_decode($resultData['UTM_SOURCE'], true);
        $jsonDependentDetail = json_decode($resultData['DEPENDENT_DETAIL']);
    } else {
        
        $propasalPage = "1";
    }
    
    } else {
        $requestedId = md5("NEW");
    }

/*
echo "<pre>";
print_r($UTM_SOURCE);
exit;
*/
   
if (isset($resultData['INITIALS'])) {
    $INITIALS = sanitize_data($resultData['INITIALS']);
} else {
    $INITIALS = '0';
}

if (isset($resultData['FIRST_NAME'])) {
    $FIRST_NAME = sanitize_data($resultData['FIRST_NAME']);
} else {
    $FIRST_NAME = '';
}

if (isset($resultData['LAST_NAME'])) {
    $LAST_NAME = sanitize_data($resultData['LAST_NAME']);
} else {
    $LAST_NAME = '';
}

if (isset($resultData['DOB'])) {
    $DOB = sanitize_data($resultData['DOB']);
} else {
    $DOB = '';
}

if (isset($resultData['ADDRESS_1'])) {
    $ADDRESS_1 = sanitize_data($resultData['ADDRESS_1']);
} else {
    $ADDRESS_1 = '';
}

if (isset($UTM_SOURCE['ValidCityName'])) {
    $CValidCityName = sanitize_data($UTM_SOURCE['ValidCityName']);
} else {
    $CValidCityName = '';
}

if (isset($resultData['STATE'])) {
    $CValidStateName = sanitize_data($resultData['STATE']);
} else {
    $CValidStateName = '';
}

if (isset($resultData['ADDRESS_2'])) {
    $ADDRESS_2 = sanitize_data($resultData['ADDRESS_2']);
} else {
    $ADDRESS_2 = '';
}
if (isset($resultData['EMAIL_ID'])) {
    $EMAIL_ID = sanitize_data_email($resultData['EMAIL_ID']);
} else if (isset($_REQUEST['CValidEmail'])) {
    $EMAIL_ID = sanitize_data_email($_REQUEST['CValidEmail']);
} else {
    $EMAIL_ID = '';
}
if (isset($resultData['PIN_CODE'])) {
    $PIN_CODE = sanitize_data($resultData['PIN_CODE']);
} else {
    $PIN_CODE = '';
}
if (isset($resultData['PANCARD_NUMBER']) && $resultData['PANCARD_NUMBER'] != '') {
    $PANCARD_NUMBER = sanitize_data($resultData['PANCARD_NUMBER']);
} else {
    $PANCARD_NUMBER = '';
}


if (isset($UTM_SOURCE['quotationReferenceNum'])) {
    $quotationReferenceNum = sanitize_data($UTM_SOURCE['quotationReferenceNum']);
} else {
    $quotationReferenceNum = time();
}

if (isset($_REQUEST['qdob'])) {
    $QuotationDOB = sanitize_data($_REQUEST['qdob']);
} else {
    if (isset($UTM_SOURCE['QuotationDOB'])) {
        $QuotationDOB = sanitize_data($UTM_SOURCE['QuotationDOB']);
    } else {
        $QuotationDOB = date('d/m/Y', time() - 630720000);
    }
}
if (isset($_REQUEST['ageGroupOfEldestMember1'])) {
    $QuotDOBVarArr = '';
    for ($quotdob = 0; $quotdob < $_REQUEST['totalMember']; $quotdob++) {
        $quotdobinc = $quotdob + 1;
        $QuotDOBVar = 'QuotDOB' . $quotdobinc;
        $$QuotDOBVar = $_REQUEST['ageGroupOfEldestMember1'][$quotdob];
        $QuotDOBVarArr.= $_REQUEST['ageGroupOfEldestMember1'][$quotdob];
        if ($quotdobinc < $_REQUEST['totalMember']) {
            $QuotDOBVarArr.=',';
        }
    }
}


    
/* echo $QuotDOBVarArr;
  echo '<pre>';
  print_r($_REQUEST);
  print_r($resultData);
  exit; */

if (isset($resultData['ELDEST_MEMBER_AGE'])) {
    $ageGroupOfEldestMember = sanitize_data($resultData['ELDEST_MEMBER_AGE']);
} else {
    $ageGroupOfEldestMember = '';
}


if (isset($resultData['INSURANCE_AMT'])) {
    $sumInsuredValue1 = sanitize_data($resultData['INSURANCE_AMT']);
    if ($sumInsuredValue1 == '50000') {
        $individualInsuredAmountAssure = '300000';
    } else {
        $individualInsuredAmountAssure = '200000';
    }
    //$sumInsuredValue1 = '500000';
} else {
    $individualInsuredAmountAssure = '200000';
    $sumInsuredValue1 = '25000';
}


if (isset($_REQUEST['tenure'])) {
    $tenure = sanitize_data($_REQUEST['tenure']);
} else if (isset($resultData['TENURE'])) {
    $tenure = sanitize_data($resultData['TENURE']);
} else {
    $tenure = 1;
}

if (isset($UTM_SOURCE['rmCode'])) {
    $rmCode = sanitize_data($UTM_SOURCE['rmCode']);
} else {
    $rmCode = '';
}

if (isset($UTM_SOURCE['branchCode'])) {
    $branchCode = sanitize_data($UTM_SOURCE['branchCode']);
} else {
    $branchCode = '';
}
 if (isset($_REQUEST['sumInsured'])) {
        $sumInsured = sanitize_data(trim($_REQUEST['sumInsured']));
    } else if (isset($resultData['SUMINSURED'])) {
        $sumInsured = sanitize_data(trim($resultData['SUMINSURED']));
    } else {
        //$propasalPage = "1";
    }
if (isset($UTM_SOURCE['nomineeRelation'])) {
    $nomineeRelation = sanitize_data($UTM_SOURCE['nomineeRelation']);
} else {
    $nomineeRelation = '';
}

if (isset($UTM_SOURCE['NomineeName'])) {
    $NomineeName = sanitize_data($UTM_SOURCE['NomineeName']);
} else {
    $NomineeName = '';
}
if (isset($resultData['AGENT_ID'])) {
    $agentId = sanitize_data($resultData['AGENT_ID']);
} else {
    $agentId = $_SESSION['agentId'];
}
if (isset($resultData['MOBILE_NO'])) {
    $mobileNum = sanitize_data($resultData['MOBILE_NO']);
} else {
    $mobileNum = '';
}


$productCode = "20001004";

$source = "TRAVEL PORTAL";
//$productFamily = "CARE";


/*
if (isset($_REQUEST['children'])) {
    $numberOfChildren = sanitize_data($_REQUEST['children']);
} else if (isset($resultData['CHILDREN'])) {
    $numberOfChildren = sanitize_data($resultData['CHILDREN']);
} else {
    $numberOfChildren = 0;
}


if (isset($_REQUEST['totalMember'])) {
    if ($_REQUEST['totalMember'] > 0 && $_REQUEST['totalMember'] < 7) {
        $numberOfAdult = sanitize_data($_REQUEST['totalMember']);
    } else {
        
    }
    
} else if (isset($resultData['MEMBER_COUNT'])) {
    $numberOfAdult = $resultData['MEMBER_COUNT'];
} else {
    $numberOfAdult = '';
}


if (isset($_POST['covertype']) && $_POST['covertype'] == 'Individual') {
    $coverType = "INDIVIDUAL";
    // $ageGroupOfEldestMemberArray = @$_POST['ageGroupOfEldestMember1'];
    $sumInsured1 = $INDIVIDUAL[$_REQUEST['sumInsured']];
} else {
    $sumInsured1 = $FAMILYFLOATER[$_REQUEST['sumInsured']];
    $coverType = "FAMILYFLOATER";
    //   $ageGroupOfEldestMemberArray = @$_POST['ageGroupOfEldestMember'];
}




if (isset($resultData['INSURANCE_AMT'])) {
    $sInsuredAmount = sanitize_data($resultData['INSURANCE_AMT']);
} else if (isset($_REQUEST['sumInsured'])) {
    $sInsuredAmount = sanitize_data($_REQUEST['sumInsured']);
} else {
    $sInsuredAmount = '';
}


if (isset($_REQUEST['premiumradio'])) {
    $premiumradio = $_REQUEST['premiumradio'];
} else {
    $premiumradio = "akbartravel";
}



if (isset($resultData['PREMIUM_AMOUNT'])) {
    $finalPremiumCheck = sanitize_data($resultData['PREMIUM_AMOUNT']);
} else if ($premiumradio == 'care') {
    $finalPremiumCheck = sanitize_data($_REQUEST['premium1']);
} else if ($premiumradio == 'ncb') {
    $finalPremiumCheck = sanitize_data($_REQUEST['premium2care']);
} else {
    $finalPremiumCheck = '';
}


*/


if ($propasalPage == "1") {
    header("LOCATION:error.php");
    exit;
}

$numberOfAdult = @$_POST['noOfTravellers'];
include 'inc/topScript.php';
?>

<body>
   <!-- <script type="text/javascript" src="js/wz_tooltip.js"></script>-->
    <?php include 'inc/header.php'; ?>
    <?php //include 'inc/navigation.php';  ?>
    <!-- <div class="page_nav">
         Quotation Â» Care</div>-->
    <?php include 'inc/editTravel.php'; ?>

    <?php
    

//die;
/* Post Data  */

    $travellingTo = @$_POST["travellingTo"];
    $tripTypeCd = @$_POST["tripType"];
    $tripTypeSigle = @$_POST["tripTypeSigle"];
    $coverType = @$_POST["coverType"];
    $startDate = @$_POST["startDate"];
    
    
    if($tripTypeCd == "Multi"){
        $date = strtotime("+365 day", strtotime($startDate));
        $endDate = date("d-m-Y", $date);
       // $maximumtripduration = @$_POST["maximumtripduration"];
        $tenure = no_of_days($startDate, $endDate);
        
    }else{
        
        //$maximumtripduration = 
        
        $endDate = @$_POST["endDate"];
        $tenure = no_of_days($startDate, $endDate);
    }
   
    $noday = @$_POST["noday"];
    $noOfTravellers = @$_POST["noOfTravellers"];
    $eachmember = @$_POST["eachmember"];
    $mobilenotr = @$_POST["mobilenotr"];
    $checkmobile = @$_POST["checkmobile"];
    $pedQuestion = @$_POST["pedQuestion"];
    $sumInsuredTravel1 = @$_POST["sumInsuredTravel1"];
    
    
    

    if ($travellingTo == 5 || $travellingTo==6) {
         $goldplan = $_POST['goldplan'][0];
        if ($_POST['goldplan'] == 'pletinum')
        {
             $finalPremiumCheck = $_POST['travelPremiumpletinumdata'];
        }
        else
        {            
             $finalPremiumCheck = $_POST['travelPremiumgolddata'];
        }
    }
    else
    {
        $goldplan = $_POST['goldplan3'];
        $finalPremiumCheck = $_POST['travelPremiumdata'];
    }

    


    if(!empty($_REQUEST['eachmember'])) {
         $finalArray = array_slice($_REQUEST['eachmember'], 0, $_REQUEST['noOfTravellers']);
        //$_REQUEST['ageGroupOfEldestMember'] = implode(',', $finalArray);
         $ageGroupOfEldestMember = implode(',', $finalArray);
    }

    //$noofageband = explode(",", $ageGroupOfEldestMember);
   // print_r($noofageband);
   

    switch($travellingTo) {
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
                } else if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                    $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel4']);
                } else {
                    $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel']);
                }
              
                
                if (($tripTypeCd == 'Single') && ($goldplan == 'gold')) {
                    $travelGeographyCd = '40001011';
                } else if (($tripTypeCd == 'Single') && ($goldplan == 'pletinum')) {
                    $travelGeographyCd = '40001012';
                } else if (($tripTypeCd == 'Multi') && ($goldplan == 'gold')) {
                    $travelGeographyCd = '40001007';
                } else if (($tripTypeCd == 'Multi') && ($goldplan == 'pletinum')) {
                    $travelGeographyCd = '40001008';
                }
                break;
            }
        case '6': {
                if (in_array("81-99", $finalArray)) {
                    $sumInsured1 = sanitize_data("001");
                } else if (in_array("71-80", $finalArray) || in_array("61-70", $finalArray) || $pedQuestion == 'YES') {
                    $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel4']);
                } else {
                    $sumInsured1 = sanitize_data(@$_POST['sumInsuredTravel']);
                }
        
                if (($tripTypeCd == 'Single') && ($goldplan == 'gold')) {
                    $travelGeographyCd = '40001009';
                } else if (($tripTypeCd == 'Single') && ($goldplan == 'pletinum')) {
                    $travelGeographyCd = '40001010';
                } else if (($tripTypeCd == 'Multi') && ($goldplan == 'gold')) {
                  $travelGeographyCd = '40001005';
                } else if (($tripTypeCd == 'Multi') && ($goldplan == 'pletinum')) {
                    $travelGeographyCd = '40001006';
                }
                             
                break;
            }
        default : {
                $propasalPage = "1";
                break;
            }
    }
    
    /*
      switch ($tripTypeCd) {
      case 'MULTI': {
      $_REQUEST['tenure'] = sanitize_data(@$_REQUEST['maximumtripduration']);
      break;
      } default : {
      $_REQUEST['tenure'] = no_of_days($tripStartDate, $tripEndDate);
      break;
      }
      }
*/
      
       
    /* Travel code */
    
  $plancode = array
  (
    "Asia"=>array(40001001),
    "Africa"=>array(40001002),
    "Europe"=>array(40001015),
    "Canada"=>array(40001004),
    "Worldwide"=>array(40001011,40001012,40001007,40001008),
    "WW-Excl. US/Canada"=>array(40001009,40001010,40001005,40001006)
  );
  
  /* End post data*/



    
    
    
    
  /* Travel code */
    
    /*
      $premval                    = $_POST["premval"];
      $sumInsuredTravel           = $_POST["sumInsuredTravel"];
      $sumInsuredTravel4          = $_POST["sumInsuredTravel4"];
      $sumInsuredTravel70         = $_POST["sumInsuredTravel70"];
      $sumInsuredTravel3          = $_POST["sumInsuredTravel3"];
      $goldplan                   = $_POST["goldplan"];
      $goldplan3                  = $_POST["goldplan3"];
      $rmCode                     = $_POST["rmCode"];
      $source                     = $_POST["source"];
      $branchCode                 = $_POST["branchCode"];
      $IndividualInsuredAmountNew = $_POST["IndividualInsuredAmountNew"];
      $IndividualInsuredAmount    = $_POST["IndividualInsuredAmount"];
     */

    $traveldisplay2 = 'none';
    if ($_POST['travellingTo'] != '') {
        $traveldisplay2 = "block";
    }
    ?>

    <div class="mid_inner_container_otc" id="proposal_form" style="display:<?php echo $traveldisplay2; ?>">
        <div class="quoteBoxgreen">Get a Quick Quote > Travel <a href="javascript://" onclick="editdisplayTripType1('<?php echo $_POST['tripType']; ?>');"  id="editquote">Edit Quote</a></div>
        <!--<div class="quoteBoxgreenUp fl"><a href="javascript://"  id="editquote">Edit Quote</a></div>-->
        <form action="savePagetravel.php" method="post" class="AdvancedForm" name="savePageenhanceForm" id="savePageassureForm">
          <?php if($_SESSION['loginstatus']){ ?>
          <input type="hidden" name="travellingTo" id="travellingTo" value="<?php echo $travellingTo; ?>" />
          <input type="hidden" name="proposalSumInsured" id="proposalSumInsured" value="<?php echo $sumInsured; ?>" />  
          <input type="hidden" name="tripType" id="tripType" value="<?php echo $tripTypeCd; ?>" />
            <!--<input type="text" name="tripTypeSigle" id="tripTypeSigle" value="<?php //echo $tripTypeSigle;   ?>" />-->
            <input type="hidden" name="maximumtripduration" id="maximumtripduration" value="<?php echo $maximumtripduration; ?>" />
            <input type="hidden" id="coverType" name="coverType"  value="<?php echo $coverType; ?>"/>  
            <input type="hidden" id="startDate" name="startDate"  value="<?php echo $startDate; ?>"/>  
            <input type="hidden" id="endDate" name="endDate"  value="<?php echo $endDate; ?>"/> 
            <input type="hidden" name="totalAdultMember" id="totalAdultMember" value=" <?php echo $numberOfAdult; ?>"/>
            <input type="hidden" id="mobilenotr" name="mobilenotr" value="<?php echo $mobilenotr; ?>"/>
            <input type="hidden" id="pedQuestion" name="pedQuestion" value="<?php echo $pedQuestion; ?>"/>
            <input type="hidden" id="goldplan" name="goldplan" value="<?php echo $goldplan; ?>"/>
            <input type="hidden" name="proposalProductCode" value="<?php echo $travelGeographyCd; ?>" /> 
            <input type="hidden" name="permiumamountValid" id="permiumamountValid" value="<?php echo $finalPremiumCheck; ?>"/>
            <input type="hidden" name="source"  value="<?php echo $source; ?>"/>
            <input type="hidden" name="proposalRequestId" id="proposalRequestId" value="<?php echo $requestedId; ?>" />
            <input type="hidden" name="proposalageGroupOfEldestMember" id="proposalageGroupOfEldestMember" value="<?php echo $ageGroupOfEldestMember; ?>" />
            <input type="hidden" name="proposalTenourCode" id="proposalTenourCode" value="<?php echo $tenure; ?>"/>
            <input type="hidden" name="proposalSumInsured" id="proposalSumInsured" value="<?php echo $sumInsured1; ?>" />
            
          <?php  } ?>
            <!--   $sumInsured1
              <input type="text" name="proposalRequestId" id="proposalRequestId" value="<?php //echo $requestedId; ?>" />
              <input type="text" name="proposalSumInsured" id="proposalSumInsured" value="<?php //echo $sumInsured; ?>" />
              <input type="text" name="proposalageGroupOfEldestMember" id="proposalageGroupOfEldestMember" value="<?php echo $ageGroupOfEldestMember; ?>" />
              <input type="text" name="totalAdultMember" id="totalAdultMember" value=" <?php echo $numberOfAdult; ?>"/>
              <input type="text" name="totalChildMember" id="totalChildMember" value="<?php echo $numberOfChildren; ?>"/>
              <input type="text" name="proposalProductCode" id="proposalProductCode" value="<?php echo $productCode; ?>"/>
              <input type="text" name="proposalDummySi" id="proposalDummySi" value="<?php echo $sInsuredAmount; ?>"/>
              <input type="text" name="saveandcontinueemail"  id="saveandcontinueemail" value=""/>
              <input type="text" name="agentId" id="agentId"  value="<?php echo $agentId; ?>"/>
              <input type="text" name="proposalTenourCode" id="proposalTenourCode" value="<?php echo $tenure; ?>"/>
              <input type="text" name="rmCode"  value="<?php echo $rmCode; ?>"/>
              <input type="text" name="permiumamountValid" id="permiumamountValid" value="<?php echo $finalPremiumCheck; ?>"/>
              <input type="text" name="branchCode"  value="<?php echo $branchCode; ?>"/>
              <input type="text" name="quotationReferenceNum"  value="<?php echo $quotationReferenceNum; ?>"/>
              <input type="text" name="productFamily"  value="<?php echo $productFamily; ?>"/>
              <input type="text" name="source"  value="<?php echo $source; ?>"/>
              <input type="text" name="productCode"  value="<?php echo $productCode; ?>"/>
              <input type="text" name="QuotationDOB" id="QuotationDOB"  value="<?php echo $QuotDOBVarArr; ?>"/>-->



            <!--<div class="quotetopbarotc fl">Your Proposal Form</div>-->
            <div class="quoteresultmidotc fl">
                <div class="proposerDetailBox fl">
                    <h1>Proposeral's Details</h1>
                    <div class="proposerDetailBoxForm fl">
                        <table width="949" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="119" valign="top">

                                                <select id="ValidTitle" name="ValidTitle" class="width80" onChange="changeTitleList();">
                                                    <option value="0" <?php if ($INITIALS == '0') { ?> selected="selected" <?php } ?>>Title</option>
                                                    <option value="MR" <?php if ($INITIALS == 'MR') { ?> selected="selected" <?php } ?>>Mr</option>
                                                    <option value="MS" <?php if ($INITIALS == 'MS') { ?> selected="selected" <?php } ?>>Ms</option>
                                                </select>
                                            </td>

                                            <td width="203" valign="top"><input name="ValidFName" id="ValidFName" onBlur="changeTitleList();" type="text" placeholder="First name"  class="txtfield_OTC" style="width:170px;" value="<?php echo $FIRST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="205" valign="top"><input type="text" name="ValidLName" id="ValidLName" onBlur="changeTitleList();" class="txtfield_OTC" style="width:170px;" placeholder="Last Name" value="<?php echo $LAST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="198" valign="top"><input type="text" name="DOB" id="datepicker" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" onClick="scwShow(scwID('datepicker'), event, '01/01/1975');" value="<?php echo $DOB; ?>" /></td>
                                            <td width="224" valign="top"><input type="text" maxlength="10" name="ValidMobileNumber" id="ValidMobileNumber" class="txtfield_OTC" style="width:200px;" placeholder="Mobile No." value="<?php if($mobilenotr){echo $mobilenotr; }else{ echo @$resultData['MOBILE_NO']; } ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="401" valign="top"><input type="text" name="ValidAddressOne" id="ValidAddressOne" class="txtfield_OTC" style="width:370px;" placeholder="Address Line 1" value="<?php echo $ADDRESS_1; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="548" valign="top"><input type="text" name="ValidAddressTwo" id="ValidAddressTwo" class="txtfield_OTC" style="width:400px;" placeholder="Address Line 2" value="<?php echo $ADDRESS_2; ?>" /></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="279" valign="top"><input type="text" name="ValidEmail" id="ValidEmail" class="txtfield_OTC" style="width:220px;" placeholder="Email Id" value="<?php echo $EMAIL_ID; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="123" valign="top">
                                                <input type="text" name="ValidNomniee" id="ValidNomniee"  class="txtfield_OTC" style="width:90px;" placeholder="Nominee Name" value="<?php echo $UTM_SOURCE['NomineeName']; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="123" valign="top"><input type="text" name="ValidPinCode" id="ValidPinCode" onBlur="getCityName();" class="txtfield_OTC" style="width:90px;" placeholder="Pincode" value="<?php echo $PIN_CODE; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="229" valign="top"><div style="width:190px; display:inline-block;">
                                                    <select name="ValidCityName" id="ValidCityName"  style="width:185px; font-weight:normal;" onChange="questionnairedatashow()">
                                                        <option value="<?php
                                                        if ($CValidCityName != '') {
                                                            echo $CValidCityName;
                                                        }
                                                        ?>"><?php
                                                                    if ($CValidCityName != '') {
                                                                        echo $CValidCityName;
                                                                    } else {
                                                                        ?>City (Auto on Pincode) <?php } ?> </option>
                                                    </select>
                                                </div>
                                                &nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="318" valign="top"><input type="text"  value="<?php echo $CValidStateName; ?>" name="ValidStateName" id="ValidStateName" class="txtfield_OTC" style="width:170px;" placeholder="State" /></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                    </div>
                    <h1>Details of person (s) to be insured</h1>
                </div>                
               <?php
               if($resultData['MEMBER_COUNT']!="" && $numberOfAdult ){
               include("editperposal.php");
               }else{
               ?>


                <?php
                $self = 0;
                $dep = 0;
                for ($i = 1; $i <= $numberOfAdult; $i++) {
                    ?>
                    <div id="nooftravel">
                        <div class="proposerDetailBoxFormgray fl">
                            <table width="949" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="180" valign="top">
                                        <div class="" id="ValidRelationAddClass-<?php echo $i; ?>" style="width:85px;">
                                            <select name="relationCd[]" id="relationCd-<?php echo $i; ?>" onChange="changeTitleCd(this,<?php echo $i; ?>);" style="width:80px; font-weight:normal;">
                                                <option value="0" <?php if (@$jsonDependentDetail[$dep]->relationCd == '0') { ?> selected="selected" <?php } ?>>Relation</option>
                                                <option value="SELF" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SELF') { ?> selected="selected" <?php } ?>>Self - Primary Member</option>
                                                <option value="SPSE" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SPSE') { ?> selected="selected" <?php } ?>>Spouse</option>
                                                <option value="SONM" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SONM') { ?> selected="selected" <?php } ?>>Son</option>
                                                <option value="UDTR" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'UDTR') { ?> selected="selected" <?php } ?>>Daughter</option>
                                                <option value="FATH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'FATH') { ?> selected="selected" <?php } ?>>Father</option>
                                                <option value="MOTH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MOTH') { ?> selected="selected" <?php } ?>>Mother</option>
                                                <optgroup label="----------------------" style="padding:5px 0px;"></optgroup>
                                                <option value="MANT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MANT') { ?> selected="selected" <?php } ?>>Auntie</option>
                                                <option value="BOTH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'BOTH') { ?> selected="selected" <?php } ?>>Brother</option>
                                                <option value="MDTR" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MDTR') { ?> selected="selected" <?php } ?>>Brother In Law</option>
                                                <option value="COUS" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'COUS') { ?> selected="selected" <?php } ?>>Cousin</option>
                                                <option value="DLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'DLAW') { ?> selected="selected" <?php } ?>>Daughter In Law</option>
                                                <option value="FLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'FLAW') { ?> selected="selected" <?php } ?>>Father In Law</option>
                                                <option value="GDAU" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GDAU') { ?> selected="selected" <?php } ?>>Grand Daughter</option>
                                                <option value="GFAT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GFAT') { ?> selected="selected" <?php } ?>>Grand Father</option>
                                                <option value="GMOT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GMOT') { ?> selected="selected" <?php } ?>>Grand Mother</option>
                                                <option value="GSON" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GSON') { ?> selected="selected" <?php } ?>>Grand Son</option>
                                                <option value="MLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MLAW') { ?> selected="selected" <?php } ?>>Mother In Law</option>
    <!--                                                                <option value="NBON" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'NBON') { ?> selected="selected" <?php } ?>>NEW BORN BABY</option>-->
                                                <option value="NEPH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'NEPH') { ?> selected="selected" <?php } ?>>Nephew</option>
                                                <option value="NIEC" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'NIEC') { ?> selected="selected" <?php } ?>>Niece</option>
    <!--                                         <option value="PANT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'PANT') { ?> selected="selected" <?php } ?>>PATERNAL AUNT</option>
                                                <option value="PUNC" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'PUNC') { ?> selected="selected" <?php } ?>>PATERNAL UNCLE</option>-->
                                                <option value="SIST" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SIST') { ?> selected="selected" <?php } ?>>Sister</option>
                                                <option value="MMBR" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MMBR') { ?> selected="selected" <?php } ?>>Sister In Law</option>
                                                <option value="SLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SLAW') { ?> selected="selected" <?php } ?>>Son In Law</option>
                                                <option value="MUNC" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MUNC') { ?> selected="selected" <?php } ?>>Uncle</option>
                                            </select>

                                        </div>
                                    </td>

                                    <td width="180" valign="top">
                                        <div class=" " style="width:85px;">
                                            <select name="titleCd[]" id="titleCd-<?php echo $i; ?>" class="" style="width:80px; font-weight:normal;">
                                                    <?php if (isset($jsonDependentDetail[$dep]->titleCd) && ($jsonDependentDetail[$dep]->titleCd != '')) { ?>
                                                    <option value="<?php echo $jsonDependentDetail[$dep]->titleCd; ?>"  selected="selected" ><?php
                                                        if ($jsonDependentDetail[$dep]->titleCd == '0') {
                                                            echo "Title";
                                                        } else {
                                                            echo ucfirst(strtolower($jsonDependentDetail[$dep]->titleCd));
                                                        }
                                                        ?>
                                                    </option>
                                                <?php } else { ?>
                                                    <option value="0" >Title</option>
                                                    <option value="MR">Mr</option>
                                                    <option value="MS">Ms</option>
                                           <?php } ?>
                                            </select>
                                        </div></td>
                                        <td width="252" valign="top"><input type="text" name="firstNameCd[]" id="firstNamecd-<?php echo $i; ?>" class="txtfield_OTC" style="width:125px;" placeholder="First Name" onblur="checkFirstNameValTest(<?php echo $i; ?>);" value="<?php //echo @$jsonDependentDetail[$dep]->firstNameCd;  ?>" />
                                        &nbsp;<span class="mandatorytxt">*</span></td>
                                    <td width="295" valign="top"><input type="text" name="lastNameCd[]" id="lastNamecd-<?php echo $i; ?>" class="txtfield_OTC" style="width:125px;" placeholder="Last Name" value="<?php //echo @$jsonDependentDetail[$dep]->lastNameCd;  ?>" />
                                        &nbsp;<span class="mandatorytxt">*</span></td>
                                    <td width="278" valign="top"><input type="text" name="dOBCd[]" id="datepickerCD-<?php echo $i; ?>" class="txtfield_OTCDate" style="width:125px;" placeholder="DOB - DD/MM/YYYY" onClick="scwShow(scwID('datepickerCD-<?php echo $i; ?>'), event, '');" value="<?php //echo @$jsonDependentDetail[$dep]->dOBCd;  ?>" /></td>
                                    <td width="278" valign="top"> &nbsp;<span class="mandatorytxt">*</span><input type="text" name="passport[]" id="passport-<?php echo $i; ?>" class="txtfield_OTC" style="width:125px;" placeholder="Passport" value="<?php //echo @$jsonDependentDetail[$dep]->lastNameCd;   ?>" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                
                <?php } ?>

                
                             
                

                <div class="proposerDetailBox fl">
                    <h1><img src="images/minus_green.jpg" class="fl" onClick="questionnairedatahide()" id="questionnairedatahideid"><img src="images/plus_green.jpg" class="fl" id="questionnairedatashowid" onClick="questionnairedatashow()" style="display:none;">&nbsp;Health Questionnaire</h1>
                    <div id="questionnairedata">

                        <div class="questionBar fl">
                            <h2 id="clck1">Does any person(s) to be insured has any Pre-existing diseases? <img onMouseOut="UnTip();" onMouseOver="Tip('Please select yes if any person(s) to be insured has Diabetes,hypertension,liver disease,cancer, cardiac disease, joint pain, kidney disease, paralysis,Congenital Disorder, HIV/AIDS. This is vital for correct Claim disbursal.');" src="images/question_icon.png" border="0"/></h2>

                            <div class="yes_no_box" id="question">
                                <input type="radio" name="questions[yesNoExist][pedYesNo]" id="question-1" value='1' <?php
                                       if (isset($questionArrayResult['yesNoExist']['pedYesNo'])) {
                                           if (@$questionArrayResult['yesNoExist']['pedYesNo'] == 1) {
                                               ?> checked="checked" <?php
                                    }
                                }
                                ?> style="border:none;" onClick="setVisibility('id1', 'inline');" />
                                Yes <input name="questions[yesNoExist][pedYesNo]" type="radio" id="question-2" <?php
                                           if (isset($questionArrayResult['yesNoExist']['pedYesNo'])) {
                                               if (@$questionArrayResult['yesNoExist']['pedYesNo'] == 0) {
                                                   ?> checked="checked" <?php
                                               }
                                           }
                                           ?> style="border:none;" onClick="setVisibility('id1', 'none');"  value='0' />
                                No </div>

                            <div class="do_doesBox2" id="id1" style="display:none;">
                                <div class="do_doesBoxhead1">
                                    <div class="do_doesBoxheadleft1">Question</div>
                                    <div class="do_doesBoxheadright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
<?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
                                                    <td style="width:<?php echo $styleArray; ?>%;" id='insuredCdOne-<?php echo $i; ?>'>Insured <?php echo $i; ?></td>
<?php } ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="do_doesBoxbelow1 graybg">
                                    <div class="do_doesBoxbelowleft1">Does any person(s) to be insured has any Pre-existing diseases? <span class="redtxt">*</span></div>
                                    <div class="do_doesBoxbelowright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <?php
                                                $k = 0;
                                                for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                    ?>
                                                    <td>
                                                        <select name="questions[yesNoExist][subQuestion][1][qus][]" id="sonu<?php echo $i ?>"  onchange="displayQuestion(<?php echo $i ?>);" class="" style="width:90px;">
                                                            <option value="0" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                            <option value="YES" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                            <option value="NO" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                        </select>
                                                    </td>
                                                    <?php
                                                    $k++;
                                                }
                                                ?>

                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <?php
                                $q = 1;
                                foreach ($questionArray as $q_id => $question) {
                                    ?>

                                    <div class="do_doesBoxbelow1 <?php
                                         if ($q % 2 == 0) {
                                             echo 'graybg';
                                         }
                                         ?>">
                                        <div class="do_doesBoxbelowleft1"><?php echo $question; ?>?</div>
                                        <div class="do_doesBoxbelowright">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                        <?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
                                                        <td>
                                                            <input type="hidden" name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][qus][]"   value='0' />
                                                            <input 
                                                                <?php
                                                                if (!empty($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['qus'])) {
                                                                    if (in_array($i, @$questionArrayResult['yesNoExist']['subQuestion'][$q_id]['qus'])) {
                                                                        ?> checked="checked" <?php
                                                    }
                                                }
                                                                ?> class='<?php echo $q_id; ?> prashant<?php echo $i; ?>' type="checkbox" name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][qus][]" id="insuredCdQuestionOne-<?php echo $q_id . "-" . $i; ?>" onclick='insuredCdQuestionChk(<?php echo $q_id; ?>,<?php echo $i; ?>,<?php echo date("Y"); ?>);' value='<?php echo $i; ?>' />
                                                        </td>

    <?php } ?>

                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div id='insuredCdQuestionMMYYYY-<?php echo $q_id; ?>' class="do_doesBoxbelow1 <?php
                                         if ($q % 2 == 0) {
                                             echo 'graybg';
                                         }
                                         ?>" style='display:none;'>
                                        <div class="do_doesBoxbelowleft1">Existing since? (YYYY/MM) <span class="redtxt">*</span></div>
                                        <div class="do_doesBoxbelowright">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                                <tr>
                                                    <?php
                                                    $l = 0;
                                                    for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                        ?>
                                                        <td style="width:<?php echo $styleArray; ?>%;">
                                                            <div class="year-month-<?php echo $i; ?>" id='insuredCdQuestionMMYYYYP-<?php echo $q_id; ?>-<?php echo $i; ?>' style='display:none; float:left; '>

                                                                <div class="" style="margin-right:5px;">
                                                                    <select name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][yy][]" class=""  <?php if (isset($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l]) && ($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l] != '')) { ?>did="<?php echo $questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l]; ?>"<?php } ?>    id="YYYY-<?php echo $q_id; ?>-<?php echo $i; ?>" onChange="checkYear(this.value, '<?php echo date('Y'); ?>', '<?php echo $q_id; ?>', '<?php echo $i; ?>', '<?php echo date('m'); ?>');" style="width:50px;">
                                                                     <option value="0">YYYY</option>
                                                                    </select></div>
                                                                <div class="">
                                                                    <select name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][mm][]"  id="MM-<?php echo $q_id; ?>-<?php echo $i; ?>" style="width:35px;">
                                                                        <option value="0">MM</option>
                                                                        <?php
                                                                        for ($m = 1; $m <= 12; $m++) {
                                                                            $month = date('M', mktime(0, 0, 0, $m, 1, date('Y')));
                                                                            ?>
                                                                            <option value="<?php echo $m; ?>" <?php if (@$questionArrayResult['yesNoExist']['subQuestion'][$q_id]['mm'][$l] == $m) { ?> selected="selected" <?php } ?> ><?php echo $month; ?></option>
                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div></td>
                                                        <?php
                                                        $l++;
                                                    }
                                                    ?>

                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                    $q++;
                                }
                                ?>
                            </div>
                            <div class="cl"></div>
                        </div>


                        <div class="questionBar fl">
                            <h2 id="clck2"> Has anyone been diagnosed / hospitalized / or under any treatment for any illness / injury during the last 48 months ? <img src="images/question_icon.png" border="0" onMouseOut="UnTip();" onMouseOver="Tip('Please do not include treatments for common cold, flu fever, regular medical check-ups.');" class="qicon"/></h2>
                            <div class="yes_no_box" id="question1">
                                <input type="radio" name="questions[HEDHealthHospitalized][H001]"  id="question1-1" <?php
                                       if (isset($questionArrayResult['HEDHealthHospitalized']['H001'])) {
                                           if (@$questionArrayResult['HEDHealthHospitalized']['H001'] == 1) {
                                               ?> checked="checked" <?php
                                   }
                               }
                                       ?> value='1' style="border:none;" onClick="setVisibility('id2', 'inline');" />
                                Yes <input type="radio" name="questions[HEDHealthHospitalized][H001]"  id="question1-2"  value='0' <?php
                                           if (isset($questionArrayResult['HEDHealthHospitalized']['H001'])) {
                                               if (@$questionArrayResult['HEDHealthHospitalized']['H001'] == 0) {
                                                   ?> checked="checked" <?php
                                       }
                                   }
                                           ?> style="border:none;" onClick="setVisibility('id2', 'none');" />
                                No</div>

                            <div class="do_doesBox2" id="id2" style="display:none;">
                                <div class="do_doesBoxhead1">
                                    <div class="do_doesBoxheadleft1">Question</div>
                                    <div class="do_doesBoxheadright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
<?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
                                                    <td style="width:<?php echo $styleArray; ?>%;" id='insuredCdTwo-<?php echo $i; ?>'>Insured <?php echo $i; ?></td>
<?php } ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="do_doesBoxbelow1 graybg">
                                    <div class="do_doesBoxbelowleft1">&nbsp;</div>
                                    <div class="do_doesBoxbelowright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <?php
                                                $r = 0;
                                                for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                    ?>
                                                    <td><div class="">
                                                            <select name="questions[HEDHealthHospitalized][subQuestion][qus][]" class="" style="width:90px;">
                                                                <option value="0" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                <option value="YES" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="NO" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div></td>
                                                    <?php
                                                    $r++;
                                                }
                                                ?>

                                            </tr>
                                        </table>
                                    </div>
                                </div>     
                            </div>
                            <div class="cl"></div>
                        </div>

                        <div class="questionBar fl">
                            <h2 id="clck3"> Have you ever claimed under any travel policy ? <img src="images/question_icon.png" border="0"   onmouseout="UnTip();" onMouseOver="Tip('Please select the relevant option as this helps in quick claim disbursal.');" class="qicon"/></h2>
                            <div class="yes_no_box" id="question2">
                                <input type="radio" name="questions[HEDHealthClaim][H002]" id="question2-1" <?php
                                       if (isset($questionArrayResult['HEDHealthClaim']['H002'])) {
                                           if (@$questionArrayResult['HEDHealthClaim']['H002'] == 1) {
                                               ?> checked="checked" <?php
                                   }
                               }
                                       ?> value='1' style="border:none;" onClick="setVisibility('id3', 'inline');" />
                                Yes <input type="radio" name="questions[HEDHealthClaim][H002]" id="question2-2" <?php
                                           if (isset($questionArrayResult['HEDHealthClaim']['H002'])) {
                                               if (@$questionArrayResult['HEDHealthClaim']['H002'] == 0) {
                                                   ?> checked="checked" <?php
                                       }
                                   }
                                           ?> value='0' style="border:none;" onClick="setVisibility('id3', 'none');" />
                                No </div>

                            <div class="do_doesBox2" id="id3" style="display:none;">
                                <div class="do_doesBoxhead1">
                                    <div class="do_doesBoxheadleft1">Question</div>
                                    <div class="do_doesBoxheadright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
<?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
              <td style="width:<?php echo $styleArray; ?>%;" id='insuredCdThree-<?php echo $i; ?>'>Insured <?php echo $i; ?></td>
<?php } ?>
                                        </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="do_doesBoxbelow1 graybg">
                                    <div class="do_doesBoxbelowleft1">&nbsp;</div>
                                    <div class="do_doesBoxbelowright">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <?php
                                                $r = 0;
                                                for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                    ?>
                                                    <td><div class="">
                                                            <select name="questions[HEDHealthClaim][subQuestion][qus][]" class="" style="width:90px;">
                                                                <option value="0" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                <option value="YES" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                <option value="NO" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                            </select>
                                                        </div></td>
                                                    <?php
                                                    $r++;
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>     
                            </div>
                            <div class="cl"></div>
                        </div>

                    </div>
                    <div class="termBox fl" id="validTermCondition">
                        <input name="validTermCondition" id="validTermCondition-1" <?php if (@$resultData['TNC_AGREED'] == 1) { ?> checked="checked" <?php } ?> type="checkbox" value="1"  />
                        I here by agree to the <a href="javascript:void(0)" onClick="window.open('http://rhicluat.religare.com/proposalterms.html', '_blank', 'width=700,height=515')">term & conditions</a> of the purchase of this policy. *
                        <br/>
                        <input type="checkbox" name="TripStartIndia" id="TripStartIndia" value="1"  /> Trip start from India only.
                        <br/>
                        <input type="checkbox" name="checkbox2" id="checkbox2" /> Receive Service SMS and E-mail alerts
                    </div>


                    <div class="proceedBox ">
                        <div style="display:none; margin-bottom: 25px; color: #D00;" class="redtxtBottom" id="errordisplayPrashant">Kindly fill the boxes highlighted in red.</div>
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <!--<onclick="checkClickEvent(1); saveTransQuotation('proposal');">-->
                                    <input type="hidden" id="checkclickid" name="checkclickid" value="1">
                                    <input type="image" id="FormSubmit"  onclick="return checkClickEvent(1); saveTransQuotation('proposal');" src="images/preceed_btn.jpg" style="border: none;"/></td>
  <!--<td><input type="image" name="save" src="images/save_emailBtn.jpg" value="" style="border: none; cursor: pointer;" onClick="checkClickEvent(2);" class="saveContinue savebtn"/></td> --></tr>
                        </table>
                    </div>    
                </div>
                
               <?php } ?>
                
            </div>
        </form>
      <!-- <img src="images/grayotcBot.jpg" class="fl">-->
        <div class="cl"></div></div>   

    <?php include_once "inc/footer.php"; ?>

<?php if (isset($_SESSION['errorMSGE']) && ($_SESSION['errorMSGE'] != '')) { ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $.colorbox({width: "auto", height: "auto", inline: true, href: "#errormassage"});
            });

        </script>
<?php } ?>

    <div  style="display:none;">
        <div id='inline_saveContinue' style="text-align:center;">
            <div class="pop1 fl" id="savebtn">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="fl">
                    <tr>
                        <td height="30">Your Proposal will be saved and sent as it is to your id</td>
                    </tr>
                    <tr>
                        <td height="30"><input name="confirmMail" id="confirmMail"  type="text" class="mailid" value="" /></td>
                    </tr>
                    <tr>
                        <td height="30">So that you may continue later from it.</td>
                    </tr>
                    <tr>
                        <td height="50" align="center"><input id="saveproposalbtn" name="image" type="image" src="images/proposalbutton.png" onClick="saveform();" style="border:none;"  /></td>
                    </tr>
                </table>
                <div class="cl"></div>
            </div>
        </div>
    </div>


    <div style="display:none">
        <div class="pop1 fl" id="errormassage">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="fl">
                <tr>
                    <td height="30"><?php
                        echo $_SESSION['errorMSGE'];
                             unset($_SESSION['errorMSGE']);
                        ?> </td>
                </tr>

            </table>
            <div class="cl"></div>
        </div>
    </div>

        
        
    <div  style="display:none;">
        <div id='inline_proceedpaystatus'>
            <div class="pop_proceed fl" id="issuanceresult">
<?php if ($resultAllData[0]['PREMIUM_AMT'] != $resultAllData[0]['PREMIUM_AMOUNT']) { ?>
                    <h3>The DOB of eldest member to be insured is different from the age range you selected while taking quote. Hence, the total premium is revised from &nbsp;&nbsp;
                        <img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/> <?php echo $resultAllData[0]['PREMIUM_AMOUNT']; ?> to <img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/> <?php echo $resultAllData[0]['PREMIUM_AMT']; ?>.</h3>
<?php } ?>
                <form action="" method="POST" name="submitPMT" id="submitPMT">
                    <div class="pop_proceedContainer">
                        <img src="images/yourProposalSummary.jpg" alt="your proposal" class="fl" style="margin:-1px 0 0 -1px;" />

                        <div class="proceedTable">
                            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                <tr>
                                    <td width="225" align="left" bgcolor="#ededed"><strong>Application No</strong></td>
                                    <td width="264" align="center" bgcolor="#ededed"><strong>Plan Type</strong></td>
                                    <td width="259" align="center" bgcolor="#ededed"><strong>Policy Period</strong></td>
                                </tr>
                                <tr>
                                    <td align="left"><a href="javascript://"><input type="hidden" name="proposalNumberOnsnapshot" id="proposalNumberOnsnapshot" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>"/><?php echo $resultAllData[0]['PROPOSAL_ID']; ?></a></td>
                                    <td align="center"><?php 
                                    $procode = trim($resultAllData[0]['PRODUCTCODE']);
                                     foreach($plancode as $key=>$values) { 
                                           if(in_array($procode, $values)) 
                                                { 
                                               echo $key;
                                               }  
                                                } 
                                     ?>   </td>
                                    <td align="center"><?php echo $resultAllData[0]['TENURE']; //echo $noofday = no_of_days($UTM_SOURCE['tripStartDate'], $UTM_SOURCE['tripEndDate']);  ?> Days</td>
                                </tr>
                            </table>
                        </div>

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
                            <tr>
                                <td width="74%" height="65" align="right" valign="middle" class="pdingTop"><strong>Sum Insured : </strong>
                                    <label><strong style="color:#5c9a1b;"><img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/><?php echo moneyFormatIndia($resultAllData[0]['INSURANCE_AMT']); ?></strong></label></td>
                                <td width="26%">
                                    <table width="199" border="0" align="right" cellpadding="0" cellspacing="0">
                                     <tr>
                                      <td class="bgimg_large tdpad">Your premium is: <img alt="rupees" height="10" src="images/rupeesymbol_wh.png"/> <?php echo moneyFormatIndia($resultAllData[0]['PREMIUM_AMT']); ?></td>
                                    </tr>
                                    </table></td>
                            </tr>
                        </table>


                    </div>

                    <div class="pop_proceedContainerbelow">
                        <div class="proceedTable">
                            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                <tr>
                                    <td width="225" align="left" bgcolor="#ededed"><strong>Person(s) Covered</strong></td>
                                    <td width="264" align="center" bgcolor="#ededed"><strong>Date Of Birth</strong></td>
                                    <td width="259" align="center" bgcolor="#ededed"><strong>Your Contact Address</strong></td>
                                </tr>
                                <?php
                                $dep1 = 0;
                                for ($i1 = 1; $i1 <= $resultAllData[0]['MEMBER_COUNT']; $i1++) {
                                    ?>
                                    <tr>
                                        <td align="left"><a href="javascript://"><?php echo $jsonDependentDetail[$dep1]->titleCd . '&nbsp;' . $jsonDependentDetail[$dep1]->firstNameCd . '&nbsp;' . $jsonDependentDetail[$dep1]->lastNameCd ?></a></td>
                                        <td align="center"><?php echo $jsonDependentDetail[$dep1]->dOBCd; ?></td>
                                        <td align="center"><?php echo $resultAllData[0]['ADDRESS_1'] . ',&nbsp;' . $resultAllData[0]['STATE'] . ',&nbsp;' . $resultAllData[0]['PIN_CODE']; ?> </td>
                                    </tr>

                                    <?php
                                    $dep1++;
                                }
                                ?>
                            </table>
                        </div>
                        
                        <div class="proceedTable">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border:0px;">
                                <tr>
                                    <td width="440" align="right">
                                        <input type="image" class="payddandcheck" src="images/preceed_payFloat_btn.jpg" style="border:none" onClick="return runTransactionApi();">
                                        <!--<img src="images/preceed_payFloat_btn.jpg" style="cursor:pointer;" onClick="proceedfloat(); runTransactionApi();">-->
                                        <!--<input type="image" class="payddandcheck" src="images/preceed_payFloat_btn.jpg" style="border:none">-->
                                    </td>
									<td width="100" align="right"><img class='loader' src="images/loading.gif" alt='' style="display:none"></td>
                                    <td width="100" align="right"><div id="proceedfloatresult"></div></td>
                                    <td width="250" align="right"><a href="javascript://" onClick="hideColorBox();" class="backEdit"><< Back to Edit</a></td>
                                </tr>
                                <!--<tr>
                                     <td width="290" align="right"><input type="image" class="payddandcheck"   src="images/proceedtopay.jpg" style="border:none"></a></td>
                                                                    <td width="200" align="right"><input type="image" name="save" src="images/save_emailBtn.jpg" value="" style="border: none; cursor: pointer;" onClick="checkClickEvent(2);" class="saveContinue savebtn"/></td>	
                                    <td width="318" align="right"><a href="javascript://" onClick="hideColorBox();" class="backEdit"><< Back to Edit</a></td>
                                </tr>-->
                            </table>
                        </div>
                        
                        
                    </div>
                    
                    <input type="hidden" id="proposalno" name="proposalno" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>">
                    <input type="hidden" id="premiumno" name="premiumno" value="<?php echo moneyFormatIndia($resultAllData[0]['PREMIUM_AMT']); ?>">
                    
                </form>
                
                
                <div class="cl"></div>
            </div>
            
            <div class="pop_proceed fl" id="issuanceerrorresult" style="display:none;">
                <div class="cl"></div>
                <div style="height:100px; margin-top:40px;">
                    <h3 style="text-align:center; color:red; font-weight:bold;"><span id="errortext">The Certificate of Insurance cannot be issued due to insufficient balance. Please contact system administrator</span></h3>
                </div>
                <div class="cl"></div>
            </div>

        </div>
    </div>


    <!-- 
     <div style="display:none;">
         <div id='inline_proceedpay_dd'>
             <div class="pop_otc fl">
                 <h3>Issue Policy Page</h3>
                 
                 <form action="thank.php" id="thankPage" method="POST" name="thankPage" class="thankPage">
                     <div class="pop_proceedContainer">
                         <img src="images/yourProposalSummary.jpg" alt="your proposal" class="fl" style="margin:-1px 0 0 -1px;" />
 
                         <div class="proceedTable">
                             <div class="feveo_otc_left">
 
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderno">                                    
                                     <tr>
                                         <td width="49%" height="40" colspan="2"></td>                                        
                                         <td width="51%" height="0">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderno">
                                                 <tr>
                                                     <td width="55%" align="center">
                                                         <input name="micrHide" class="micrHide" type="radio" value="show" checked="checked" /> Micr
                                                     </td>
                                                     <td width="45%" align="left">
                                                         <input name="micrHide" class="micrHide" type="radio" value="hide" />Non-Micr
                                                     </td>
                                                 </tr>
                                             </table>
 
                                         </td>
                                     </tr>
 
 
                                     <tr>
                                         <td width="41%" height="40">Payment Method <img src="images/questionsmark.png" border="0"></td>
                                         <td width="8%" height="0">:</td>
                                         <td width="51%" height="0">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderno">
                                                 <tr>
                                                     <td width="55%" align="center"><input name="policypage[paymentMethod]" type="radio" value="CHEQUE" checked="checked" /> Cheque</td>
                                                     <td width="45%" align="left"><input name="policypage[paymentMethod]" type="radio" value="DD" /> DD</td>
                                                 </tr>
                                             </table>
 
                                         </td>
                                     </tr>
                                     <tr>
                                         <td height="0">Amount <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0"><input name="policypage[amount]" type="text" value="<?php echo $resultAllData[0]['PREMIUM_AMT']; ?>" readonly class="medium_inputHealth mob_inputHealth gapB" /></td>
                                     </tr>
                                     <tr>
                                         <td height="0">Bank Name <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0"><input name="policypage[bankname]" id="policypagebankname" type="text" value="" class="medium_inputHealth mob_inputHealth gapB" /></td>
                                     </tr>
                                     <tr>
                                         <td height="0">Payment Type <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0">
                                             <select style="width:185px;" name="policypage[paymenttype]" id="paymentType">
                                                 <option value="">Select</option>
                                                 <option>House</option>
                                                 <option>Local</option>
                                                 <option>Outstation</option>
                                             </select>
 
                                         </td>
                                     </tr>
                                     <tr>
                                         <td height="0">Transaction Date <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0"><input id="transactiondate" name="policypage[transactiondate]" type="text"  onclick="scwShow(scwID('transactiondate'), event, '<?php echo $curentData; ?>');" class="medium_inputHealth mob_inputHealth gapB" /></td>
                                     </tr>
                                 </table>
 
 
 
                             </div>
                             <div class="feveo_otc_left">
 
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderno">
                                     <tr class="micrHideShow">
                                         <td width="41%" height="0">MICR <img src="images/questionsmark.png" border="0"></td>
                                         <td width="8%" height="0">:</td>
                                         <td width="51%" height="0"><input name="policypage[MICR]" onBlur="checkMicr();" id="micr" type="text" value=""  class="medium_inputHealth mob_inputHealth gapB" /></td>
                                     </tr>
                                     <tr>
                                         <td height="0">Branch Name <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0"><input name="policypage[BranchName]" id="policypageBranchName" type="text" value=""  class="medium_inputHealth mob_inputHealth gapB" /></td>
                                     </tr>
                                     <tr>
                                         <td height="0">Transaction ID  <img src="images/questionsmark.png" border="0"></td>
                                         <td height="0">:</td>
                                         <td height="0">
                                             <input name="policypage[TransactionID]" type="text" id="transactionID" class="medium_inputHealth mob_inputHealth gapB" maxlength="8"/>
                                             <input name="policypage[proposalNum]" type="hidden" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>"  />
                                             <input name="policypage[pageName]" type="hidden" value="assure"  />
                                             <input name="policypage[redirectTo]" type="hidden" value="care_pdf"  />
                                             <input name="policypage[id]" type="hidden" value="<?php
    if (isset($_REQUEST['id'])) {
        echo $_REQUEST['id'];
    }
    ?>"  />
                                         </td>
                                     </tr>
                                 </table>
 
                             </div>
                         </div>
 
                         <div class="proceedTable">
                             <table width="810" border="0" cellspacing="0" cellpadding="0" class="fl" style="border:0px;">
                                 <tr>
                                     <td width="490" align="right">
                               <img src="images/Faveo-OTC_submit.jpg" onClick="chequeddvalidate()" style="cursor:pointer;"/> </td>								
                                     <td width="318" align="right"><a href="javascript://" onClick="backPrevious()" class="backEdit"><< Back to Previous Page</a></td>
                                 </tr>
                             </table>
                         </div>
 
 
                     </div>
                 </form>
                 <div class="cl"></div>
             </div>
 
 
         </div>
     </div>
    
    -->



    <script type="text/javascript">
        $(document).ready(function () {
            // $("#proposal_form").show();
            checkMobileTravel();
            //$("#clickbuy").click(function() {
            $("#carebuynowimage").click(function () {
                /*var qdob = $("#qdob").val();
                 if(qdob=='') {
                 alert("Please enter age of eldest member.");
                 return false;
                 }*/

                //$("#getSearch").hide();
                //$("#proposal_form").show();
                //$("#datepicker").val(qdob);
            });




            $("#editquote").click(function () {
                var datepickerres = $("#datepicker").val();
                $("#getSearch").show();
                //$("#qdob").val(datepickerres);
                $("#proposal_form").hide();
                //assuresearch();
                // window.history.go(-1); return false;
            });

            /*   Vary Micr and Non-Micr */

            /*
             $('.micrHide').change(function(){
             if($(this).val()  === 'hide')
             $('.micrHideShow').fadeOut('slow');
             else
             $('.micrHideShow').fadeIn('slow');
             });
             */

        });
    </script>
    
    <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 1 && !@$_POST['popuphide'] ) { ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $.colorbox({width: "auto", height: "auto", inline: true, href: "#inline_proceedpaystatus"});
                //$(".payddandcheck").colorbox({width: "auto", height: "auto", inline: true, href: "#inline_proceedpay_dd"});
            });
            //$("#getSearch").hide();
            //$("#proposal_form").show();
        </script>
        <?php
    }
    /*
      } else if ((isset($_REQUEST['code'])) || (isset($_REQUEST['checkPageOpen']) && $_REQUEST['checkPageOpen'] == 9)) {	?>
      <script type="text/javascript">
      $(document).ready(function() {
      //$("#getSearch").hide();
      //$("#proposal_form").show();
      });
      </script>
      <?php } else { ?>
      <script type="text/javascript">
      $(document).ready(function() {
      $("#proposal_form").hide();
      $("#getSearch").show();
      //assuresearch();
      });
      </script>
      <?php } */
    ?>

<!--<script src="js/jquery.validation.functions_care.js" type="text/javascript"></script>-->
    <script type="text/javascript">
        $(document).ready(function () {
            // $("#proposal_form").hide();
            //$("#getSearch").show();
            //assuresearch();
        });
    </script>



<?php if (isset($_REQUEST['id'])) { ?>
        <script type="text/javascript">
            checkFirstInc(<?php echo $numberOfAdult; ?>);
        </script>
    <?php if ($questionArrayResult['yesNoExist']['pedYesNo'] == 1) { ?>
            <script type="text/javascript">
                setVisibility('id1', 'inline');
            </script>

            <?php foreach ($questionArray as $questionArrayClass => $clasVal) {
                for ($cl = 1; $cl <= $numberOfAdult; $cl++) {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            displayQuestion(<?php echo $cl; ?>);
                            insuredCdQuestionChkEdit(<?php echo $questionArrayClass; ?>,<?php echo $cl; ?>,<?php echo date("Y"); ?>);
                        });
                    </script>
                <?php
                }
            }
        } if ($questionArrayResult['HEDHealthHospitalized']['H001'] == 1) {
            ?>
            <script type="text/javascript">
                setVisibility('id2', 'inline');
            </script>
    <?php
    }
    if ($questionArrayResult['HEDHealthClaim']['H002'] == 1) {
        ?>
            <script type="text/javascript">
                setVisibility('id3', 'inline');
            </script>
        <?php
        }
        if ($questionArrayResult['HEDHealthDeclined']['H003'] == 1) {
            ?>
            <script type="text/javascript">
                setVisibility('id4', 'inline');
            </script>
        <?php
        }
        if ($questionArrayResult['HEDHealthCovered']['H004'] == 1) {
            ?>
            <script type="text/javascript">
                setVisibility('id5', 'inline');
            </script>
    <?php }
}
?>
</body>

</html>


<script type="text/javascript">

/**
 * Run Transacion Api. 
 * 1. Check Agent Balance is sufficient for the transaction or not.
 * 2. Deduct Agent balance.
 * 3. Check Akbar Balance is sufficient for the transaction or not. 
 * 4. If Akbar balance is not sufficient, Return Agent balance.
 * 5. Else deduct Akbar balance.
 * 6. And CheckDD C2LBIZ.
 */
function runTransactionApi()
{
    $.ajax({ 
                type: "POST", 
                url: "api/transactionapi.php",
                //dataType:'json',
                data: {proposalno : $("#proposalno").val(), premiumno: $("#premiumno").val()}, 
                beforeSend: function(){
                                $('.loader').css('display', 'block');
                                //$('#inline_proceedpaystatus').close();		
                       
                            },                            
                success: function(data) {                              
                            //$('.loader').css('display', 'none');  							
//							
//							$.colorbox.close();   
			
                            if(data=='agentadditiondone')
                            {
                                alert('This transaction could not be completed due to low balance of Akbar.');
                            }
                            $.colorbox.close();
                          },			
         });
		 return false;
}
 


</script>