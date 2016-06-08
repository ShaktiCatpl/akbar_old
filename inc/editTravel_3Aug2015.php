<link href="css/stylesheet.css" rel="stylesheet" type="text/css">
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scw.js"></script>
<link href="css/datepiker.css" rel="stylesheet" type="text/css">
<script src="js/datepiker.js" type="text/javascript"></script>
<!--<script src="js/jquery.validation.functions.js" type="text/javascript"></script>-->

<script type="text/javascript" src="js/travel_panel.js"></script>
<script src="js/jquery.colorbox.js"></script>

<script type="text/javascript">
    /*date picker start val*/
    function checkNoday() {
        var noday = $("#noday").val();
        var toValue = $("#to").val();
        var fromvalue = $("#from").val();
        var travellingTo = $("#travellingTo").val();
        switch (travellingTo) {
            case '5':
            {
                var tripType = $("#tripType").val();
                break;
            }
            case '6':
            {
                var tripType = $("#tripType").val();
                break;
            }
            default:
            {
                var tripType = "Single";
                break;
            }
        }

        if (fromvalue != '' && (fromvalue != 'Start Date')) {
            if (noday != '') {
                if (!isNaN(noday)) // this is the code I need to change
                {
                    if (noday > 1 && noday < 181) {
                        var noday = $("#noday").val();
                    } else {
                        if (noday > 180) {
                            $("#noday").val('180');
                            alert("No. of days cannot be more than 180 days if Trip Type is Single");
                            var noday = 180;
                        } else {
                            $("#noday").val('2');
                            var noday = 2;
                        }
                    }
                    $.ajax({
                        type: "POST",
                        url: "dateCheckNew.php",
                        async: true,
                        data: "fromvalue=" + fromvalue + "&noday=" + noday + "&tripType=" + tripType + "&tovalue=" + toValue,
                        success: function (msg) {
                            var t = msg.split(":");
                            $("#noday").val(t[0]);
                            $("#to").val(t[1]);
                            searchResultDate();
                        }
                    });
                } else {
                    alert("Must input numbers");
                    return false;
                }
            }
        }
    }

    $(function () {
        var dates = $('#from, #to').datepicker({
            defaultDate: "0",
            changeMonth: true,
            numberOfMonths: 1,
            minDate: 0,
            dateFormat: "dd-mm-yy",
            maxDate: 730,
            onSelect: function (selectedDate) {
                var tripType = $("#tripType").val();
                var fromvalue = $("#from").val();
                var tovalue = $("#to").val();
                if (fromvalue != '' && (fromvalue != 'Start Date')) {
                    $.ajax({
                        type: "POST",
                        url: "dateCheck.php",
                        async: true,
                        data: "fromvalue=" + fromvalue + "&tripType=" + tripType + "&tovalue=" + tovalue,
                        success: function (msg) {
                            var t = msg.split(":");
                            $("#noday").val(t[0]);
                            $("#to").val(t[1]);
                            searchResultDate();
                        }
                    });
                }
            }
        });
    });
    /*date picker  end val*/
    $(document).ready(function () {
        removeAgeBand();
        //caresearch();
    });
</script>

 <?php
  
$traveldisplay = '';
if ($_POST['travellingTo'] != '') {
    $traveldisplay = "none";
}
$travellingTo = $_POST['travellingTo'];

//die;
//  echo "<pre>";
//  print_r($_POST);
// die;
/*
$EDITTRAVELPLAN = array(
                "1" => "40001001",
                "2" => "40001002",
                "3" => "40001015",
                "4" => "40001004",          
                "5" => array("40001011,40001012,40001007,40001008"),
                "6" => array("40001009,40001010,40001005,40001006")  
                );
*/

?>
<div class="mid_inner_container_otc" id="getSearch" style="display:<?php echo $traveldisplay; ?>;">
    <div class="quoteBoxgreen">Get a Quick Quote > Travel</div>
    <div class="quoteBoxgreenBottom fl">
    <?php 
       $id = $_REQUEST['id'];
       if($id==""){
    ?>
        <form id="select_skin_form_9" name="quote_box" method="post" style="margin:0px;" action="">
            <div id="errorinfo" align="center" style="color:red; font-size:12px;"></div>
            <table width="959" border="0" cellspacing="0" cellpadding="0" class="date fl">
                <tr>
                    <td>
                        <table width="959" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="middle"><strong>Travelling To: <img onmouseover="Tip('Please select the Region of your destination you wish to buy Travel Insurance for. The highlights of the same plan will be shown on the side of page.');" onmouseout="UnTip();" src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg"></strong></td>
                                <td height="40" align="left" valign="middle" class="brdrotc"> 
                                    <select name="travellingTo" id="travellingTo"  style="width:150px; height:25px; font-weight:normal;">
                                        <?php foreach($TRAVELPLAN as $key =>$value) { ?>
                                            <option value="<?php echo $key; ?>" <?php
                                            if (@$travellingTo == $key) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                                </td>
                            </tr>

                            <tr id="triptypepr" style="display:none;">
                                <td height="39">Trip type <img src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg" onmouseover="Tip('Single trip is for single departure and arrival on Indian soil of the travelers. Multi Trip is for multiple to and fro journeys from India, within a year.');" onmouseout="UnTip();" border="0"></td>
                                <td>
                           <select name="tripType" id="tripType"  style="width:150px; font-weight:normal;">
                            <option id="<?php echo @$_POST['tripType'] ? $_POST['tripType'] : 'Single' ?>" selected>
                                <?php echo @$_POST['tripType'] ? $_POST['tripType'] : 'Single' ?></option>
                            </select>
                                </td>
                            </tr>

                            <tr id="asiatriptypepr" style="display:none;">
                                <td> <input type="hidden" name="tripTypeSigle" id="tripTypeSigle" value="Single"/></td>
                            </tr>

                            <tr id="maximumtrip"  style="display:none;">
                                <td height="39">Maximum trip duration <img src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg" onmouseover="Tip('The days including departure & Arrival time is taken into consideration for Multi trip.')" onmouseout="UnTip();" border="0"></td>
                                <td><div class="dropbox_long" style="padding-top: 0px;">
        <select  name="maximumtripduration" id="maximumtripduration"  style="width:130px; font-weight:normal;">
            <option value="45" <?php if ($_POST['maximumtripduration'] == 45) { echo 'selected'; } ?>>45</option>
            <option value="60" <?php if ($_POST['maximumtripduration'] == 60) { echo 'selected'; } ?>>60</option>
        </select>
                                    </div>                     
                                </td>
                            </tr>
                            <input type="hidden" name="coverType" id="coverType" value="INDIVIDUAL"/>
                            <tr>
                                <td height="40" align="left" valign="middle"><strong>Travel Date:</strong></td>
                                <td height="40" align="left" valign="middle" class="brdrotc"> 
                                    <table width="280" border="0" cellspacing="0" cellpadding="0" class="date fl">
                                        <tr>
                                            <td height="39">
                                                <table width="280" border="0" cellspacing="0" cellpadding="0" class="date fl">
                                                    <tr>
                                                        <td width="100" height="39">
                                                            <div class="dropboxdate">
                                                                <input name="startDate" type="text" id="from" placeholder="Start Date"  value="<?php echo $_POST['startDate']; ?>" class="medium_inputdate"  readonly="yes" style="cursor:pointer;" />
                                                            </div>
                                                        </td>
                                                        <td width="100">
                                                            <div class="dropboxdate">
                                                                <input name="endDate" type="text" id="to" placeholder="End Date" value="<?php echo $_POST['endDate']; ?>" class="medium_inputdate" readonly="yes" style="cursor:pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td width="20" class="hidedaysfield" align="left">Or</td>
                                                        <td class="hidedaysfield" width="60">
                                                            <div class="dropbox_days">
                                                                <input name="noday" id="noday" placeholder="days" type="text" value="<?php echo $_POST['noday']; ?>" onblur="checkNoday();"  class="medium_inputday">
                                                            </div></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td width="106" height="34">No of Travellers</td>
                                <td width="172" class="brdrotc">
     <select name="noOfTravellers" id="noOfTravellers" onchange="removeAgeBand();" style="width:73px; margin-left:3px;">
       <option value="1" <?php if ($_POST['noOfTravellers'] == 1) { echo "selected"; } ?>>01</option>
       <option value="2" <?php if ($_POST['noOfTravellers'] == 2) { echo "selected";} ?>>02</option>
       <option value="3" <?php if ($_POST['noOfTravellers'] == 3) { echo "selected"; } ?>>03</option>
       <option value="4" <?php if ($_POST['noOfTravellers'] == 4) { echo "selected"; } ?>>04</option>
       <option value="5" <?php if ($_POST['noOfTravellers'] == 5) { echo "selected"; } ?>>05</option>
       <option value="6" <?php if ($_POST['noOfTravellers'] == 6) { echo "selected"; } ?>>06</option>
    </select>
                                </td>
                            </tr>

                            <tr class="date" fl>
                              <td height="22" valign="top">Travellers Age Bands</td>
                              <td class="brdrotc"><table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_1">
                            <tr>
                             <td width="93" height="24" align="left" class="green">Traveler 1</td>
                             </tr>
                                 
                                        <tr>
                                            <td height="28">
                                                <select id="age1" name="eachmember[]" style="width:70px;" class="age">
                                                    <option value="0-40"<?php if($noofageband[0]=='0-40'){ echo "selected";} ?>>upto 40</option>
                                                    <option value="41-60"<?php if($noofageband[0]=='41-60'){ echo "selected";} ?>>41 - 60</option>
                                                    <option value="61-70"<?php if($noofageband[0]=='61-70'){ echo "selected";} ?>>61 - 70</option>
                                                    <option value="71-80"<?php if($noofageband[0]=='71-80'){ echo "selected";} ?>>71 - 80</option>
                                                    <option value="81-99"<?php if($noofageband[0]=='81-99'){ echo "selected";} ?>>80 +</option>
                                                
                                                </select>
                                            </td>
                                        </tr>
                                        
                                    </table>

                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_2">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 2</td>
                                        </tr>
                                        <tr>
                                            <td height="28">

                                                <select id="age2" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40"<?php if($noofageband[1]=='0-40'){ echo "selected";} ?>>upto 40</option>
                                                    <option value="41-60"<?php if($noofageband[2]=='41-60'){ echo "selected";} ?>>41 - 60</option>
                                                    <option value="61-70"<?php if($noofageband[3]=='61-70'){ echo "selected";} ?>>61 - 70</option>
                                                    <option value="71-80"<?php if($noofageband[4]=='71-80'){ echo "selected";} ?>>71 - 80</option>
                                                    <option value="81-99"<?php if($noofageband[5]=='81-99'){ echo "selected";} ?>>80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_3">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 3</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age3" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40">upto 40</option>
                                                    <option value="41-60">41 - 60</option>
                                                    <option value="61-70">61 - 70</option>
                                                    <option value="71-80">71 - 80</option>
                                                    <option value="81-99">80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_4">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 4</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age4" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40">upto 40</option>
                                                    <option value="41-60">41 - 60</option>
                                                    <option value="61-70">61 - 70</option>
                                                    <option value="71-80">71 - 80</option>
                                                    <option value="81-99">80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_5">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 5</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age5" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40">upto 40</option>
                                                    <option value="41-60">41 - 60</option>
                                                    <option value="61-70">61 - 70</option>
                                                    <option value="71-80">71 - 80</option>
                                                    <option value="81-99">80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_6">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 6</td>
                                        </tr>
                                        <tr>
                                            <td height="28"><div class="dropbox_long_travel">
                                                    <select id="age6" name="eachmember[]" style="width:70px;" class="age" >
                                                        <option value="0-40">upto 40</option>
                                                        <option value="41-60">41 - 60</option>
                                                        <option value="61-70">61 - 70</option>
                                                        <option value="71-80">71 - 80</option>
                                                        <option value="81-99">80 +</option>
                                                    </select>

                                            </td>
                                        </tr>
                                    </table></td>
                            </tr>                
                            <tr>
                                <td height="34">Mobile No. <label>*</label></td>
                                <td class="brdrotc">
                                    <input type="text" onkeyup="checkMobileTravel();" class="corpinput" value="<?php echo @$_POST['mobilenotr']; ?>" id="mobilenotr" name="mobilenotr" autocomplete="OFF" maxlength="10" size="37" >
                                    <input type="hidden" value="0" name="checkmobile" id="checkmobile">
                                </td>
                            </tr>
                            <tr class="date">
                                <td height="39"> Any Traveller having PED <img onmouseover="Tip('Please select ‘Yes’ if any person(s) to be insured has any of the following: heart disease, liver disease, kidney disease, cancer, Stroke, Paralysis or others');" onmouseout="UnTip();" src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg"></td>
                                <td><input type="radio" onclick="displayTravelSilider();" name="pedQuestion" id="pedQuestion-1" value="YES">&nbsp;Yes <input type="radio" name="pedQuestion" id="pedQuestion-2" value="NO" onclick="displayTravelSilider();" checked="checked">&nbsp;No</td>
                            </tr>

                            <tr class="date2">
                                <td height="39"><strong>Sum Insured</strong> (<span id="changesymbole" style="font-weight: bold;">$</span> in 000)</td>
                                <td height="28">                        
                                    <div class="slider_price_aisa">
                                        <input id="sumInsuredTravel1" name="sumInsuredTravel1" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmount" name="IndividualInsuredAmount" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                else if ((pos > 400000) && (pos <= 500000))
                                                    pos = '003';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel1").value = pos;
                                                // showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 500000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>

                                    <div class="slider_price_all">
                                        <input id="sumInsuredTravel" name="sumInsuredTravel" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmount" name="IndividualInsuredAmount" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                else if ((pos > 400000) && (pos <= 500000))
                                                    pos = '003';
                                                else if ((pos > 500000) && (pos <= 600000))
                                                    pos = '004';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 600000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>


                                    <div class="slider_price_canada">  
                                        <input id="sumInsuredTravel4" name="sumInsuredTravel4" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel4").value = pos;
                                                //    showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/>
                                        </p>
                                    </div>

                                    <div class="slider_price_asia_seventy"> 
                                        <input id="sumInsuredTravel70" name="sumInsuredTravel70" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';

                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel70").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>

                                    <div class="slider_price_europe">    
                                        <input id="sumInsuredTravel3" name="sumInsuredTravel3" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel3").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>
                                    <div class="single_price_all">    
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="text" value="001" />
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/></p>
                                    </div>
                                    <div class="singh_price_europe">    
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="text" value="001" />
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>
                                </td>
                            </tr>

                            <tr class="date3">
           <td height="18">Your Premium is &nbsp;</td>
         
                    <td>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="total2" id="pletinumplan">
                        <tbody>
                        <tr>
                            <td height="24" width="25"><input type="radio" name="goldplan[]" id="goldplan-1" value="gold" checked="checked" <?php echo (@$_POST['goldplan'][0] == 'gold') ? "checked='checked'" : ""; ?>></td>
                             <td width="15"><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td> 
                             <input type="hidden" value="" name="travelPremiumgolddata" id="travelPremiumgolddata">
                             <td><span id="travelPremiumgold" class="redtxt">
                                     <span style="font-size:17px;">----</span></span> for Gold Plan</td>
                               </tr>
                        <tr>
                          <td height="31"> <input name="goldplan[]" type="radio" id="goldplan-2" value="pletinum" <?php echo (@$_POST['goldplan'][0] == 'pletinum') ? "checked='checked'" : ""; ?>>    
                         </td>
                          <td><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td>
                          <input type="hidden" value="" name="travelPremiumplatinumdata" id="travelPremiumplatinumdata">
                          <td><span id="travelPremiumpletinum" class="redtxt"><span style="font-size:17px;">----</span></span> with Platinum Plan<img src="<?php echo $sitepathTravel;?>images/question_icon_help.png" onmouseout="UnTip();" onmouseover="Tip('Get Most popular plan with -  additional features like Compassionate visit, Return of Minor child, Accidental Death cover and Even 61 years & above will have No-Sublimits. (Other plans have No-sublimit for age 60 and below)');">
                          </td>
                        </tr>

                     </tbody>
                      </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="total2" id="glodplan">
                        <tbody>
                        <tr>
            <td height="24" width="25"><input type="radio" checked="checked" name="goldplan3" id="goldplan-3" value="singlepremium"></td>
            <td width="15"><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td>                              
            <input type="hidden" value="" name="travelPremiumdata" id="travelPremiumdata">
            <td><span id="travelPremium" class="redtxt"><span style="font-size:17px;">----</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                     </tbody>
                      </table>
                    </td></tr>
            </table>
            </td>
            </tr>

            <tr>
                <td align="left" class="tdpaddingTop"><span class="tandc" valign="middle">
                        <a href="javascript:void(0)" onclick="window.open('http://rhicluat.religare.com/terms.html', '_blank', 'width=700,height=400')">T &amp; C</a> Apply.</span>
                       <!-- <input type="hidden" name="rmCode" value="<?php //echo sanitize_data(@$_REQUEST['rmCode']);  ?>" />
                        <input type="hidden" name="source"  value="<?php //echo sanitize_data(@$_REQUEST['source']);  ?>" />
                        <input type="hidden" name="branchCode"  value="<?php //echo sanitize_data(@$_REQUEST['branchCode']);  ?>" />-->
<!--<img src="<?php //echo $sitepathTravel; ?>images/Proceed_Proposal.png" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="buynow();" style="cursor:pointer; float:right;" />-->
<?php if (@$_SESSION['loginstatus']) { ?>
                        <img src="<?php echo $sitepathTravel; ?>images/Proceed_Proposal.png" class="" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="saveTransQuotation('quotation');" style="cursor:pointer; float:right;" />
<?php } else {
    ?>
                        <img src="<?php echo $sitepathTravel; ?>images/Proceed_Proposal.png" class="" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="saveTransQuotation('loginquotation');" style="cursor:pointer; float:right;" />
                        <?php }
                        ?>
                </td>
            </tr>
            <tr>
                <td class="tdpaddingTop" colspan="2"><div style="color:red; font-size:12px;"><b>Note:</b> Policy tenure is only for 1 year.</div></td>
            </tr>
            </table>
        </form>

<?php }
else{
    $edittravelplan = array(
    "1" => array("40001001"),
    "2" => array("40001002"),
    "3" => array("40001015"),
    "4" => array("40001004"),          
    "5" => array("40001011,40001012,40001007,40001008"),
    "6" => array("40001009,40001010,40001005,40001006"));
                                      
    ?>
         <form id="select_skin_form_9" name="quote_box" method="post" style="margin:0px;" action="">
            <div id="errorinfo" align="center" style="color:red; font-size:12px;"></div>
            <table width="959" border="0" cellspacing="0" cellpadding="0" class="date fl">
                <input type="hidden" value="1" name="popuphide"> 
                <tr>
                    <td>
                        <table width="959" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="40" align="left" valign="middle"><strong>Edit Travelling To: <img onmouseover="Tip('Please select the Region of your destination you wish to buy Travel Insurance for. The highlights of the same plan will be shown on the side of page.');" onmouseout="UnTip();" src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg"></strong></td>
                                <td height="40" align="left" valign="middle" class="brdrotc"> 
                                <select name="travellingTo" id="travellingTo"  style="width:150px; height:25px; font-weight:normal;">
                                <?php foreach($TRAVELPLAN as $key =>$value) { ?>
                                     <option value="<?php echo $key; ?>" <?php
                                     $procode = trim($resultAllData[0]['PRODUCTCODE']);
                                     foreach($edittravelplan as $keys=>$valuess) { 
                                     if(in_array($procode, $valuess) && !@$_POST["travellingTo"]) 
                                      { 
                                         if($key==$keys) {
                                           echo "selected=selected";
                                        }
                                      }
                                      else
                                          {
                                          if (@$_POST["travellingTo"] == $key) {
                                               echo "selected=selected";
                                            }
                                        echo "" ;
                                      }
                                        }?>><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                                </td>
                            </tr>

                            <tr id="triptypepr" style="display:none;">
                                <td height="39">Trip type <img src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg" onmouseover="Tip('Single trip is for single departure and arrival on Indian soil of the travelers. Multi Trip is for multiple to and fro journeys from India, within a year.');" onmouseout="UnTip();" border="0"></td>
                                <td>
                           <select name="tripType" id="tripType"  style="width:150px; font-weight:normal;">
                            <option id="<?php echo @$_POST['tripType'] ? $_POST['tripType'] : 'Single' ?>" selected>
                                <?php echo @$_POST['tripType'] ? $_POST['tripType'] : 'Single' ?></option>
                            </select>
                                </td>
                            </tr>
                            
                            <tr id="asiatriptypepr" style="display:none;">
                              <td> <input type="hidden" name="tripTypeSigle" id="tripTypeSigle" value="Single"/></td>
                            </tr>

                            <tr id="maximumtrip"  style="display:none;">
                            <td height="39">Maximum trip duration <img src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg" onmouseover="Tip('The days including departure & Arrival time is taken into consideration for Multi trip.')" onmouseout="UnTip();" border="0"></td>
                           <td><div class="dropbox_long" style="padding-top: 0px;">
                            <select  name="maximumtripduration" id="maximumtripduration"  style="width:130px; font-weight:normal;">
                                <option value="45" <?php if ($_POST['maximumtripduration'] == 45) { echo 'selected'; } ?>>45</option>
                                <option value="60" <?php if ($_POST['maximumtripduration'] == 60) { echo 'selected'; } ?>>60</option>
                            </select>
                                </div>                     
                                </td>
                            </tr>
                            
                            <input type="hidden" name="coverType" id="coverType" value="INDIVIDUAL"/>
                            <tr>
                                <td height="40" align="left" valign="middle"><strong>Travel Date:</strong></td>
                                <td height="40" align="left" valign="middle" class="brdrotc"> 
                                    <table width="280" border="0" cellspacing="0" cellpadding="0" class="date fl">
                                        <tr>
                                            <td height="39">
                                                <table width="280" border="0" cellspacing="0" cellpadding="0" class="date fl">
                                                    <tr>
                                                        <td width="100" height="39">
                                                            <div class="dropboxdate">
                                                                <input name="startDate" type="text" id="from" placeholder="Start Date"  value="<?php echo $UTM_SOURCE['tripStartDate']; ?>" class="medium_inputdate"  readonly="yes" style="cursor:pointer;" />
                                                            </div>
                                                        </td>
                                                        <td width="100">
                                                            <div class="dropboxdate">
                                                                <input name="endDate" type="text" id="to" placeholder="End Date" value="<?php echo $UTM_SOURCE['tripEndDate'];; ?>" class="medium_inputdate" readonly="yes" style="cursor:pointer;"/>
                                                            </div>
                                                        </td>
                                                        <td width="20" class="hidedaysfield" align="left">Or</td>
                                                        <td class="hidedaysfield" width="60">
                                                            <div class="dropbox_days">
                                                                <input name="noday" id="noday" placeholder="days" type="text" value="<?php echo $_POST['noday']; ?>" onblur="checkNoday();"  class="medium_inputday">
                                                            </div></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td width="106" height="34">Edit No of Travellers</td>
                                <td width="172" class="brdrotc">
     <select name="noOfTravellers" id="noOfTravellers" onchange="removeAgeBand();" style="width:73px; margin-left:3px;">
       <option value="1" <?php if (@$resultData['MEMBER_COUNT'] == 1 or $_POST['noOfTravellers'] == 1) { echo "selected"; }  ?>>01</option>
       <option value="2" <?php if (@$resultData['MEMBER_COUNT'] == 2 or $_POST['noOfTravellers'] == 2) { echo "selected"; } ?>>02</option>
       <option value="3" <?php if (@$resultData['MEMBER_COUNT'] == 3 or $_POST['noOfTravellers'] == 3) { echo "selected"; }  ?>>03</option>
       <option value="4" <?php if (@$resultData['MEMBER_COUNT'] == 4 or $_POST['noOfTravellers'] == 4) { echo "selected"; }  ?>>04</option>
       <option value="5" <?php if (@$resultData['MEMBER_COUNT'] == 5 or $_POST['noOfTravellers'] == 5) { echo "selected"; }  ?>>05</option>
       <option value="6" <?php if (@$resultData['MEMBER_COUNT'] == 6 or $_POST['noOfTravellers'] == 6) { echo "selected"; }  ?>>06</option>
    </select>
                                </td>
                            </tr>
                            
                           <?php
                           $resultData['ELDEST_MEMBER_AGE'];
                           $noofbands = explode(",",$resultData['ELDEST_MEMBER_AGE']);
                           
                           ?>
                                                        
                            <tr class="date" fl>
                                <td height="22" valign="top">Travellers Age Bands</td>
                                <td class="brdrotc">
                                    
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_1">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 1</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                               
                                            <select id="age1" name="eachmember[]" style="width:70px;" class="age" >
                                                <option value="0-40" <?php if($noofbands[0] == "0-40"){ echo "selected"; } ?>>upto 40</option>
                                                <option value="41-60"<?php if($noofbands[0] == "41-60"){ echo "selected"; } ?>>41 - 60</option>
                                                <option value="61-70"<?php if($noofbands[0] == "61-70"){ echo "selected"; } ?>>61 - 70</option>
                                                <option value="71-80"<?php if($noofbands[0] == "71-80"){ echo "selected"; } ?>>71 - 80</option>
                                                <option value="81-99"<?php if($noofbands[0] == "81-99"){ echo "selected"; } ?>>80 +</option>
                                            </select>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_2">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 2</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age2" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40" <?php if($noofbands[0] == "0-40"){ echo "selected"; } ?>>upto 40</option>
                                                <option value="41-60"<?php if($noofbands[0] == "41-60"){ echo "selected"; } ?>>41 - 60</option>
                                                <option value="61-70"<?php if($noofbands[0] == "61-70"){ echo "selected"; } ?>>61 - 70</option>
                                                <option value="71-80"<?php if($noofbands[0] == "71-80"){ echo "selected"; } ?>>71 - 80</option>
                                                <option value="81-99"<?php if($noofbands[0] == "81-99"){ echo "selected"; } ?>>80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_3">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 3</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age3" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40">upto 40</option>
                                                <option value="41-60">41 - 60</option>
                                                <option value="61-70">61 - 70</option>
                                                <option value="71-80">71 - 80</option>
                                                <option value="81-99">80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_4">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 4</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age4" name="eachmember[]" style="width:70px;" class="age" >
                                                    <option value="0-40" <?php if($noofbands[0] == "0-40"){ echo "selected"; } ?>>upto 40</option>
                                                <option value="41-60"<?php if($noofbands[0] == "41-60"){ echo "selected"; } ?>>41 - 60</option>
                                                <option value="61-70"<?php if($noofbands[0] == "61-70"){ echo "selected"; } ?>>61 - 70</option>
                                                <option value="71-80"<?php if($noofbands[0] == "71-80"){ echo "selected"; } ?>>71 - 80</option>
                                                <option value="81-99"<?php if($noofbands[0] == "81-99"){ echo "selected"; } ?>>80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_5">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 5</td>
                                        </tr>
                                        <tr>
                                            <td height="28">
                                                <select id="age5" name="eachmember[]" style="width:70px;" class="age" >
                                                   <option value="0-40" <?php if($noofbands[0] == "0-40"){ echo "selected"; } ?>>upto 40</option>
                                                <option value="41-60"<?php if($noofbands[0] == "41-60"){ echo "selected"; } ?>>41 - 60</option>
                                                <option value="61-70"<?php if($noofbands[0] == "61-70"){ echo "selected"; } ?>>61 - 70</option>
                                                <option value="71-80"<?php if($noofbands[0] == "71-80"){ echo "selected"; } ?>>71 - 80</option>
                                                <option value="81-99"<?php if($noofbands[0] == "81-99"){ echo "selected"; } ?>>80 +</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="93" border="0" cellspacing="0" cellpadding="0" class="date1 fl memberlist"  id="aged_6">
                                        <tr>
                                            <td width="93" height="24" align="left" class="green">Traveler 6</td>
                                        </tr>
                                        <tr>
                                            <td height="28"><div class="dropbox_long_travel">
                                                    <select id="age6" name="eachmember[]" style="width:70px;" class="age" >
                                                        <option value="0-40" <?php if($noofbands[0] == "0-40"){ echo "selected"; } ?>>upto 40</option>
                                                <option value="41-60"<?php if($noofbands[0] == "41-60"){ echo "selected"; } ?>>41 - 60</option>
                                                <option value="61-70"<?php if($noofbands[0] == "61-70"){ echo "selected"; } ?>>61 - 70</option>
                                                <option value="71-80"<?php if($noofbands[0] == "71-80"){ echo "selected"; } ?>>71 - 80</option>
                                                <option value="81-99"<?php if($noofbands[0] == "81-99"){ echo "selected"; } ?>>80 +</option>
                                                    </select>

                                            </td>
                                        </tr>
                                    </table></td>
                            </tr>                
                            <tr>
                                <td height="34">Mobile No. <label>*</label></td>
                                <td class="brdrotc">
                                    <input type="text" onkeyup="checkMobileTravel();" class="corpinput" value="<?php if(@$_POST['mobilenotr']){ echo $_POST['mobilenotr']; } else {echo @$resultData['MOBILE_NO']; } ?>" id="mobilenotr" name="mobilenotr" autocomplete="OFF" maxlength="10" size="37" >
                                    <input type="hidden" value="0" name="checkmobile" id="checkmobile">
                                </td>
                            </tr>
                            
                            <tr class="date">
                                <td height="39"> Any Traveller having PED <img onmouseover="Tip('Please select ‘Yes’ if any person(s) to be insured has any of the following: heart disease, liver disease, kidney disease, cancer, Stroke, Paralysis or others');" onmouseout="UnTip();" src="<?php echo $sitepathTravel; ?>images/questionsmark.jpg"></td>
                                <td><input type="radio" onclick="displayTravelSilider();" name="pedQuestion" id="pedQuestion-1" value="YES">&nbsp;Yes <input type="radio" name="pedQuestion" id="pedQuestion-2" value="NO" onclick="displayTravelSilider();" checked="checked">&nbsp;No</td>
                            </tr>

                            <tr class="date2">
                                <td height="39"><strong> Sum Insured </strong> ( <span id="changesymbole" style="font-weight:bold;">$</span> in 000)</td>
                                <td height="28">                        
                                    <div class="slider_price_aisa">
                                        <input id="sumInsuredTravel1" name="sumInsuredTravel1" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmount" name="IndividualInsuredAmount" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                else if ((pos > 400000) && (pos <= 500000))
                                                    pos = '003';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel1").value = pos;
                                                // showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 500000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>

                                    <div class="slider_price_all">
                                        <input id="sumInsuredTravel" name="sumInsuredTravel" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmount" name="IndividualInsuredAmount" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                else if ((pos > 400000) && (pos <= 500000))
                                                    pos = '003';
                                                else if ((pos > 500000) && (pos <= 600000))
                                                    pos = '004';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 600000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>


                                    <div class="slider_price_canada">  
                                        <input id="sumInsuredTravel4" name="sumInsuredTravel4" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel4").value = pos;
                                                //    showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/>
                                        </p>
                                    </div>

                                    <div class="slider_price_asia_seventy"> 
                                        <input id="sumInsuredTravel70" name="sumInsuredTravel70" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';

                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel70").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>

                                    <div class="slider_price_europe">    
                                        <input id="sumInsuredTravel3" name="sumInsuredTravel3" type="hidden" value="001" />
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="200000" />
                                        <script language="javascript" type="text/javascript">
                                            window.dhx_globalImgPath = "<?php echo $sitepathTravel; ?>images";
                                        </script>
                                        <script language="javascript" type="text/javascript">
                                            function handler(pos, slider) {
                                                if ((pos > 200000) && (pos <= 300000))
                                                    pos = '001';
                                                else if ((pos > 300000) && (pos <= 400000))
                                                    pos = '002';
                                                document.getElementById("premval").value = pos;
                                                document.getElementById("sumInsuredTravel3").value = pos;
                                                //  showPlan(pos);
                                                searchResult();
                                            }

                                            var slider = new dhtmlxSlider(null, 283, null, null, 300000, 400000, document.getElementById("IndividualInsuredAmount").value, 100000);
                                            slider.attachEvent("onChange", handler);
                                            slider.init();
                                        </script>
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>
                                    <div class="single_price_all">    
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="001" />
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/></p>
                                    </div>
                                    <div class="singh_price_europe">    
                                        <input id="IndividualInsuredAmountNew" name="IndividualInsuredAmountNew" type="hidden" value="001" />
                                        <p class="insur-amt"><input type="hidden" name="premval" id="premval" value="001"/> </p>
                                    </div>
                                </td>
                            </tr>

                            <tr class="date3">
           <td height="18">Your Premium is &nbsp;</td>
         
                    <td>
                       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="total2" id="pletinumplan">
                        <tbody>
                        <tr>
                            <td height="24" width="25"><input type="radio" name="goldplan[]" id="goldplan-1" value="gold" checked="checked" <?php echo (@$_POST['goldplan'][0] == 'gold') ? "checked='checked'" : ""; ?>></td>
                             <td width="15"><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td> 
                             <input type="hidden" value="" name="travelPremiumgolddata" id="travelPremiumgolddata">
                             <td><span id="travelPremiumgold" class="redtxt">
                                     <span style="font-size:17px;">----</span></span> for Gold Plan</td>
                               </tr>
                        <tr>
                          <td height="31"> <input name="goldplan[]" type="radio" id="goldplan-2" value="pletinum" <?php echo (@$_POST['goldplan'][0] == 'pletinum') ? "checked='checked'" : ""; ?>>    
                         </td>
                          <td><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td>
                          <input type="hidden" value="" name="travelPremiumplatinumdata" id="travelPremiumplatinumdata">
                          <td><span id="travelPremiumpletinum" class="redtxt"><span style="font-size:17px;">----</span></span> with Platinum Plan<img src="<?php echo $sitepathTravel;?>images/question_icon_help.png" onmouseout="UnTip();" onmouseover="Tip('Get Most popular plan with -  additional features like Compassionate visit, Return of Minor child, Accidental Death cover and Even 61 years & above will have No-Sublimits. (Other plans have No-sublimit for age 60 and below)');">
                          </td>
                        </tr>

                     </tbody>
                      </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="total2" id="glodplan">
                        <tbody>
                        <tr>
            <td height="24" width="25"><input type="radio" checked="checked" name="goldplan3" id="goldplan-3" value="singlepremium"></td>
            <td width="15"><img src="<?php echo $sitepathTravel;?>images/rupeesymbol_gr.png"></td>                              
            <input type="hidden" value="" name="travelPremiumdata" id="travelPremiumdata">
            <td><span id="travelPremium" class="redtxt"><span style="font-size:17px;">----</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                     </tbody>
                      </table>
                    </td></tr>
            </table>
            </td>
            </tr>

            <tr>
                <td align="left" class="tdpaddingTop"><span class="tandc" valign="middle">
                        <a href="javascript:void(0)" onclick="window.open('http://rhicluat.religare.com/terms.html', '_blank', 'width=700,height=400')">T &amp; C</a> Apply.</span>
                       <!-- <input type="hidden" name="rmCode" value="<?php //echo sanitize_data(@$_REQUEST['rmCode']);  ?>" />
                        <input type="hidden" name="source"  value="<?php //echo sanitize_data(@$_REQUEST['source']);  ?>" />
                        <input type="hidden" name="branchCode"  value="<?php //echo sanitize_data(@$_REQUEST['branchCode']);  ?>" />-->
<!--<img src="<?php //echo $sitepathTravel; ?>images/Proceed_Proposal.png" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="buynow();" style="cursor:pointer; float:right;" />-->
<?php if (@$_SESSION['loginstatus']) { ?>
                        <img src="<?php echo $sitepathTravel; ?>images/Proceed_Proposal.png" class="" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="saveTransQuotation('quotation');" style="cursor:pointer; float:right;" />
<?php } else {
    ?>
                        <img src="<?php echo $sitepathTravel; ?>images/Proceed_Proposal.png" class="" id="carebuynowimage" alt="Buy" title="Buy" border="0" onclick="saveTransQuotation('loginquotation');" style="cursor:pointer; float:right;" />
                        <?php }
                        ?>
                </td>
            </tr>
            <tr>
                <td class="tdpaddingTop" colspan="2"><div style="color:red; font-size:12px;"><b>Note:</b> Policy tenure is only for 1 year.</div></td>
            </tr>
            </table>
        </form>
        
       <?php } ?>
        <!--added by shakti-->        
        <div  style="display:none;">
            <div id='inline_proceedpay'>
                <div class="pop_proceed fl" id="issuanceresult">
                    <div class="pop_proceedContainer" style="height:200px;">
                        <div class="yrprotxt"> Authenticate your account by entering following details – </div>
<?php
include("travel_login.php");
?>
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
        </div>
        <!--upto-->
    </div>
    <div class="cl"></div>
</div>


<script>
    $(function () {
        var dates = $('#from, #to').datepicker({
            defaultDate: "0",
            changeMonth: true,
            numberOfMonths: 1,
            minDate: 0,
            dateFormat: "dd-mm-yy",
            maxDate: 730,
            onSelect: function (selectedDate) {
                var tripType = $("#tripType").val();
                var fromvalue = $("#from").val();
                var tovalue = $("#to").val();
                if (fromvalue != '' && (fromvalue != 'Start Date')) {
                    $.ajax({
                        type: "POST",
                        url: "dateCheck.php",
                        async: true,
                        data: "fromvalue=" + fromvalue + "&tripType=" + tripType + "&tovalue=" + tovalue,
                        success: function (msg) {
                            var t = msg.split(":");
                            $("#noday").val(t[0]);
                            $("#to").val(t[1]);
                            searchResultDate();
                        }
                    });
                }
            }
        });
    });


    function saveTransQuotation(formType)
{    
    var travellingTo = $('#travellingTo').val();
    var premiumamount = 0;
    var travelPremType ='';
    if(travellingTo == '5' || travellingTo == '6')
    {
        $('input[name="goldplan[]"]:checked').each(function() {  
            premiumamount = $("#travelPremium" + this.value).html();
            travelPremType = this.value; 
    });    
    }
    else
    {
        premiumamount = $("#travelPremium").html();        
        travelPremType = this.value; 
    }
    //alert(travelPremType);
    //var premiumgold = $('#travelPremiumgolddata').html();
    //var premiumpletinum = $('#travelPremiumplatinumdata').html();
    $.ajax({ 
                type: "POST", 
                url: "saveTransDetail.php",
                data: $('form').serialize() + "&premiumamount=" + premiumamount + "&travelPremType=" + travelPremType + "&formtype=" + formType, 
                success: function(data) {
                            if(data == 'successagentbalance')
                            {
                                buynowafterlogin();
                            }
                            else if (data == 'errorlessagentbalance')            
                            {
                                $('#errorinfo').html('*You do not have sufficient balance to proceed further.');
                                return false;
                            }
                            else
                            {
                                console.log("Premium can't be blank.");
                                buynow();
                            }
                          }
         });
 }

    function saveTransQuotation_old()
    {
        $.ajax({
            type: "POST",
            url: "saveTransDetail.php",
            //data: {formdata: $('form').serialize(), premiumamount: premiumamount},
            data: $('form').serialize(),
            success: function (data) {
                if (data == 'successagentbalance')
                {
                    buynowafterlogin();
                }
                else if (data == 'errorlessagentbalance')
                {
                    $('#errorinfo').html('*You do not have sufficient balance to proceed further.');
                    return false;
                }
                else
                {
                    alert(data);
                }
            }
        });
    }


    function editdisplayTripType1(tripType) {
        var travellingTo = $("#travellingTo").val();
        $.ajax({
            type: "POST",
            url: "ajaxGetTravelTripType.php",
            async: true,
            data: "travellingTo=" + travellingTo,
            beforeSend: function () {

            },
            success: function (msg) {
                var msg1 = msg.split('|');
                $('#tripType').children().remove();

                for (i = 0; i < msg1.length; i++) {
                    var sel = '';
                    if (tripType == 'Multi')
                    {
                        sel = 'selected';
                    }
                    $('#tripType').append('<option id="' + msg1[i] + '" ' + sel + '>' + msg1[i] + '</option>');
                }
                $("#c_tripType").html(msg1[0]);
                displayTravelCoverType();

            }
        });
    }

</script>
