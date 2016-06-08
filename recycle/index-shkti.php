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
    "6000000" => "021");

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
    "6000000" => "022");

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
<script type="text/javascript" src="js/travel_validate.js"></script>
<script type="text/javascript" src="js/wz_tooltip.js"></script>

<script type="text/javascript">
function chequeddvalidate(){
	var policypagebankname 	= $( "#policypagebankname").val();
	var paymentType 	= $( "#paymentType").val();
	var transactiondate 	= $( "#transactiondate").val();
	var micr 		= $( "#micr").val();
	var policypageBranchName = $( "#policypageBranchName").val();
	var transactionID 	= $( "#transactionID").val();
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
			var clientNo            =	msgres[1];
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
<?php include 'inc/editTravel.php'; ?>
    
        
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
 
                                                        
                                                        
                                                        
                                                        
    
<!--    <div style="display:none;">
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
 <input name="policypage[id]" type="hidden" value="<?php if (isset($_REQUEST['id'])) { echo $_REQUEST['id'];
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
								<input name="" type="image" img src="images/Faveo-OTC_submit.jpg" border="0" class="otc_submit" /></td>								
                                <td width="318" align="right"><a href="javascript://" onClick="backPrevious()" class="backEdit"><< Back to Previous Page</a></td>
                            </tr>
                        </table>
                    	</div>


                    </div>
                </form>
                <div class="cl"></div>
            </div>


        </div>
    </div>-->

<script type="text/javascript">
    $(document).ready(function() {
        $("#proposal_form").show();

        //$("#clickbuy").click(function() {
              $("#carebuynowimage").click(function() {
		/*var qdob = $("#qdob").val();
		if(qdob=='') {
                    alert("Please enter age of eldest member.");
                    return false;
		}*/
        
		//$("#getSearch").hide();
		//$("#proposal_form").show();
		//$("#datepicker").val(qdob);
	});
        
        
        
        
	$("#editquote").click(function() {
		var datepickerres = $("#datepicker").val();		
		$("#getSearch").show();
		//$("#qdob").val(datepickerres);
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
    //$("#getSearch").hide();
    //$("#proposal_form").show();
        </script>
<?php } else if ((isset($_REQUEST['code'])) || (isset($_REQUEST['checkPageOpen']) && $_REQUEST['checkPageOpen'] == 9)) {	?>
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
	$dobval 	= $( "#datepickerCD-<?php echo $numberOfAdult?>").val();
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
