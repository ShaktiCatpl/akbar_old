<?php 
//error_reporting(0);
include_once("conf/session.php");
include_once('inc/conf.php');
//include_once('inc/topScript.php');
?>
<!doctype html>
<html lang="en">
<head>
<title>Destimony</title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<![endif]-->
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/jquery.validate.css" rel="stylesheet" type="text/css">
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/select_menu.js"></script>
<link rel="stylesheet" href="css/jqueryslidemenu.css" />
<script type="text/javascript" src="js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="js/placeholders.min.js"></script>
<link media="screen" rel="stylesheet" href="css/colorbox_new1.css" />
<script src="js/jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$(".example2").colorbox({width:"415px", inline:true, href:"#inline_example2"});	
});
function setVisibility(id, visibility) {
document.getElementById(id).style.display = visibility;
}
</script>
<link href="css/dhtmlxslider.css" rel="stylesheet" type="text/css">
<script src="js/dhtmlxcommon.js" type="text/javascript"></script>
<script src="js/dhtmlxslider.js" type="text/javascript"></script>
<script src="js/jquery.validate.js" type="text/javascript"></script>

</head>
<?php $curentData = date("d/m/Y");?>
<?php
$clientNo	= sanitize_data($_REQUEST['clientNo']);
$proNum		= sanitize_data($_REQUEST['proposalNum']);
$status		= sanitize_data($_REQUEST['status']);
$d1			= sanitize_data($_REQUEST['d1']);
$d2			= sanitize_data($_REQUEST['d2']);
$proDetail 	= fetchListCond("REFERENCE_DATA"," WHERE PROPOSAL_ID ='".$proNum."'");
/*echo '<pre>';
print_r($proDetail);*/
?>
<body>
<?php include 'inc/header.php'; ?>
<?php include 'inc/navigation.php'; ?>
<div class="middle_section">
  <div class="otc_thanku_container_15 fl"> 
  <?php if($status=='inforceTask') {	?> 
  	 <h1>Congratulations, Thanks Your payment transaction is successful!</h1>  
    <p>Your Health Insurance policy  is ready and has been sent to your <a href="javascript://"> <?php echo @$proDetail[0]['EMAIL_ID'];?></a> id.</p>
    <?php }	elseif($status=='cpuReqmntResolTask'){	?>
    <p>The Certificate of Insurance cannot be issued due to insufficient balance. Please contact system administrator.</p>
      <?php }	elseif($status=='grpAsiaReqmntResolTask'){	?>
         <h1>Your Transaction Reference No is <?php echo isset($proDetail[0]['PROPOSAL_ID'])? $proDetail[0]['PROPOSAL_ID']:'N/A'; ?></h1>
            <p>Thank you for your proposal & payment. We will get in touch with you shortly for further requirements & processing of your proposal. For any assistance, please call our <span>toll free No. 1800 200 4488 </span>and mention the proposal number given below. <br />
              <br />
              The Company may apply a risk loading on the premium payable (based upon the declarations made in the proposal form and the health status of the members proposed to be insured). These loadings would be applied from the Policy Period Start Date including all subsequent renewals with the Company. Any loadings, if applicable, shall be suitably intimated to the proposer based on the assessment of the proposal form and medical tests. The proposer shall be required to pay an additional premium within 15 days of such intimation. The Company shall not be at any risk during this period. In the event of non-receipt of this additional premium within the stipulated time, Company shall cancel your proposal and refund the premium amount after deducting cost of medical tests, if any. </p>
     <?php }	else	{ ?>
     <h1>Thanks Your payment transaction is successful!</h1>  
    <p>Your Health Insurance policy  is ready and has been sent to your<a href="#"> <?php echo @$proDetail[0]['EMAIL_ID'];?> </a>id.</p>
     <?php }	?>
    <div class="healthproposerDetail_15 fl">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
              <tr>
                <td width="90%" valign="top"><img src="images/thk.png" border="0" class="fl"></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td><div class="forselectHealth_new bottomborder fl">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
                <tr>
                  <th width="25%" align="left"> <?php if($status=='inforceTask') {	?> Policy No. <?php } else { ?>Application No. <?php } ?></th>
                  <th width="15%" align="left"> Plan Type</th>
                  <th width="20%" align="left">Policy Tenure</th>
                  <th width="34%" align="left">Policy Period</th>
                  <th width="6%">&nbsp;</th>
                </tr>
                <tr>
                  <td class="notdborder"><span><?php if($status=='inforceTask') { echo isset($clientNo)? $clientNo:'N/A'; } else { echo isset($proDetail[0]['PROPOSAL_ID'])? $proDetail[0]['PROPOSAL_ID']:'N/A'; } ?></span></td>
                  <td class="notdborder"><?php echo isset($proDetail[0]['PAN_NO'])? $proDetail[0]['PAN_NO']:'N/A'; ?></td>
                  <td class="notdborder"><?php echo isset($proDetail[0]['TENURE'])? $proDetail[0]['TENURE'].' Year(s)':'N/A'; ?></td>
                  <td class="notdborder"><?php echo $d1.' to '.$d2;?></td>
                  <td class="notdborder">&nbsp;</td>
                </tr>
              </table>
              <div class="forselectHealth_new10 fl">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="533">&nbsp;</td>
                    <td width="88" align="right">Sum Insured:</td>
                    <td width="77" align="right"><img src="images/rs.png" border="0"><span>&nbsp;<?php echo isset($proDetail[0]['INSURANCE_AMT'])? number_format($proDetail[0]['INSURANCE_AMT']):'N/A'; ?></span></td>
                    <td width="258" class="tkgreenband"> Your premium is: <?php echo isset($proDetail[0]['PREMIUM_AMT'])? number_format($proDetail[0]['PREMIUM_AMT']):'N/A'; ?></td>
                  </tr>
                 	<tr>
                    <td colspan="4">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="533">&nbsp;</td>
                    <td width="88" align="right">&nbsp;</td>
                    <td width="77" align="right">&nbsp;</td>
                    <td width="258" class="tkgreenband"><div id="footerresult" style="float:right; padding-right:5px;"></div>&nbsp;</td>
                  </tr>
                
                </table>
              </div>
              <!--<table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody><tr>
            <td valign="bottom" height="25" align="right" class="pding"><strong>Sum Insured : </strong>
              <label><strong>Rs.3,00,000</strong></label></td>
          </tr>
          <tr>
            <td><table width="199" cellspacing="0" cellpadding="0" border="0" align="right">
              <tbody><tr>
                <td class="bgimg tdpad">Your premium is: 232</td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table>-->
            </div>
            <!--<div class="forselectHealth_new2 fl">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
                <tr>
                  <th width="28%" align="left">Person(s) Covered </th>
                  <th width="25%" align="left"> Date Of Birth</th>
                  <th width="41%" align="left">Your Contact Address</th>
                  <th width="6%">&nbsp;</th>
                </tr>
                <?php 
                if(isset($insuredPeople[0]) && count($insuredPeople) > 0 ):
                  foreach($insuredPeople as $explodePeople):
                ?>                
                <tr>
                  <td><span><?php echo $explodePeople['titleCd'].' '. $explodePeople['firstNameCd'].' '. $explodePeople['lastNameCd']; ?></span></td>
                  <td><?php echo $explodePeople['dOBCd'];  ?></td>
                  <td><?php echo isset($proDetail[0]['ADDRESS_1'])? $proDetail[0]['ADDRESS_1'].', ':'N/A'; echo isset($proDetail[0]['PIN_CODE'])? $proDetail[0]['PIN_CODE']:'N/A';  ?></td>
                  <td>&nbsp;</td>
                </tr>
                <?php endforeach; endif; ?>
              </table>
            </div>-->
            </td>
        </tr>
      </table>
    </div> 
    <?php if($clientNo!='') { 
	if($status=='inforceTask') {
	?>   
    <div class="print_button_area">                
     <a href="createpdf.php?clientNo=<?php echo $clientNo;?>" target="_blank">
                        <img src="images/otc_down.jpg"  border="0"/>
                            </a>
    </div>
     <?php }	} ?>
  </div>
  <!--<input name="" type="image" src="images/otc_down.jpg" border="0" /><code class="dis_color_code"> Disclaimer: Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </code>-->
  <div class="cl"></div>
</div>
 <?php include_once "inc/footer.php";	
 if($proDetail[0]['PAN_NO']=='CARE') {
	 $agntflt	=	'care';
 }	else {
	  $agntflt	=	'secure';
 }
 ?>
 <script type="text/javascript">
 function getagentfloatfooter(type){
	var policynum 	= $("#pnm").val();
	if(type=='secure') {
		$("#footerresult").html('<img src="images/loading.gif" />');	
		//var policynum 	= '20008802';//$("#policynum").val();
    	var subsnum		= '303';//$("#subsnum").val();
	}	else {
		$("#footerresult").html('<img src="images/loading.gif" />');
		//var policynum 	= '20008802';	//$("#policynum").val();
    	var subsnum		= '103';	// $("#subsnum").val();
	}
    $.ajax({ 
			type: "POST", 
			url: "agent.php",
			async:false,
			data: "policynum="+policynum+"&subsnum="+subsnum, 
			success: function(msg){  	
			//var msgarr	=	split.msg;
			var msgarr	=	msg.split(":");
			var msg1	= msgarr[0];
			var msg2	= msgarr[1];
			if(msg1=='Error') {
				alert('Please check later for float balance.');
				/*if(type=='secure') {
					 $("#securefloatresult").html('Group Secure Balance');		
				}	else {					
					 $("#carefloatresult").html('Group Care Balance');	
				}*/
			}	else {	
				if(type=='secure') {
					 $("#footerresult").html('Group Secure Balance : Rs '+msg2);		
				}	else {					
					 $("#footerresult").html('Group Care Balance : Rs '+msg2);	
					}
				}
			}
		});
}
 getagentfloatfooter('<?php echo $agntflt?>');
 </script>
</body>