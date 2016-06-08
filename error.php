<?php require_once 'inc/conf.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Enhance</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
        <link rel="stylesheet" type="text/css" href="css/dhtmlxslider.css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery.validate.css" />
        <script src="js/dhtmlxcommon.js" type="text/javascript"></script>
        <script  src="js/dhtmlxslider.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
        
        <script type="text/javascript" src="js/jquery.select_skin.js"></script>
        <script type="text/javascript" src="js/select_menu.js"></script>
    </head>
    <body>
        <script type="text/javascript" src="js/wz_tooltip.js"></script>
        <!--Header section start from here-->
<?php include("inc/header.php") ?>
        <!--Header section end here-->

        <!--Header section end here-->
        <div class="middle_section">
<div class="error_middle_section">
                <img src="img/error_logo.jpg" alt="error" class="fl" />
        <div class="error_middle_sectionRight">
                <h4>Page not found.</h4>
            <p>The page you are looking for seems to be missing.
              <br />
              Go back, or return to <a href="<?php echo SITEURL; ?>">www.religarehealthinsurance.com</a> to choose a new page.<br /> 
Please report any broken links to our team. </p>
<ul>
                
    <li><a href="<?php echo SITEURL; ?>religare-customer-support.html">Customer Support</a></li> 
    <li><a href="<?php echo RENEWALURL;?>">Renewal</a></li>
    <li><a href="<?php echo SITEURL; ?>health-insurance-claim-center.html">Claim Center</a></li>
    <li><a href="<?php echo SITEURL; ?>health-plan-network-hospitals.html">Network Hospital</a></li>
</ul>
        </div>
   <div class="cl"></div></div>
        </div>
<?php include("inc/footer.php"); ?>
