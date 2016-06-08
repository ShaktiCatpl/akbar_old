<?php 
//error_reporting(0);
include_once("conf/session.php");
include_once('inc/conf.php');
include_once('inc/topScript.php');
$clientNo	= sanitize_data($_REQUEST['clientNo']);
$proNum		= sanitize_data($_REQUEST['proposalNum']);
$status		= sanitize_data($_REQUEST['status']);
$proDetail 	= fetchListCond("REFERENCE_DATA"," WHERE PROPOSAL_ID ='".$proNum."'");
/*echo '<pre>';
print_r(@$proDetail);*/
?>
<body>
<?php include 'inc/header.php'; ?>
<?php include 'inc/navigation.php'; ?>
<div class="middle_section"> 
      <div class="forselectHealth_new bottomborder fl">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
                <tr>
                  <th width="28%" align="left">Application No</th>
                  <th width="25%" align="left"> Plan Type</th>
                  <th width="41%" align="left">Policy Period</th>
                  <th width="6%">&nbsp;</th>
                </tr>
                <tr>
                  <td class="notdborder"><span><?php echo isset($proDetail[0]['PROPOSAL_ID'])? $proDetail[0]['PROPOSAL_ID']:'N/A'; ?></span></td>
                  <td class="notdborder"><?php echo isset($proDetail[0]['PAN_NO'])? $proDetail[0]['PAN_NO']:'N/A'; ?></td>
                  <td class="notdborder"><?php echo isset($proDetail[0]['TENURE'])? $proDetail[0]['TENURE'].' Year(s)':'N/A'; ?></td>
                  <td class="notdborder">&nbsp;</td>
                </tr>
              </table>             
            </div>    
  <div class="cl"></div>
</div>
 <?php include_once "inc/footer.php";	?>
</body>