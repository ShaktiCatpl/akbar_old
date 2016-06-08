<?php
include_once("conf/session.php");
include 'inc/conf.php';
$propasalPage = "0";
if (isset($_REQUEST['id'])) {
    $requestedId = sanitize_data($_REQUEST['id']);
    $checkCode = sanitize_data($_REQUEST['code']);
    $checkId = hash('sha256', "proposal-$requestedId");
    if ($checkCode != $checkId) {
        $propasalPage = "1";
    }
    $resultAllData = fetchListByColumnName('REFERENCE_DATA', $requestedId);
    
   //echo '<pre>';print_r($resultAllData);exit;
    
    
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
if (isset($UTM_SOURCE['QuotationDOB'])) {
    $QuotationDOB = sanitize_data($UTM_SOURCE['QuotationDOB']);
} else {
     $QuotationDOB = date('d/m/Y',time()-630720000);
}
if (isset($resultData['SUMINSURED'])) {
    $sumInsured = sanitize_data($resultData['SUMINSURED']);
} else {
    $sumInsured = '';
}

if (isset($resultData['INSURANCE_AMT'])) {
    $sInsuredAmount = sanitize_data($resultData['INSURANCE_AMT']);
} else {
    $sInsuredAmount = '';
}
if (isset($resultData['PREMIUM_AMOUNT'])) {
    $finalPremiumCheck = sanitize_data($resultData['PREMIUM_AMOUNT']);
} else {
    $finalPremiumCheck = '';
}
//echo '<pre>';print_r($resultData);exit;

if (isset($resultData['ELDEST_MEMBER_AGE'])) {
    $ageGroupOfEldestMember = sanitize_data($resultData['ELDEST_MEMBER_AGE']);
} else {
    $ageGroupOfEldestMember = '';
}


if($sumInsured != '') {


$assureSI = array(
        "005" => "500000",
        "010" => "1000000",
        "011" => "1500000",
        "012" => "2000000",
        "014" => "3000000",
        "018" => "5000000",
        "022" => "7500000",
        "023" => "10000000"
    );

if (($ageGroupOfEldestMember == '51 - 55') || ($ageGroupOfEldestMember == '56 - 60') || ($ageGroupOfEldestMember == '61 - 65')) {
        $assureSumI = array(
            "500000" => "200000",
            "1000000" => "300000"
        );
        $sumInsuredValue1 = $assureSI[$sumInsured];
        $individualInsuredAmountAssure1 = $assureSumI[$sumInsuredValue1];
        $sumInsuredValue = "500000";
        $individualInsuredAmountAssure = "200000";
    } else {

        $assureSumI = array(
            "500000" => "200000",
            "1000000" => "300000",
            "1500000" => "400000",
            "2000000" => "500000",
            "3000000" => "600000",
            "5000000" => "700000",
            "7500000" => "800000",
            "10000000" => "900000"
        );
        
        $sumInsuredValue1 = "500000";
        $individualInsuredAmountAssure1 = "200000";
        $sumInsuredValue = $assureSI[$sumInsured];
        $individualInsuredAmountAssure = $assureSumI[$sumInsuredValue];
    }
} else {
    $individualInsuredAmountAssure = '100000';
    $sumInsuredValue1 = '500000';
    $individualInsuredAmountAssure1 = '100000';
    $sumInsuredValue = '500000';
}



//if (isset($resultData['INSURANCE_AMT'])) {
//    $individualInsuredAmountAssure = sanitize_data($resultData['INSURANCE_AMT']);
//    $sumInsuredValue1 = '500000';
//} else {
//    $individualInsuredAmountAssure = '100000';
//    $sumInsuredValue1 = '500000';
//}

if (isset($resultData['TENURE'])) {
    $tenure = sanitize_data($resultData['TENURE']);
} else {
    $tenure = '1';
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
    $agentId = $_SESSION['username'];
}
if (isset($resultData['MOBILE_NO'])) {
    $mobileNum = sanitize_data($resultData['MOBILE_NO']);
} else {
    $mobileNum = '';
}

$coverType = "INDIVIDUAL";
$productCode = "20001004";
$source = "FAVEO";
$productFamily = "ASSURE";
$numberOfAdult = "1";
$numberOfChildren = "0";

if ($propasalPage == "1") {
    header("LOCATION:error.php");
    exit;
}


include 'inc/topScript.php';
?>
<script type="text/javascript">
function chequeddvalidate(){
	var policypagebankname 		= 		$( "#policypagebankname").val();
	var paymentType 		= 		$( "#paymentType").val();
	var transactiondate 		= 		$( "#transactiondate").val();
	var micr 			= 		$( "#micr").val();
	var policypageBranchName 	= 		$( "#policypageBranchName").val();
	var transactionID 		= 		$( "#transactionID").val();
        
	if(micr=='') {
		alert("Please enter micr number");
		$("#micr").focus();
		return false;
	}
	if(policypagebankname=='') {
		alert("Please enter bank name");
		$("#policypagebankname").focus();
		return false;
	}
	if(paymentType=='') {
		alert("Please enter bank name");
		$("#paymentType").focus();
		return false;
	}
	if(transactiondate=='') {
		alert("Please enter transaction date");
		$("#transactiondate").focus();
		return false;
	}	
	if(policypageBranchName=='') {
		alert("Please enter bank branch name");
		$("#policypageBranchName").focus();
		return false;
	}
	if(transactionID=='') {
		alert("Please enter transaction id");
		$("#transactionID").focus();
		return false;
	}
	document.getElementById("thankPage").submit();
}
</script>
<body>
    <script type="text/javascript" src="js/wz_tooltip.js"></script>
    <?php include 'inc/header.php'; ?>
    <?php include 'inc/navigation.php'; ?>
    <div class="page_nav">
        <a href="home.php">Home</a> » Quotation » Assure</div>
    <?php include 'inc/editAssure.php'; ?>
    <div class="mid_inner_container_otc" id="proposal_form" >
        <div class="quoteBoxgreenUp fl"><a href="javascript://"  id="editquote">Edit Quote</a></div>
        <form action="savePageassure.php" method="post" class="AdvancedForm" name="savePageassureForm" id="savePageassureForm">
            <input type="hidden" name="proposalRequestId" id="proposalRequestId" value="<?php echo $requestedId; ?>" />
            <input type="hidden" name="proposalSumInsured" id="proposalSumInsured" value="<?php echo $sumInsured; ?>" />
            <input type="hidden" name="proposalageGroupOfEldestMember" id="proposalageGroupOfEldestMember" value="<?php echo $ageGroupOfEldestMember; ?>" />
            <input type="hidden" name="totalAdultMember" id="totalAdultMember" value="<?php echo $numberOfAdult; ?>"/>
            <input type="hidden" name="totalChildMember" id="totalChildMember" value="<?php echo $numberOfChildren; ?>"/>
            <input type="hidden" name="proposalProductCode" id="proposalProductCode" value="<?php echo $productCode; ?>"/>
            <input type="hidden" name="proposalDummySi" id="proposalDummySi" value="<?php echo $sInsuredAmount; ?>"/>
            <input type="hidden" name="saveandcontinueemail"  id="saveandcontinueemail" value=""/>
            <input type="hidden" name="agentId"  value="<?php echo $agentId; ?>"/>
            <input type="hidden" name="proposalTenourCode" id="proposalTenourCode" value="<?php echo $tenure; ?>"/>
            <input type="hidden" name="rmCode"  value="<?php echo $rmCode; ?>"/>
            <input type="hidden" name="permiumamountValid" id="permiumamountValid" value="<?php echo $finalPremiumCheck; ?>"/>
            <input type="hidden" name="branchCode"  value="<?php echo $branchCode; ?>"/>
            <input type="hidden" name="quotationReferenceNum"  value="<?php echo $quotationReferenceNum; ?>"/>
            <input type="hidden" name="productFamily"  value="<?php echo $productFamily; ?>"/>
            <input type="hidden" name="source"  value="<?php echo $source; ?>"/>
            <input type="hidden" name="productCode"  value="<?php echo $productCode; ?>"/>
            <input type="hidden" name="coverType"  value="<?php echo $coverType; ?>"/> 
            <input type="hidden" name="QuotationDOB" id="QuotationDOB"  value="<?php echo $QuotationDOB; ?>"/>       
            <div class="quotetopbarotc fl">Your Proposal Form</div>
            <div class="quoteresultmidotc fl">
                <div class="proposerDetailBox fl">
                    <h1>Proposer’s Details</h1>

                    <div class="proposerDetailBoxForm fl">
                        <table width="949" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="119" valign="top"><div id="ValidTitleAddClass" class="dropbox_OTC" style="width:85px;">
                                                    <select id="ValidTitle" name="ValidTitle" onChange="changeTitleList();"  class="styled width80">
                                                        <option value="0" <?php if ($INITIALS == '0') { ?> selected="selected" <?php } ?>>Title</option>
                                                        <option value="MR" <?php if ($INITIALS == 'MR') { ?> selected="selected" <?php } ?>>Mr</option>
                                                        <option value="MS" <?php if ($INITIALS == 'MS') { ?> selected="selected" <?php } ?>>Ms</option>
                                                    </select>

                                                </div></td>
                                            <td width="203" valign="top"><input name="ValidFName" id="ValidFName" type="text" onBlur="changeTitleList();" placeholder="First name"  class="txtfield_OTC" style="width:170px;" value="<?php echo $FIRST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="205" valign="top"><input type="text" name="ValidLName" id="ValidLName" onBlur="changeTitleList();" class="txtfield_OTC" style="width:170px;" placeholder="Last Name" value="<?php echo $LAST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="198" valign="top"><input type="text" name="DOB" id="datepicker" class="txtfield_OTCDate" onClick="scwShow(scwID('datepicker'), event, '01/01/1975');" onBlur="changeTitleList();" style="width:170px;" placeholder="DOB - DD/MM/YYYY" value="<?php echo $DOB; ?>" /></td>
                                            <td width="224" valign="top"><input type="text" name="ValidMobileNumber" maxlength="10"  id="ValidMobileNumber" class="txtfield_OTC" style="width:200px;" placeholder="Mobile No." value="<?php echo $mobileNum; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="374" valign="top"><input type="text" name="ValidAddressOne" id="ValidAddressOne" class="txtfield_OTC" style="width:350px;" placeholder="Address Line 1" value="<?php echo $ADDRESS_1; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="374" valign="top"><input type="text" name="ValidAddressTwo" id="ValidAddressTwo" class="txtfield_OTC" style="width:350px;" placeholder="Address Line 2" value="<?php echo $ADDRESS_2; ?>" /></td>
                                            <td width="201" valign="top"><input type="text" name="ValidEmail" id="ValidEmail" class="txtfield_OTC" style="width:177px;" placeholder="Email Id" value="<?php echo $EMAIL_ID; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="281" valign="top"><input type="text" name="NomineeName" id="NomineeName" class="txtfield_OTC" style="width:245px;" placeholder="Nominee Name" value="<?php echo $NomineeName; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="110" valign="top"><div class="dropbox_OTC" id="ValidRelationAddClass" style="width:85px;">
                                            <select id="nomineeRelation"  name="nomineeRelation" class="styled width80" style="font-weight:normal;">
                                                <option value="0" <?php if ($nomineeRelation == '0') { ?> selected="selected" <?php } ?>>Relation</option>
                                                <option value="WIFE" <?php if ($nomineeRelation == 'WIFE') { ?> selected="selected" <?php } ?>>Wife</option>
                                                <option value="MOTHER" <?php if ($nomineeRelation == 'MOTHER') { ?> selected="selected" <?php } ?>>Mother</option>
                                                <option value="HUSBAND" <?php if ($nomineeRelation == 'HUSBAND') { ?> selected="selected" <?php } ?>>Husband</option>
                                                <option value="DAUGHTER" <?php if ($nomineeRelation == 'DAUGHTER') { ?> selected="selected" <?php } ?>>Daughter</option>
                                                <option value="SON" <?php if ($nomineeRelation == 'SON') { ?> selected="selected" <?php } ?>>Son</option>
                                                <option value="FATHER" <?php if ($nomineeRelation == 'FATHER') { ?> selected="selected" <?php } ?>>Father</option>
                                                <option value="SIBLING" <?php if ($nomineeRelation == 'SIBLING') { ?> selected="selected" <?php } ?>>Sibling</option>
                                                <option value="GRANDMOTHER" <?php if ($nomineeRelation == 'GRANDMOTHER') { ?> selected="selected" <?php } ?>>Grand Mother</option>
                                                <option value="GRANDFATHER" <?php if ($nomineeRelation == 'GRANDFATHER') { ?> selected="selected" <?php } ?>>Grand Father</option>
                                                <option value="SISTERINLAW" <?php if ($nomineeRelation == 'SISTERINLAW') { ?> selected="selected" <?php } ?>>Sister-In-Law</option>
                                                <option value="BROTHERINLAW" <?php if ($nomineeRelation == 'BROTHERINLAW') { ?> selected="selected" <?php } ?>>Brother-In-Law</option>
                                                <option value="BROTHER" <?php if ($nomineeRelation == 'BROTHER') { ?> selected="selected" <?php } ?>>Brother</option>
                                                <option value="SISTER" <?php if ($nomineeRelation == 'SISTER') { ?> selected="selected" <?php } ?>>Sister</option>
                                                <option value="MOTHERINLAW" <?php if ($nomineeRelation == 'MOTHERINLAW') { ?> selected="selected" <?php } ?>>Mother In Law</option>
                                            </select>
                                             </div></td>
                                            <td width="127" valign="top"><input type="text" maxlength="6" name="ValidPinCode" id="ValidPinCode" onBlur="getCityName();" class="txtfield_OTC" style="width:90px;" placeholder="Pincode" value="<?php echo $PIN_CODE; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="230" valign="top"><div class="dropbox_OTC" style="width:190px; display:inline-block;">
                                            <select name="ValidCityName" id="ValidCityName" class="styled" style="width:185px; font-weight:normal;">
                                           <option value="<?php if ($CValidCityName != '') { echo $CValidCityName; }   ?>"><?php
                                                                    if ($CValidCityName != '') {
                                                                        echo $CValidCityName;
                                                                    } else {
                                                                        ?>City (Auto on Pincode) <?php } ?> </option>
                                                    </select>
                                                </div>
                                                &nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="201" valign="top"><input type="text"  value="<?php echo $CValidStateName; ?>" name="ValidStateName" id="ValidStateName" class="txtfield_OTC" style="width:177px;" placeholder="State" /></td>
                                        </tr>
                                    </table></td>
                            </tr>
                        </table>
                    </div>

                    <h1>Details of person (s) to be insured</h1>
                </div>

                <?php
                $self = 0;
                $dep = 0;
                for ($i = 1; $i <= $numberOfAdult; $i++) {
                    ?>
                    <input type="hidden" name="checkrelationidposition" id="checkrelationidposition" value="<?php echo $self; ?>"/>
                    <div class="proposerDetailBoxFormgray fl">
                        <table width="949" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="115" valign="top"><div id="ValidRelationAddClass-<?php echo $i; ?>" class="dropbox_OTC" style="width:85px;">
                                        <select name="relationCd[]" id="relationCd-<?php echo $i; ?>" class="styled" onChange="changeTitleCd(this,<?php echo $i; ?>);" style="width:80px; font-weight:normal;">
                                            <option value="0" <?php if (@$jsonDependentDetail[$dep]->relationCd == '0') { ?> selected="selected" <?php } ?>>Relation</option>
                                            <option value="SELF" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SELF') { ?> selected="selected" <?php } ?>>Self</option>
                                            <option value="SPSE" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SPSE') { ?> selected="selected" <?php } ?>>Spouse</option>
                                            <option value="SONM" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SONM') { ?> selected="selected" <?php } ?>>Son</option>
                                            <option value="UDTR" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'UDTR') { ?> selected="selected" <?php } ?>>Daughter</option>
                                            <option value="FATH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'FATH') { ?> selected="selected" <?php } ?>>Father</option>
                                            <option value="MOTH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MOTH') { ?> selected="selected" <?php } ?>>Mother</option>
                                            <optgroup label="----------------------" style="padding:5px 0px;"></optgroup>
                                            <option value="MANT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MANT') { ?> selected="selected" <?php } ?>>Auntie</option>
                                            <option value="BOTH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'BOTH') { ?> selected="selected" <?php } ?>>Brother</option>

                                            <option value="FLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'FLAW') { ?> selected="selected" <?php } ?>>Father In Law</option>
                                            <option value="GDAU" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GDAU') { ?> selected="selected" <?php } ?>>Grand Daughter</option>
                                            <option value="GFAT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GFAT') { ?> selected="selected" <?php } ?>>Grand Father</option>
                                            <option value="GMOT" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GMOT') { ?> selected="selected" <?php } ?>>Grand Mother</option>
                                            <option value="GSON" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'GSON') { ?> selected="selected" <?php } ?>>Grand Son</option>


                                            <option value="MLAW" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MLAW') { ?> selected="selected" <?php } ?>>Mother In Law</option>

                                            <option value="NEPH" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'NEPH') { ?> selected="selected" <?php } ?>>Nephew</option>
                                            <option value="NIEC" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'NIEC') { ?> selected="selected" <?php } ?>>Niece</option>

                                            <option value="SIST" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SIST') { ?> selected="selected" <?php } ?>>Sister</option>

                                            <option value="MUNC" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'MUNC') { ?> selected="selected" <?php } ?>>Uncle</option>

                                        </select>
                                    </div></td>
                                <td width="115" valign="top"><div class="dropbox_OTC" style="width:85px;">
                                        <select name="titleCd[]" id="titleCd-<?php echo $i; ?>" class="styled" style="width:80px; font-weight:normal;">
                                                <?php if (isset($jsonDependentDetail[$dep]->titleCd) && ($jsonDependentDetail[$dep]->titleCd != '')) { ?>
                                                <option value="<?php echo $jsonDependentDetail[$dep]->titleCd; ?>"  selected="selected" ><?php
                                                    if ($jsonDependentDetail[$dep]->titleCd == '0') {
                                                        echo "Title";
                                                    } else {
                                                        echo ucfirst(strtolower($jsonDependentDetail[$dep]->titleCd));
                                                    }
                                                    ?></option>
                                            <?php } else { ?>
                                                <option value="0" >Title</option>
                                                <option value="MR">Mr</option>
                                                <option value="MS">Ms</option>
    <?php } ?>
                                        </select>
                                    </div></td>
                                <td width="215" valign="top"><input type="text" name="firstNameCd[]" id="firstNamecd-<?php echo $i; ?>" class="txtfield_OTC" style="width:170px;" placeholder="First Name" value="<?php echo @$jsonDependentDetail[$dep]->firstNameCd; ?>" />
                                    &nbsp;<span class="mandatorytxt">*</span></td>
                                <td width="215" valign="top"><input type="text" name="lastNameCd[]" id="lastNamecd-<?php echo $i; ?>" class="txtfield_OTC" style="width:170px;" placeholder="Last Name" value="<?php echo @$jsonDependentDetail[$dep]->lastNameCd; ?>" />
                                    &nbsp;<span class="mandatorytxt">*</span></td>
                                <td width="289" valign="top"><input type="text" name="dOBCd[]" id="datepickerCD-<?php echo $i; ?>" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" value="<?php echo @$jsonDependentDetail[$dep]->dOBCd; ?>" onClick="var retval = checkDateVal(<?php echo $i; ?>);
                                                                if (retval == false) {
                                                                    return false;
                                                                }
                                                                scwShow(scwID('datepickerCD-<?php echo $i; ?>'), event, '<?php echo $curentData; ?>');" /></td>
                            </tr>
                        </table>
                    </div>
<?php } ?>

                <div class="proposerDetailBox fl">
				 <h1><img src="images/minus_green.jpg" class="fl" onClick="medicaldatahide()" id="medicaldatahideid"><img src="images/plus_green.jpg" class="fl" id="medicaldatashowid" onClick="medicaldatashow()" style="display:none;">Medical & Lifestyle Details</h1>
					<div id="medicallifestyledata">
                    <div class="questionBar fl">
                        <h2 id="clck1">Are you now in good health and entirely free from any mental or physical impairments or deformities? <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Does any person(s) to be insured has any Pre-existing diseases?')" /></h2>
                        <div class="yes_no_box" id="medical_question1">
                            <input type="radio" name="questions[C107]"  value='1' <?php if (isset($questionArrayResult['C107'])) {
    if (@$questionArrayResult['C107'] == 1) {
        ?> checked="checked" <?php }
                               }
?>  id="medical1-1"  />
                            Yes <input name="questions[C107]" type="radio"   value='0' <?php if (isset($questionArrayResult['C107'])) {
                                   if (@$questionArrayResult['C107'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>  id="medical1-2" />
                            No
                        </div>


                        <div class="cl"></div></div>

                    <div class="questionBar fl">
                        <h2 id="clck2">Do you smoke or consume gutkha/pan masala or alcohol ?  <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the above mentioned person(s) to be insured been diagnosed / hospitalized for any illness / injury during the last 48 months?')" /></h2>
                        <div class="yes_no_box" id="medical_question2">
                            <input type="radio" name="questions[C139]" <?php if (isset($questionArrayResult['C139'])) {
                                   if (@$questionArrayResult['C139'] == 1) {
                                       ?> checked="checked" <?php }
                               }
?>  value='1'  />
                            Yes <input name="questions[C139]" type="radio" <?php if (isset($questionArrayResult['C139'])) {
                                   if (@$questionArrayResult['C139'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>   value='0' />
                            No
                        </div>


                        <div class="cl"></div></div>


                    <div class="questionBar fl">
                        <h2 id="clck3">Do you participate or do you intend to participate in any hazardous sports or activities such as motor sports, climbing, parachuting, hang-gliding, or aviation except as a fare-paying passenger  <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="medical_question3">
                            <input type="radio" name="questions[C136]"  <?php if (isset($questionArrayResult['C136'])) {
                                   if (@$questionArrayResult['C136'] == 1) {
                                       ?> checked="checked" <?php }
                               }
?>  value='1' onClick="questionnairedatashow()"  />
                            Yes <input name="questions[C136]" type="radio" <?php if (isset($questionArrayResult['C136'])) {
                                   if (@$questionArrayResult['C136'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>  value='0' onClick="questionnairedatashow()"/>
                            No
                        </div>


                        <div class="cl"></div></div>



				 </div>
                </div>

                <div class="proposerDetailBox fl">
                    <h1><img src="images/minus_green.jpg" class="fl" onClick="questionnairedatahide()" id="questionnairedatahideid"><img src="images/plus_green.jpg" class="fl" id="questionnairedatashowid" onClick="questionnairedatashow()" style="display:none;">Health Questionnaire</h1>
					<div id="questionnairedata">
                    <div class="questionBar fl">
                        <h2 id="clck1">Are you suffering from any Pre-existing Disease?<img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Does any person(s) to be insured has any Pre-existing diseases?')" /></h2>
                        <div class="yes_no_box" id="health_question1">
                            <input type="radio" name="questions[C101]" <?php if (isset($questionArrayResult['C101'])) {
                                   if (@$questionArrayResult['C101'] == 1) {
                                       ?> checked="checked" <?php }
                               }
?>  value='1' onClick="internalhealthshow()" />
                            Yes <input name="questions[C101]"  type="radio" <?php if (isset($questionArrayResult['C101'])) {
                                   if (@$questionArrayResult['C101'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>   value='0' onClick="internalhealthshow()"/>
                            No
                        </div>


                        <div class="cl"></div></div>
                    <div class="doesdont_sectionEssure1 fl gray_brdr doesdont_sectionEssure2">
                        <h3 id="suffer" onClick="internalhealthshow()">Have you ever suffered or do you now suffer from
                            (<span style="text-decoration:underline;">Please click to see
                                list</span>)</h3>
                        <!--Start Section Health Sub Questionnaire ----->
                        <div style="display: none;"  class="do_doesBox1" id="internalhealth">
                            <ul>
                                <li>
                                    <p>Diseases of the circulatory system (e.g. heart trouble,
                                        chest pain, rheumatic fever, high blood pressure, diseases
                                        of tile arteries and veins)?</p>
                                    <div id="health_sub_question1" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion1-1" <?php if (isset($questionArrayResult['C111'])) {
                                                   if (@$questionArrayResult['C111'] == 1) {
                                                       ?> checked="checked" <?php }
                                               }
?>  name="questions[C111]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion1-2" <?php if (isset($questionArrayResult['C111'])) {
                                                   if (@$questionArrayResult['C111'] == 0) {
        ?> checked="checked" <?php }
                                       }
?>  name="questions[C111]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Diseases of the respiratory system (e.g. Tuberculosis,
                                        asthma, Persistent cough, pneumonia or emphysema)?</p>
                                    <div id="health_sub_question2" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion2-1" <?php if (isset($questionArrayResult['C119'])) {
                                           if (@$questionArrayResult['C119'] == 1) {
                                               ?> checked="checked" <?php }
                                       }
?> name="questions[C119]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion2-2" <?php if (isset($questionArrayResult['C119'])) {
                                           if (@$questionArrayResult['C119'] == 0) {
                                               ?> checked="checked" <?php }
                                       }
?> name="questions[C119]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Does the person to be insured has any Kidney/Lung/Liver related Disease?</p>
                                    <div id="health_sub_question3" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion3-1" <?php if (isset($questionArrayResult['C112'])) {
                                                   if (@$questionArrayResult['C112'] == 1) {
                                                       ?> checked="checked" <?php }
                                               }
?> name="questions[C112]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion3-2" <?php if (isset($questionArrayResult['C112'])) {
                                                   if (@$questionArrayResult['C112'] == 0) {
                                                       ?> checked="checked" <?php }
                                               }
?> name="questions[C112]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Diseases of the gastrointestinal system (e.g. digestive
                                        disorders, gastric or duodenal ulcer, hepatitis B, hepatitis
                                        C or other disorders of the liver, disorders of the gall
                                        bladder)?</p>
                                    <div id="health_sub_question4" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion4-1" <?php if (isset($questionArrayResult['C121'])) {
                                                   if (@$questionArrayResult['C121'] == 1) {
                                                       ?> checked="checked" <?php }
                                               }
?> name="questions[C121]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion4-2" <?php if (isset($questionArrayResult['C121'])) {
                                                   if (@$questionArrayResult['C121'] == 0) {
                                                       ?> checked="checked" <?php }
                                               }
?> name="questions[C121]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Diseases of the nervous system or mental disorders (e.g.
                                        stroke, epilepsy, fits or fainting attacks, frequent headaches,
                                        Bacterial Meningitis, Multiple Sclerosis, Motor Neurone
                                        Disorder, nervous breakdown, depression or other mental
                                        or psychiatric disorder)?</p>
                                    <div id="health_sub_question5" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion5-1" name="questions[C122]" <?php if (isset($questionArrayResult['C122'])) {
                                                   if (@$questionArrayResult['C122'] == 1) {
                                                       ?> checked="checked" <?php }
                                               }
?>>
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion5-2" name="questions[C122]" <?php if (isset($questionArrayResult['C122'])) {
                                                   if (@$questionArrayResult['C122'] == 0) {
        ?> checked="checked" <?php }
                                       }
?>>
                                        No </div>
                                </li>
                                <li>
                                    <p>Diabetes mellitus, Cancer or tumour of any kind, or any
                                        disease of the blood, glands, spleen, ears, eyes or skin?</p>
                                    <div id="health_sub_question6" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion6-1" <?php if (isset($questionArrayResult['C113'])) {
                                           if (@$questionArrayResult['C113'] == 1) {
        ?> checked="checked" <?php }
                                       }
?> name="questions[C113]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion6-2" <?php if (isset($questionArrayResult['C113'])) {
                                           if (@$questionArrayResult['C113'] == 0) {
                                               ?> checked="checked" <?php }
                                       }
?> name="questions[C113]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Unexplained nights &ndash;sweat and /or loss of weight, persistent
                                        fever or chronic or recurrent diarrhea, unexplained infections
                                        or swollen glands?</p>
                                    <div id="health_sub_question7" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion7-1" <?php if (isset($questionArrayResult['C124'])) {
                                           if (@$questionArrayResult['C124'] == 1) {
        ?> checked="checked" <?php }
                           }
?> name="questions[C124]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion7-2" <?php if (isset($questionArrayResult['C124'])) {
                                           if (@$questionArrayResult['C124'] == 0) {
                                               ?> checked="checked" <?php }
                                       }
?> name="questions[C124]">
                                        No </div>
                                </li>


                                <li>
                                    <p>Chronic Relapsing Pancreatitis </p>
                                    <div id="health_sub_question10" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion10-1" <?php if (isset($questionArrayResult['C127'])) {
                                           if (@$questionArrayResult['C127'] == 1) {
        ?> checked="checked" <?php }
                               }
?> name="questions[C127]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion10-2" <?php if (isset($questionArrayResult['C127'])) {
                                   if (@$questionArrayResult['C127'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?> name="questions[C127]">
                                        No </div>
                                </li>
                                <li>
                                    <p>Any other diseases or ailments not mentioned above?</p>
                                    <div id="health_sub_question11" class="yes_no_box">
                                        <input type="radio" value="1" id="healthsubquestion11-1" <?php if (isset($questionArrayResult['C128'])) {
                                   if (@$questionArrayResult['C128'] == 1) {
        ?> checked="checked" <?php }
                               }
?>  name="questions[C128]">
                                        Yes
                                        <input type="radio" value="0" id="healthsubquestion11-2" <?php if (isset($questionArrayResult['C128'])) {
                                   if (@$questionArrayResult['C128'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>  name="questions[C128]">
                                        No </div>
                                </li>
                            </ul>
                        </div>
                        <!--End Section Health Sub Questionnaire ----->
                        <div class="cl"></div>
                    </div>
                    <div class="questionBar fl">
                        <h2 id="clck2">Has anyone been diagnosed/hospitalized or under any treatment for any illness/injury during the last 48 months?  <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the above mentioned person(s) to be insured been diagnosed / hospitalized for any illness / injury during the last 48 months?')" /></h2>
                        <div class="yes_no_box" id="health_question3">
                            <input type="radio" name="questions[C116]" <?php if (isset($questionArrayResult['C116'])) {
                                   if (@$questionArrayResult['C116'] == 1) {
                                       ?> checked="checked" <?php }
                               }
?>  value='1' />
                            Yes <input type="radio" name="questions[C116]" <?php if (isset($questionArrayResult['C116'])) {
                                   if (@$questionArrayResult['C116'] == 0) {
                                       ?> checked="checked" <?php }
                               }
?>   value='0'  />
                            No
                        </div>


                        <div class="cl"></div></div>


                    <div class="questionBar fl">
                        <h2 id="clck3">Have you ever had or been advised to have hospital treatment or surgery? <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question4">
                            <input type="radio" name="questions[C109]" value='1' <?php if (isset($questionArrayResult['C109'])) {
                                   if (@$questionArrayResult['C109'] == 1) {
                                       ?> checked="checked" <?php }
                               }
?> />
                            Yes <input type="radio" name="questions[C109]"   value='0' <?php if (isset($questionArrayResult['C109'])) {
                                   if (@$questionArrayResult['C109'] == 0) {
        ?> checked="checked" <?php }
                           }
?> />
                            No
                        </div>


                        <div class="cl"></div></div>


                    <div class="questionBar fl">
                        <h2 id="clck3">In the past 5 years, have you consulted a physician for any reason or have you had any investigation such as blood or urine tests, X-rays, electrocardiograms, ultra sonograms, CT scans or biopsy, other than for routine purposes? <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question5">
                            <input type="radio" name="questions[C132]" <?php if (isset($questionArrayResult['C132'])) {
                                           if (@$questionArrayResult['C132'] == 1) {
        ?> checked="checked" <?php }
                           }
?> value='1'/>
                            Yes <input type="radio" name="questions[C132]" <?php if (isset($questionArrayResult['C132'])) {
                               if (@$questionArrayResult['C132'] == 0) {
                                   ?> checked="checked" <?php }
                           }
?>  value='0' />
                            No
                        </div>


                        <div class="cl"></div></div>

                    <div class="questionBar fl">
                        <h2 id="clck3">Have you or any of your immediate family members (father, mother, brother, or sister) have/had cancer, heart attack, or stroke and at what age? Prior to age 60?<img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question6">
                            <input type="radio" name="questions[C129]" <?php if (isset($questionArrayResult['C129'])) {
                               if (@$questionArrayResult['C129'] == 1) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio" value='1'  />
                            Yes <input type="radio" name="questions[C129]" <?php if (isset($questionArrayResult['C129'])) {
                               if (@$questionArrayResult['C129'] == 0) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio"  value='0'  />
                            No
                        </div>


                        <div class="cl"></div></div>



                    <div class="questionBar fl">
                        <h2 id="clck3">Have you ever had or been advised to have a blood test for AIDS or an AIDS-related condition or have you ever been refused as a blood donor?<img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question7">
                            <input type="radio" name="questions[C131]" <?php if (isset($questionArrayResult['C131'])) {
                               if (@$questionArrayResult['C131'] == 1) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio" value='1'  />
                            Yes <input type="radio" name="questions[C131]" <?php if (isset($questionArrayResult['C131'])) {
                               if (@$questionArrayResult['C131'] == 0) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio"  value='0'  />
                            No
                        </div>


                        <div class="cl"></div></div>


                    <div class="questionBar fl">
                        <h2 id="clck3">Have you ever received or do you now receive any personal accident, disability benefit, or disability-related payments? <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question8">
                            <input type="radio" name="questions[C133]" <?php if (isset($questionArrayResult['C133'])) {
                               if (@$questionArrayResult['C133'] == 1) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio" value='1'  />
                            Yes <input type="radio" name="questions[C133]" <?php if (isset($questionArrayResult['C133'])) {
                               if (@$questionArrayResult['C133'] == 0) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio"  value='0'  />
                            No
                        </div>


                        <div class="cl"></div></div>


                    <div class="questionBar fl">
                        <h2 id="clck3">For females only: Are you pregnant ? <img src="images/question_icon.png" onMouseOut="UnTip()" onMouseOver="Tip('Have any of the person(s) to be insured ever filed a claim with their current / previous insurer?')" /></h2>
                        <div class="yes_no_box" id="health_question9">
                            <input type="radio" name="questions[C137]" <?php if (isset($questionArrayResult['C137'])) {
                               if (@$questionArrayResult['C137'] == 1) {
                                   ?> checked="checked" <?php }
                           }
?> id="radio" value='1' />
                            Yes <input type="radio" name="questions[C137]" <?php if (isset($questionArrayResult['C137'])) {
                            if (@$questionArrayResult['C137'] == 0) {
                                ?> checked="checked" <?php }
                        }
?> id="radio"  value='0' />
                            No
                        </div>


                        <div class="cl"></div></div>

						</div>







                    <div class="termBox fl" id="validTermCondition">
                        <input type="checkbox" value="1" <?php if (@$resultData['TNC_AGREED'] == 1) { ?> checked="checked" <?php } ?> id="validTermCondition-1" name="validTermCondition" />
                        I here by agree to the <a href="javascript:void(0)" onClick="window.open('http://rhicluat.religare.com/proposalterms.html','_blank','width=700,height=515')">term & conditions</a> of the purchase of this policy. *<br />

                    </div>
                    <div class="termBox">
                        <input type="checkbox"  id="recivedSms" name="recivedSms" />
                        Receive Service SMS and E-mail alerts
                    </div>

                    <div class="proceedBox fl">
                         <div style="display:none; margin-bottom: 25px; color: #D00;" class="redtxtBottom" id="errordisplayPrashant">Kindly fill the boxes highlighted in red.</div>
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <input type="hidden" id="checkclickid" name="checkclickid" value="1">
                                    <input type="image" id="FormSubmit"  onclick="checkClickEvent(1);" src="images/preceed_btn.jpg" style="border: none;"/></td>
                                <td><input type="image" name="save" src="images/save_emailBtn.jpg" value="" style="border: none; cursor: pointer;" onClick="checkClickEvent(2);" class="saveContinue savebtn"/></td>								
                            </tr>
                        </table>




                    </div>
                </div>
            </div></form>
        <img src="images/grayotcBot.jpg" class="fl">
        <div class="cl"></div></div>

<?php include_once "inc/footer.php"; ?>


    <div class="feedback_thumb"><a class='example2' href="#"><img src="images/feedback_thumb.png" border="0" /></a></div>



    <div  style='display:none'>
        <div id='inline_example2'>

            <div class="enquiry_popup">   


                <div class="EnquiryCounty fl">
                    <h1>Your Feedback</h1>
                    <ul>
                        <li>
                            <input type="text" class="TextBoxCount" value="Your Full Name">
                        </li>
                        <li><input type="text" class="TextBoxCount" value="Email Address"></li>
                        <li><input type="text" class="TextBoxCount" value="Contact No."></li>
                        <li><textarea cols="" rows="2" class="TextAreaCount"></textarea> </li>
                        <li><div class="cl" align="right" style="padding:5px 12px 0 0;"><a href="#"><img src="images/submit_btn.png" border="0" alt="" title=""></a></div></li>
                    </ul>

                </div>

                <div class="cl"></div></div>

        </div>
        <div class="cl"></div></div>
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
        <div id='inline_proceedpay'>
            <div class="pop_proceed fl">
<?php if ($resultAllData[0]['PREMIUM_AMT'] != $resultAllData[0]['PREMIUM_AMOUNT']) { ?>
                    <h3>The DOB of eldest member to be insured is different from the age range you selected while taking quote. Hence, the total premium is revised from &nbsp;&nbsp;
                        <img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/> <?php echo $resultAllData[0]['PREMIUM_AMOUNT']; ?> to <img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/> <?php echo $resultAllData[0]['PREMIUM_AMT']; ?>.</h3>
<?php } ?>
                <!--                                                                                                    <form action="pmt.php" method="POST" name="submitPMT" id="submitPMT">-->
                <div class="pop_proceedContainer">
                    <img src="images/yourProposalSummary.jpg" alt="your proposal" class="fl" style="margin:-1px 0 0 -1px;" />

                    <div class="proceedTable">
                        <table width="810" border="0" cellspacing="0" cellpadding="10">
                            <tr>
                                <td width="225" align="left" bgcolor="#ededed"><strong>Application No</strong></td>
                                <td width="264" align="center" bgcolor="#ededed"><strong>Plan Type</strong></td>
                                <td width="259" align="center" bgcolor="#ededed"><strong>Policy Period</strong></td>
                            </tr>
                            <tr>
                                <td align="left"><a href="javascript://"><input type="hidden" name="proposalNumberOnsnapshot" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>"/><?php echo $resultAllData[0]['PROPOSAL_ID']; ?></a></td>

                                <td align="center">Assure</td>

                                <td align="center"><?php echo $resultAllData[0]['TENURE']; ?> Year</td>
                            </tr>
                        </table>
                    </div>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
                        <tr>
                            <td width="74%" height="25" align="right" valign="middle" class="pdingTop"><strong>Sum Insured : </strong>
                                <label><strong style="color:#5c9a1b;"><img alt="rupees" height="10" src="images/rupeesymbol_gr.png"/><?php echo moneyFormatIndia($resultAllData[0]['INSURANCE_AMT']); ?></strong></label></td>

                            <td width="26%"><table width="199" border="0" align="right" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="bgimg_large tdpad">Your premium is: <img alt="rupees" height="10" src="images/rupeesymbol_wh.png"/> <?php echo moneyFormatIndia($resultAllData[0]['PREMIUM_AMT']); ?></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>


                </div>

                <div class="pop_proceedContainerbelow">
                    <div class="proceedTable">
                        <table width="810" border="0" cellspacing="0" cellpadding="10">
                            <tr>
                                <td width="225" align="left" bgcolor="#ededed"><strong>Person(s) Covered</strong></td>
                                <td width="264" align="center" bgcolor="#ededed"><strong>Date Of Birth</strong></td>
                                <td width="259" align="center" bgcolor="#ededed"><strong>Your Contact Address</strong></td>
                            </tr>
<?php
$dep1 = 0;
for ($i1 = 1; $i1 <= $numberOfAdult; $i1++) {
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
                        <table width="810" border="0" cellspacing="0" cellpadding="0" class="fl" style="border:0px;">
                            <tr>
                                <td width="290" align="right"><input type="image" class="payddandcheck"   src="images/preceed_dd_btn.jpg" style="border:none"></a></td>
								<td width="200" align="right"><input type="image" name="save" src="images/preceedOnline_btn.jpg" value="" style="border: none; cursor: pointer;" onClick="checkClickEvent(2);" class="saveContinue savebtn"/></td>	
                                <td width="318" align="right"><a href="javascript://" onClick="hideColorBox();" class="backEdit"><< Back to Edit</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--                                                                                                    </form>-->
                <div class="cl"></div>
            </div>


        </div>
    </div>


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
                        <td height="50" align="center"><input name="image" type="image" src="images/proposalbutton.png" onClick="saveform();" style="border:none;"  /></td>
                    </tr>
                </table>
                <div class="cl"></div>
            </div>


        </div>
    </div>



    <div  style="display:none;">
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
                                        <td height="0">Proposal Number</td>
                                        <td height="0">:</td>
                                        <td height="0"><input name="policypage[proposalno]" type="text" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>" readonly class="medium_inputHealth mob_inputHealth gapB" /></td>
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
                                        <td height="0"><input name="policypage[bankname]" readonly id="policypagebankname"  type="text" value="" class="medium_inputHealth mob_inputHealth gapB" /></td>
                                    </tr>
                                    <tr>
                                        <td height="0">Payment Type <img src="images/questionsmark.png" border="0"></td>
                                        <td height="0">:</td>
                                        <td height="0">
                                            <!--                                            <div style="width:85px;" class="drop_Health gapBl" id="ValidTitleAddClass">-->
                                            <select name="policypage[paymenttype]" id="paymentType" style="width:185px;">

                                                <option value="">Select</option>
                                                <option>House</option>
                                                <option>Local</option>
                                                <option>Outstation</option>
                                            </select>
                                            <!--                                            </div>-->
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
									<tr>
                                        <td height="40">&nbsp;</td>
                                        <td height="40">&nbsp;</td>
                                        <td height="40">&nbsp;</td>
                                    </tr>
                                    <tr class="micrHideShow">
                                        <td width="41%" height="0">MICR <img src="images/questionsmark.png" border="0"></td>
                                        <td width="8%" height="0">:</td>
                                        <td width="51%" height="0"><input name="policypage[MICR]" onBlur="checkMicr();" id="micr" type="text" value=""  class="medium_inputHealth mob_inputHealth gapB" /></td>
                                    </tr>
                                    <tr>
                                        <td height="0">Branch Name <img src="images/questionsmark.png" border="0"></td>
                                        <td height="0">:</td>
                                        <td height="0"><input name="policypage[BranchName]" readonly id="policypageBranchName" type="text" value=""  class="medium_inputHealth mob_inputHealth gapB" /></td>
                                    </tr>
                                    <tr>
                                        <td height="0">Transaction ID  <img src="images/questionsmark.png" border="0"></td>
                                        <td height="0">:</td>
                                        <td height="0">
                                            <input name="policypage[TransactionID]" type="text" class="medium_inputHealth mob_inputHealth gapB" id="transactionID" maxlength="8" />
                                            <input name="policypage[proposalNum]" type="hidden" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>"  />
                                            <input name="policypage[pageName]" type="hidden" value="assure"  />
                                            <input name="policypage[redirectTo]" type="hidden" value="assure_pdf"  />
											<input name="policypage[print]" type="hidden" value="assurePrint"  />
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
								<img src="images/Faveo-OTC_submit.jpg" onClick="chequeddvalidate()" style="cursor:pointer;"/>
								<!--<input name="" type="image" img src="images/Faveo-OTC_submit.jpg" border="0" class="otc_submit" />--></td>								
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
    <script type="text/javascript">


                                                        $(document).ready(function() {
                                                            $("#proposal_form").show();
                                                            $("#clickbuy").click(function() {
																var qdob = $("#qdob").val();
																if(qdob=='') {
																	alert("Please enter age of eldest member.");
																	return false;
																}
                                                                $("#getSearch").hide();
                                                                $("#proposal_form").show();
                                                            });
                                                            $("#editquote").click(function() {
                                                                $("#getSearch").show();
                                                                $("#proposal_form").hide();
                                                                assuresearch();
                                                            });


/*   Vary Micr and Non-Micr */

  $('.micrHide').change(function(){
      if($(this).val()  === 'hide')
          $('.micrHideShow').fadeOut('slow');
       else
           $('.micrHideShow').fadeIn('slow');
  });






                                                        });
    </script>

<?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 1) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $.colorbox({width: "auto", height: "auto", inline: true, href: "#inline_proceedpay"});
                $(".payddandcheck").colorbox({width: "auto", height: "auto", inline: true, href: "#inline_proceedpay_dd"});
            });
            $("#getSearch").hide();
            $("#proposal_form").show();
        </script>
<?php } else if(isset($_REQUEST['code'])){ ?>
    <script type="text/javascript">
            $("#getSearch").hide();
            $("#proposal_form").show();
        </script>
    
<?php } else { ?>
        <script type="text/javascript">


            $(document).ready(function() {
                $("#proposal_form").hide();
                $("#getSearch").show();
                assuresearch();
            });
        </script>
<?php } ?>
<?php if (isset($_SESSION['errorMSGE']) && ($_SESSION['errorMSGE'] != '')) {
    ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $.colorbox({width: "auto", height: "auto", inline: true, href: "#errormassage"});
            });

        </script>

<?php } ?>
    <script src="js/assure_know_agent.js" type="text/javascript"></script>
    <script src="js/jquery.validation.functions_assure.js" type="text/javascript"></script>
	<script type="text/javascript">
function backPrevious(){
location.reload(true);
}
$(document).ready(function() {
	var dobval 		= $( "#datepickerCD-1").val();
	if(dobval!= '') {
	$( "#medicallifestyledata").show();
 	$( "#medicaldatahideid").show();
  	$( "#medicaldatashowid").hide();
	$( "#questionnairedata").show();
 	$( "#questionnairedatahideid").show();
  	$( "#questionnairedatashowid").hide();
	}	else {
	$(".termBox").css({'border-top':'0'});
	$( "#medicallifestyledata").hide();
 	$( "#medicaldatahideid").hide();
  	$( "#medicaldatashowid").show();
	$( "#questionnairedata").hide();
 	$( "#questionnairedatahideid").hide();
  	$( "#questionnairedatashowid").show();
	}
});
function questionnairedatahide(){	 
	  $( "#questionnairedata" ).slideUp( "slow", function() {
		// Animation complete.slideDown
	  });
	  $(".termBox").css({'border-top':'0'});
	  $( "#questionnairedatahideid").hide();
	  $( "#questionnairedatashowid").show();
}
function questionnairedatashow(){	 
  $( "#questionnairedata" ).slideDown( "slow", function() {
    // Animation complete.slideDown
  });
  $(".termBox").css({'border-top':'1px dotted #191919'});
  $( "#questionnairedatashowid").hide();
  $( "#questionnairedatahideid").show();
}
function medicaldatahide(){	 
	  $( "#medicallifestyledata" ).slideUp( "slow", function() {
		// Animation complete.slideDown
	  });
	  $( "#medicaldatahideid").hide();
	  $( "#medicaldatashowid").show();
}
function medicaldatashow(){	 
  $( "#medicallifestyledata" ).slideDown( "slow", function() {
    // Animation complete.slideDown
  });
  $( "#medicaldatashowid").hide();
  $( "#medicaldatahideid").show();
}
$( "#datepickerCD-1" ).focusout(function() {	
 	medicaldatashow();
});
$( "#relationCd-1" ).change(function() {	
	var relationval 	= $( "#relationCd-1").val();
	var dobval 			= $( "#datepickerCD-1").val();
	if(relationval=='SELF') {
		if(dobval!='') {
 			medicaldatashow();
		}
	}
});
function internalhealthshow(){
$( "#internalhealth").show();
}
</script>
</body>
</html>
