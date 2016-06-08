<?php
include_once("conf/session.php");
include 'inc/conf.php';

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

 $propasalPage = "0";

if (isset($_REQUEST['id'])) {
    $requestedId = sanitize_data($_REQUEST['id']);
    $checkCode = sanitize_data($_REQUEST['code']);
    $checkId = hash('sha256', "proposal-$requestedId");
    if ($checkCode != $checkId) {
        $propasalPage = "1";
    }   

    $resultAllData = fetchListByColumnName('REFERENCE_DATA', $requestedId);

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

/*echo '<pre>';
print_r($resultData);*/

if (isset($resultData['INITIALS'])) {
    $INITIALS = sanitize_data($resultData['INITIALS']);
}  else {
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
}  else {
    $DOB = '';
}

if (isset($resultData['ADDRESS_1'])) {
    $ADDRESS_1 = sanitize_data($resultData['ADDRESS_1']);
} else {
    $ADDRESS_1 = '';
}
if (isset($UTM_SOURCE['ValidCityName'])) {
    $CValidCityName = sanitize_data($UTM_SOURCE['ValidCityName']);
}  else {
    $CValidCityName = '';
}

if (isset($resultData['STATE'])) {
    $CValidStateName = sanitize_data($resultData['STATE']);
}  else {
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
                $QuotationDOB = date('d/m/Y',time()-630720000);
        }
}
if (isset($_REQUEST['ageGroupOfEldestMember1'])) {
        $QuotDOBVarArr	= '';
        for($quotdob=0;$quotdob<$_REQUEST['totalMember'];$quotdob++) {
                $quotdobinc = $quotdob+1;
                $QuotDOBVar	= 'QuotDOB'.$quotdobinc;
                $$QuotDOBVar	=	$_REQUEST['ageGroupOfEldestMember1'][$quotdob];
                $QuotDOBVarArr.=	$_REQUEST['ageGroupOfEldestMember1'][$quotdob];

                if($quotdobinc<$_REQUEST['totalMember']) {
                $QuotDOBVarArr.=',';
                }
        }
}

/*echo $QuotDOBVarArr;
echo '<pre>';
print_r($_REQUEST);
print_r($resultData);
exit;*/

 if (isset($resultData['ELDEST_MEMBER_AGE'])) {
        $ageGroupOfEldestMember = sanitize_data($resultData['ELDEST_MEMBER_AGE']);
    } else {
        $ageGroupOfEldestMember = '';
    }

 if(isset($resultData['INSURANCE_AMT'])) {    

        $sumInsuredValue1 = sanitize_data($resultData['INSURANCE_AMT']);

        if($sumInsuredValue1=='50000') {
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
        $tenure =1;
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
    $agentId = $_SESSION['agentId'];
}
if (isset($resultData['MOBILE_NO'])) {
        $mobileNum = sanitize_data($resultData['MOBILE_NO']);
    } else {
        $mobileNum = '';
    }



$productCode = "20001004";
$source = "FAVEO";
$productFamily = "CARE";



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
       $numberOfAdult='';
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


    if (isset($resultData['SUMINSURED'])) {
        $sumInsured = sanitize_data($resultData['SUMINSURED']);
    }  else if(isset($sumInsured1)) {
        $sumInsured = $sumInsured1;
    } 

    else {
        $sumInsured = '';
    }

if (isset($resultData['INSURANCE_AMT'])) {
        $sInsuredAmount = sanitize_data($resultData['INSURANCE_AMT']);
    } else if(isset($_REQUEST['sumInsured'])) {
        $sInsuredAmount = sanitize_data($_REQUEST['sumInsured']);
    } else {
        $sInsuredAmount = '';
    }
    if(isset($_REQUEST['premiumradio'])){
        $premiumradio = $_REQUEST['premiumradio'];
    } else {
        $premiumradio = "care";
    }

     if (isset($resultData['PREMIUM_AMOUNT'])) {
        $finalPremiumCheck = sanitize_data($resultData['PREMIUM_AMOUNT']);
    } else if($premiumradio == 'care'){
        $finalPremiumCheck = sanitize_data($_REQUEST['premium1']);
    } else if($premiumradio == 'ncb'){
        $finalPremiumCheck = sanitize_data($_REQUEST['premium2care']);
    }else {   
        $finalPremiumCheck = '';
    }





if ($propasalPage == "1") {
    header("LOCATION:error.php");
    exit;
}

$numberOfAdult = '1';
include 'inc/topScript.php';
?>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<script type="text/javascript">
function chequeddvalidate(){
        var policypagebankname 		= 		$( "#policypagebankname").val();
        var paymentType 			= 		$( "#paymentType").val();
        var transactiondate 		= 		$( "#transactiondate").val();
        var micr 					= 		$( "#micr").val();
        var policypageBranchName 	= 		$( "#policypageBranchName").val();
        var transactionID 			= 		$( "#transactionID").val();
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
function proceedfloat(){
        var paymentMode 	= $("#policynum").val();
        var proposalNum		= $("#proposalNumberOnsnapshot").val();
        var paymentMode 	= 'AGENT_SUSPENSE';
        //alert(proposalNum);
   // var proposalNum		= '1120000049969';
        $("#proceedfloatresult").html('Please wait...<img src="images/loading.gif" />');
        //setTimeout(continueExecution, 5000); 				
    $.ajax({ 
                        type: "POST", 
                        url: "checkDDAjax.php",
                        async:true,
                        data: "paymentMode="+paymentMode+"&proposalNum="+proposalNum, 
                        success: function(msg){	
                        var msgres 		= 	msg.split("@");
                        var status		=	msgres[0];
                        var clientNo	=	msgres[1];
                        var d1			=	msgres[2];
                        var d2			=	msgres[3];

                        if(msgres[0]=='Error') {
                                $("#issuanceresult").hide();
                                $("#issuanceerrorresult").show();
                                $("#errortext").html(clientNo);
                                //window.location = "thank.php?clientNo="+msg['policy-num'];	
                        } else {
                                window.location = 'thank.php?status='+status+'&proposalNum='+proposalNum+'&clientNo='+clientNo+'&d1='+d1+'&d2='+d2;
                        }
                        }
        });
}
function continueExecution(){
        $("#issuanceresult").hide();
        $("#issuanceerrorresult").show();	
}
/*function changeTitleList(){
        var validfname =  $("#ValidFName").val();
        var validlname =  $("#ValidLName").val();
        var datepicker =  $("#datepicker").val();
        var ValidTitle =  $("#ValidTitle").val();
        var relationCd =  $("#relationCd-1").val();
        alert(relationCd);
        if(relationCd=='SELF') {
        $("#titleCd-1").val(ValidTitle);
        $("#firstNamecd-1").val(validfname);
        $("#lastNamecd-1").val(validlname);
        $("#datepickerCD-1").val(datepicker);	
        }
}*/
</script>
<body>
<?php include 'inc/header.php'; ?>
    <?php include 'inc/navigation.php'; ?>
   <!-- <div class="page_nav">
        Quotation » Care</div>-->
<?php include 'inc/editCare.php'; ?>



        <div class="mid_inner_container_otc" id="proposal_form" >
                <div class="quoteBoxgreen">Get a Quick Quote > Care <a href="javascript://"  id="editquote">Edit Quote</a></div>
            <!--<div class="quoteBoxgreenUp fl"><a href="javascript://"  id="editquote">Edit Quote</a></div>-->
             <form action="savePagecare.php" method="post" class="AdvancedForm" name="savePageenhanceForm" id="savePageassureForm">

                <input type="hidden" name="proposalRequestId" id="proposalRequestId" value="<?php echo $requestedId; ?>" />
                <input type="hidden" name="proposalSumInsured" id="proposalSumInsured" value="<?php echo $sumInsured; ?>" />
                <input type="hidden" name="proposalageGroupOfEldestMember" id="proposalageGroupOfEldestMember" value="<?php echo $ageGroupOfEldestMember; ?>" />
                <input type="hidden" name="totalAdultMember" id="totalAdultMember" value="<?php echo $numberOfAdult; ?>"/>
                <input type="hidden" name="totalChildMember" id="totalChildMember" value="<?php echo $numberOfChildren; ?>"/>
                <input type="hidden" name="proposalProductCode" id="proposalProductCode" value="<?php echo $productCode; ?>"/>
                <input type="hidden" name="proposalDummySi" id="proposalDummySi" value="<?php echo $sInsuredAmount; ?>"/>
                <input type="hidden" name="saveandcontinueemail"  id="saveandcontinueemail" value=""/>
                <input type="hidden" name="agentId" id="agentId"  value="<?php echo $agentId; ?>"/>
                <input type="hidden" name="proposalTenourCode" id="proposalTenourCode" value="<?php echo $tenure; ?>"/>
                <input type="hidden" name="rmCode"  value="<?php echo $rmCode; ?>"/>
                <input type="hidden" name="permiumamountValid" id="permiumamountValid" value="<?php echo $finalPremiumCheck; ?>"/>
                <input type="hidden" name="branchCode"  value="<?php echo $branchCode; ?>"/>
                <input type="hidden" name="quotationReferenceNum"  value="<?php echo $quotationReferenceNum; ?>"/>
                <input type="hidden" name="productFamily"  value="<?php echo $productFamily; ?>"/>
                <input type="hidden" name="source"  value="<?php echo $source; ?>"/>
                <input type="hidden" name="productCode"  value="<?php echo $productCode; ?>"/>
                <input type="hidden" name="coverType"  value="<?php echo $coverType; ?>"/>       
                <input type="hidden" name="QuotationDOB" id="QuotationDOB"  value="<?php echo $QuotDOBVarArr; ?>"/>  

            <div class="quotetopbarotc fl">Your Proposal Form</div>
            <div class="quoteresultmidotc fl">
                <div class="proposerDetailBox fl">
                    <h1>Proposer’s Details</h1>

                    <div class="proposerDetailBoxForm fl">
                        <table width="949" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" valign="middle"><table width="949" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="119" valign="top">
                                     <div id="ValidTitleAddClass" class="dropbox_OTC" style="width:85px;">
                                        <select id="ValidTitle" name="ValidTitle" onChange="changeTitleList();"  class="styled width80">
                                            <option value="0" <?php if ($INITIALS == '0') { ?> selected="selected" <?php } ?>>Title</option>
                                            <option value="MR" <?php if ($INITIALS == 'MR') { ?> selected="selected" <?php } ?>>Mr</option>
                                            <option value="MS" <?php if ($INITIALS == 'MS') { ?> selected="selected" <?php } ?>>Ms</option>
                                        </select>
                                  </div>
                                            </td>
                                <td width="203" valign="top"><input name="ValidFName" id="ValidFName" type="text" onBlur="changeTitleList();" placeholder="First name"  class="txtfield_OTC" style="width:170px;" value="<?php echo $FIRST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                <td width="205" valign="top"><input type="text" name="ValidLName" id="ValidLName" onBlur="changeTitleList();" class="txtfield_OTC" style="width:170px;" placeholder="Last Name" value="<?php echo $LAST_NAME; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                <td width="198" valign="top"><input type="text" name="DOB" id="datepicker" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" onClick="scwShow(scwID('datepicker'), event, '01/01/1975');" value="<?php echo $DOB; ?>" /></td>
                                <td width="224" valign="top"><input type="text" maxlength="10" name="ValidMobileNumber" id="ValidMobileNumber" class="txtfield_OTC" style="width:200px;" placeholder="Mobile No." value="<?php echo $mobileNum; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
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
                                            <td width="279" valign="top"><input type="text" name="ValidEmail" id="ValidEmail" class="txtfield_OTC" style="width:250px;" placeholder="Email Id" value="<?php echo $EMAIL_ID; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="123" valign="top"><input type="text" name="ValidPinCode" id="ValidPinCode" onBlur="getCityName();" class="txtfield_OTC" style="width:90px;" placeholder="Pincode" value="<?php echo $PIN_CODE; ?>" />&nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="229" valign="top"><div class="dropbox_OTC" style="width:190px; display:inline-block;">
                                                    <select name="ValidCityName" id="ValidCityName" class="styled" style="width:185px; font-weight:normal;" onChange="questionnairedatashow()">
                                                        <option value="<?php if($CValidCityName!='') { echo $CValidCityName; } ?>"><?php if($CValidCityName!='') { echo $CValidCityName; } else {  ?>City (Auto on Pincode) <?php } ?> </option>
                                                    </select>
                                                </div>
                                                &nbsp;<span class="mandatorytxt">*</span></td>
                                            <td width="318" valign="top"><input type="text"  value="<?php echo $CValidStateName;?>" name="ValidStateName" id="ValidStateName" class="txtfield_OTC" style="width:170px;" placeholder="State" /></td>
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

<div class="proposerDetailBoxFormgray fl">
    <table width="949" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="115" valign="top"><div class="dropbox_OTC" id="ValidRelationAddClass-<?php echo $i;?>" style="width:85px;">
                    <select name="relationCd[]" id="relationCd-<?php echo $i; ?>" class="styled" onChange="changeTitleCd(this,<?php echo $i; ?>);" style="width:80px; font-weight:normal;">
                    <option value="SELF" <?php if (@$jsonDependentDetail[$dep]->relationCd == 'SELF') { ?> selected="selected" <?php } ?>>Self</option>      
                    </select>
                </div></td>
            <td width="115" valign="top"><div class="dropbox_OTC" style="width:85px;">
                    <select name="titleCd[]" id="titleCd-<?php echo $i; ?>" class="styled" style="width:80px; font-weight:normal;">
                        <?php if (isset($jsonDependentDetail[$dep]->titleCd) && ($jsonDependentDetail[$dep]->titleCd != '')) { ?>
                                                <option value="<?php echo $jsonDependentDetail[$dep]->titleCd; ?>"  selected="selected" ><?php if ($jsonDependentDetail[$dep]->titleCd == '0') {
echo "Title";
} else {
echo ucfirst(strtolower($jsonDependentDetail[$dep]->titleCd));
} ?></option>
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
            <td width="289" valign="top"><input type="text" name="dOBCd[]" id="datepickerCD-<?php echo $i; ?>" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" value="<?php echo @$jsonDependentDetail[$dep]->dOBCd; ?>" /></td>
        </tr>
    </table>
</div>
<?php } ?>

<div class="proposerDetailBox fl">
    <h1><img src="images/minus_green.jpg" class="fl" onClick="questionnairedatahide()" id="questionnairedatahideid"><img src="images/plus_green.jpg" class="fl" id="questionnairedatashowid" onClick="questionnairedatashow()" style="display:none;">&nbsp;Health Questionnaire</h1>
    <div id="questionnairedata">

                                            <div class="questionBar fl">
                                                <h2 id="clck1">Does any person(s) to be insured has any Pre-existing diseases ? <img onMouseOut="UnTip();" onMouseOver="Tip('Please select yes if any person(s) to be insured has Diabetes,hypertension,liver disease,cancer, cardiac disease, joint pain, kidney disease, paralysis,Congenital Disorder, HIV/AIDS. This is vital for correct Claim disbursal.');" src="images/question_icon.png" border="0"/></h2>
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
                                                        <div class="do_doesBoxbelowleft1" >Does any person(s) to be insured has any Pre-existing diseases? <span class="redtxt">*</span></div>
                                                        <div class="do_doesBoxbelowright">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <?php
                                                                    $k = 0;
                                                                    for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                                        ?>
                                                                        <td><div class="drop_Health">
                                                                                <select name="questions[yesNoExist][subQuestion][1][qus][]" id="sonu<?php echo $i ?>"  onchange="displayQuestion(<?php echo $i ?>);" class="styled" style="width:90px;">
                                                                                    <option value="0" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                                    <option value="YES" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                                    <option value="NO" <?php if (@$questionArrayResult['yesNoExist']['subQuestion']['1']['qus'][$k] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                                                </select></div></td>
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



                                                                                <input  <?php
                                                                                    if (!empty($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['qus'])) {
                                                                                        if (in_array($i, @$questionArrayResult['yesNoExist']['subQuestion'][$q_id]['qus'])) {
                                                                                            ?> checked="checked" <?php
                                                                                        }
                                                                                    }
                                                                                    ?> class='<?php echo $q_id; ?> prashant<?php echo $i; ?>' type="checkbox" name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][qus][]" id="insuredCdQuestionOne-<?php echo $q_id . "-" . $i; ?>" onclick='insuredCdQuestionChk(<?php echo $q_id; ?>,<?php echo $i; ?>,<?php echo date("Y"); ?>);' value='<?php echo $i; ?>' /></td>

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

                                                                                    <div class="drop_Health"   style="margin-right:5px;">
                                                                                        <select name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][yy][]" class="styled"  <?php if (isset($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l]) && ($questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l] != '')) { ?>did="<?php echo $questionArrayResult['yesNoExist']['subQuestion'][$q_id]['yy'][$l]; ?>"<?php } ?>    id="YYYY-<?php echo $q_id; ?>-<?php echo $i; ?>" onChange="checkYear(this.value, '<?php echo date('Y'); ?>', '<?php echo $q_id; ?>', '<?php echo $i; ?>', '<?php echo date('m'); ?>');" style="width:50px;">
                                                                                            <option value="0">YYYY</option>


                                                                                        </select></div>
                                                                                    <div class="drop_Health">
                                                                                        <select name="questions[yesNoExist][subQuestion][<?php echo $q_id; ?>][mm][]" class="styled" id="MM-<?php echo $q_id; ?>-<?php echo $i; ?>" style="width:35px;">
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
                                                <h2 id="clck2">Has any of the new person(s) to be insured been diagnosed / hospitalized for any illness / injury during the last 48 months ?<img src="images/question_icon.png" border="0" onMouseOut="UnTip();" onMouseOver="Tip('Please do not include treatments for common cold, flu fever, regular medical check-ups.');" class="qicon"/></h2>
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
                                                                        <td><div class="drop_Health"><select name="questions[HEDHealthHospitalized][subQuestion][qus][]" class="styled" style="width:90px;">
                                                                                    <option value="0" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                                    <option value="YES" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                                    <option value="NO" <?php if (@$questionArrayResult['HEDHealthHospitalized']['subQuestion']['qus'][$r] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                                                </select></div></td>
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
                                                <h2 id="clck3">Has any of the new person(s) to be insured  ever filed a claim with their current / previous insurer? <img src="images/question_icon.png" border="0"   onmouseout="UnTip();" onMouseOver="Tip('Please select the relevant option as this helps in quick claim disbursal.');" class="qicon"/></h2>
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
                                                                        <td><div class="drop_Health"><select name="questions[HEDHealthClaim][subQuestion][qus][]" class="styled" style="width:90px;">
                                                                                    <option value="0" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                                    <option value="YES" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                                    <option value="NO" <?php if (@$questionArrayResult['HEDHealthClaim']['subQuestion']['qus'][$r] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                                                </select></div></td>
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
                                                <h2 id="clck4">Has any proposal for Health Insurance of the new person(s) to be insured, been declined, cancelled or charged a higher premium ? <img src="images/question_icon.png" onMouseOut="UnTip();" onMouseOver="Tip('Please select yes if any person(s) to be insured is already covered under any other health insurance policy of Religare Health insurance. This can be either self-bought or availed under group insurance coverage.');" border="0" ></h2>
                                                <div class="yes_no_box" id="question3">
                                                    <input type="radio" name="questions[HEDHealthDeclined][H003]" id="question3-1" value='1' <?php
                                                           if (isset($questionArrayResult['HEDHealthDeclined']['H003'])) {
                                                               if (@$questionArrayResult['HEDHealthDeclined']['H003'] == 1) {
                                                                   ?> checked="checked" <?php
                                                               }
                                                           }
                                                           ?>  style="border:none;" onClick="setVisibility('id4', 'inline');" />
                                                    Yes <input type="radio" name="questions[HEDHealthDeclined][H003]" id="question3-2"  value='0' <?php
                                                               if (isset($questionArrayResult['HEDHealthDeclined']['H003'])) {
                                                                   if (@$questionArrayResult['HEDHealthDeclined']['H003'] == 0) {
                                                                       ?> checked="checked" <?php
                                                                   }
                                                               }
                                                               ?> style="border:none;" onClick="setVisibility('id4', 'none');" />
                                                    No </div>

                                                <div class="do_doesBox2" id="id4" style="display:none;">
                                                    <div class="do_doesBoxhead1">
                                                        <div class="do_doesBoxheadleft1">Question</div>
                                                        <div class="do_doesBoxheadright">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
                                                                        <td style="width:<?php echo $styleArray; ?>%;" id='insuredCdFour-<?php echo $i; ?>'>Insured <?php echo $i; ?></td>
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
                                                                        <td><div class="drop_Health"><select name="questions[HEDHealthDeclined][subQuestion][qus][]" class="styled" style="width:90px;">
                                                                                    <option value="0" <?php if (@$questionArrayResult['HEDHealthDeclined']['subQuestion']['qus'][$r] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                                    <option value="YES" <?php if (@$questionArrayResult['HEDHealthDeclined']['subQuestion']['qus'][$r] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                                    <option value="NO" <?php if (@$questionArrayResult['HEDHealthDeclined']['subQuestion']['qus'][$r] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                                                </select></div></td>
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
                                                <h2 id="clck5">Is any of the person(s) to be insured, already covered under any other health insurance policy of Religare Health Insurance? <img src="images/question_icon.png" onMouseOut="UnTip();" onMouseOver="Tip('Please select yes if any person(s) to be insured is already covered under any other health insurance policy of Religare Health Insurance. This can be either self-bought or availed under group insurance coverage.');" border="0" class="qicon"></h2>
                                                <div class="yes_no_box" id="question4">

                                                    <input type="radio" name="questions[HEDHealthCovered][H004]" id="question4-1"  <?php
                                                           if (isset($questionArrayResult['HEDHealthCovered']['H004'])) {
                                                               if ($questionArrayResult['HEDHealthCovered']['H004'] == 1) {
                                                                   ?> checked="checked" <?php
                                                               }
                                                           }
                                                           ?> value='1' style="border:none;" onClick="setVisibility('id5', 'inline');"  />
                                                    Yes <input type="radio" name="questions[HEDHealthCovered][H004]" id="question4-2" <?php
                                                               if (isset($questionArrayResult['HEDHealthCovered']['H004'])) {
                                                                   if ($questionArrayResult['HEDHealthCovered']['H004'] == 0) {
                                                                       ?> checked="checked" <?php
                                                                   }
                                                               }
                                                               ?>  value='0' style="border:none;" onClick="setVisibility('id5', 'none');"  />
                                                    No</div>

                                                <div class="do_doesBox2" id="id5" style="display:none;">
                                                    <div class="do_doesBoxhead1">
                                                        <div class="do_doesBoxheadleft1">Question</div>
                                                        <div class="do_doesBoxheadright">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <?php for ($i = 1; $i <= $numberOfAdult; $i++) { ?>
                                                                        <td style="width:<?php echo $styleArray; ?>%;" id='insuredCdFive-<?php echo $i; ?>'>Insured <?php echo $i; ?></td>
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
                                                                    $r4 = 0;
                                                                    for ($i = 1; $i <= $numberOfAdult; $i++) {
                                                                        ?>
                                                                        <td><div class="drop_Health"><select name="questions[HEDHealthCovered][subQuestion][qus][]" class="styled" style="width:90px;">
                                                                                    <option value="0" <?php if (@$questionArrayResult['HEDHealthCovered']['subQuestion']['qus'][$r4] == '0') { ?> selected="selected" <?php } ?>>Select</option>
                                                                                    <option value="YES" <?php if (@$questionArrayResult['HEDHealthCovered']['subQuestion']['qus'][$r4] == 'YES') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                                    <option value="NO" <?php if (@$questionArrayResult['HEDHealthCovered']['subQuestion']['qus'][$r4] == 'NO') { ?> selected="selected" <?php } ?>>No</option>
                                                                                </select></div></td>
                                                                    <?php
                                                                    $r4++;
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
        I here by agree to the <a href="javascript:void(0)" onClick="window.open('http://rhicluat.religare.com/proposalterms.html','_blank','width=700,height=515')">term & conditions</a> of the purchase of this policy. *<br />
                 </div>
        <div class="termBox">
        <input type="checkbox" name="checkbox2" id="checkbox2" />
                Receive Service SMS and E-mail alerts
        </div>

        <div class="proceedBox fl">
            <div style="display:none; margin-bottom: 25px; color: #D00;" class="redtxtBottom" id="errordisplayPrashant">Kindly fill the boxes highlighted in red.</div>
                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>

                                    <input type="hidden" id="checkclickid" name="checkclickid" value="1">
                                    <input type="image" id="FormSubmit"  onclick="checkClickEvent(1);" src="images/preceed_btn.jpg" style="border: none;"/></td>
         <!--<td><input type="image" name="save" src="images/save_emailBtn.jpg" value="" style="border: none; cursor: pointer;" onClick="checkClickEvent(2);" class="saveContinue savebtn"/></td>								
                            --></tr>
                        </table>




        </div>    

         </div>


            </div></form>
            <img src="images/grayotcBot.jpg" class="fl">
            <div class="cl"></div></div>     
<?php include_once "inc/footer.php"; ?>

    <?php if (isset($_SESSION['errorMSGE']) && ($_SESSION['errorMSGE'] != '')) { ?>
                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
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
                        <td height="50" align="center"><input name="image" type="image" src="images/proposalbutton.png" onClick="saveform();" style="border:none;"  /></td>
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
                           // unset($_SESSION['errorMSGE']);
                            ?> </td>
                </tr>

            </table>
            <div class="cl"></div>
        </div>
    </div>

  <div  style="display:none;">
        <div id='inline_proceedpay'>
            <div class="pop_proceed fl" id="issuanceresult">
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
                                <td align="left"><a href="javascript://"><input type="hidden" name="proposalNumberOnsnapshot" id="proposalNumberOnsnapshot" value="<?php echo $resultAllData[0]['PROPOSAL_ID']; ?>"/><?php echo $resultAllData[0]['PROPOSAL_ID']; ?></a></td>

                                <td align="center">CARE</td>

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
                                <td width="440" align="right"><img src="images/preceed_payFloat_btn.jpg" style="cursor:pointer;" onClick="proceedfloat()"><!--<input type="image" class="payddandcheck"   src="images/preceed_payFloat_btn.jpg" style="border:none">--></td>
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
                <!--                                                                                                    </form>-->
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
                                            <input name="policypage[id]" type="hidden" value="<?php if (isset($_REQUEST['id'])) {
    echo $_REQUEST['id'];
} ?>"  />
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
                $("#datepicker").val(qdob);
        });
        $("#editquote").click(function() {
                var datepickerres = $("#datepicker").val();		
                $("#getSearch").show();
                $("#qdob").val(datepickerres);
                $("#proposal_form").hide();
                //assuresearch();
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
<?php } else if ((isset($_REQUEST['code'])) || (isset($_REQUEST['checkPageOpen']) && $_REQUEST['checkPageOpen'] == 9)) {	?>
    <script type="text/javascript">
    $(document).ready(function() {
    $("#getSearch").hide();
    $("#proposal_form").show();
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
<?php } ?>

<script src="js/care_know_agent.js" type="text/javascript"></script>
<script src="js/jquery.validation.functions_care.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
        var dobval 		= $( "#datepickerCD-<?php echo $numberOfAdult?>").val();
        if(dobval!= '') {
        $( "#questionnairedatashowid").hide();
        $( "#questionnairedata").show();
        $( "#questionnairedatahideid").show();  	
        }	else {
        $(".termBox").css({'border-top':'0'});
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
$( "#datepickerCD-<?php echo $numberOfAdult?>" ).focusout(function() {	
        questionnairedatashow();
});
$( "#relationCd-<?php echo $numberOfAdult?>" ).change(function() {	
        $relationval 	= $( "#relationCd-<?php echo $numberOfAdult?>").val();
        $dobval 		= $( "#datepickerCD-<?php echo $numberOfAdult?>").val();
        if($relationval=='SELF') {
                if($dobval!='') {
                        questionnairedatashow();
                }
        }
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
            for ($cl = 1; $cl <= $numberOfAdult; $cl++) { ?>
                                                                    <script type="text/javascript">
                                                                        jQuery(document).ready(function() {
                                                                            displayQuestion(<?php echo $cl; ?>);
                                                                            insuredCdQuestionChkEdit(<?php echo $questionArrayClass; ?>,<?php echo $cl; ?>,<?php echo date("Y"); ?>);
                                                                         });
                                                                    </script>

                                                                <?php }
                                                            }
                                                        } if ($questionArrayResult['HEDHealthHospitalized']['H001'] == 1) { ?>
                                                            <script type="text/javascript">
                                                                setVisibility('id2', 'inline');
                                                            </script>
    <?php }
    if ($questionArrayResult['HEDHealthClaim']['H002'] == 1) {
        ?>
                                                            <script type="text/javascript">
                                                                setVisibility('id3', 'inline');
                                                            </script>
    <?php }
    if ($questionArrayResult['HEDHealthDeclined']['H003'] == 1) {
        ?>
                                                            <script type="text/javascript">
                                                                setVisibility('id4', 'inline');
                                                            </script>
    <?php }
    if ($questionArrayResult['HEDHealthCovered']['H004'] == 1) {
        ?>
                                                            <script type="text/javascript">
                                                                setVisibility('id5', 'inline');
                                                            </script>
    <?php }
} ?>
</body>
</html>
