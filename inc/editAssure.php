<div class="mid_inner_container_otc" id="getSearch">
    <div class="quoteBoxgreen fl"></div>
    <div class="quoteBoxgreenBottom fl">
        <table width="959" border="0" cellspacing="0" cellpadding="0" class="fl">
            <tr>
                <td><table width="959" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="40" align="left" valign="middle"><strong>Age:</strong></td>
                            <td height="40" align="left" valign="middle" class="brdrotc">
							<div>
							<input type="text" name="qdob" id="qdob" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" value="<?php 
							if($QuotationDOB!='') { echo $QuotationDOB;	}	else { echo '13/01/1982';	}?>" onClick="var retval = checkDateVal();
                                                                if (retval == false) {
                                                                    return false;
                                                                }
                                                                scwShow(scwID('qdob'), event, '<?php echo $curentData; ?>');" />
							<input type="hidden" name="ageGroupOfEldestMember" id="ageGroupOfEldestMember" value="" />
							</div>
                               <!-- <div class="dropdown_otc1">
                                    <div class="dropbox_shot">
                                        <select class="styled width110" name="ageGroupOfEldestMember" id="ageGroupOfEldestMember" onchange="assuresearch();">
                                            <option value="18 - 25" <?php
                                            if ($ageGroupOfEldestMember == "18 - 25") {
                                                echo "selected=selected";
                                            }
                                            ?>>18-25</option>
                                            <option value="26 - 30" <?php
                                            if ($ageGroupOfEldestMember == "26 - 30") {
                                                echo "selected=selected";
                                            }
                                            ?>>26-30</option>
                                            <option value="31 - 35" <?php
                                            if ($ageGroupOfEldestMember == "31 - 35") {
                                                echo "selected=selected";
                                            }
                                            ?>>31-35</option>
                                            <option value="36 - 40" <?php
                                            if ($ageGroupOfEldestMember == "36 - 40") {
                                                echo "selected=selected";
                                            }
                                            ?>>36-40</option>
                                            <option value="41 - 45" <?php
                                            if ($ageGroupOfEldestMember == "41 - 45") {
                                                echo "selected=selected";
                                            }
                                            ?>>41-45</option>
                                            <option value="46 - 50" <?php
                                            if ($ageGroupOfEldestMember == "46 - 50") {
                                                echo "selected=selected";
                                            }
                                            ?>>46-50</option>
                                            <option value="51 - 55" <?php
                                            if ($ageGroupOfEldestMember == "51 - 55") {
                                                echo "selected=selected";
                                            }
                                            ?>>51-55</option>
                                            <option value="56 - 60" <?php
                                            if ($ageGroupOfEldestMember == "56 - 60") {
                                                echo "selected=selected";
                                            }
                                            ?>>56-60</option>
                                            <option value="61 - 65" <?php
                                            if ($ageGroupOfEldestMember == "61 - 65") {
                                                echo "selected=selected";
                                            }
                                            ?>>61-65</option>
                                        </select>
                                    </div>
                                </div>--></td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                            <td height="40" align="left" valign="middle" class="brdrotc">&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td class="tdpadding"><table width="959" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="149" height="52"><strong>Sum Insured</strong> (In Lakh) :</td>
                            <td width="275" height="52">
                                <div class="slider_price3">

                                    <input id="IndividualInsuredAmount" name="IndividualInsuredAmount" type="hidden" value="<?php echo $individualInsuredAmountAssure; ?>" />
                                    <input id="sumInsured1" name="sumInsured1" type="hidden" value="<?php echo $sumInsuredValue; ?>" />
                                    <script language="javascript" type="text/javascript">
                                                    window.dhx_globalImgPath = "images/";

                                                    function handler(pos, slider) {
                                                        if ((pos > 100000) && (pos <= 200000))
                                                            pos = 500000;
                                                        else if ((pos > 200000) && (pos <= 300000))
                                                            pos = 1000000;
                                                        else if ((pos > 300000) && (pos <= 400000))
                                                            pos = 1500000;
                                                        else if ((pos > 400000) && (pos <= 500000))
                                                            pos = 2000000;
                                                        else if ((pos > 500000) && (pos <= 600000))
                                                            pos = 3000000;
                                                        else if ((pos > 600000) && (pos <= 700000))
                                                            pos = 5000000;
                                                        else if ((pos > 700000) && (pos <= 800000))
                                                            pos = 7500000;
                                                        else if ((pos > 800000) && (pos <= 900000))
                                                            pos = 10000000;

                                                        document.getElementById("IndividualInsuredAmount").value = pos;
                                                        document.getElementById("sumInsured1").value = pos;
                                                        assuresearch();
                                                    }

                                                    var slider = new dhtmlxSlider(null, 252, null, null, 200000, 900000, document.getElementById("IndividualInsuredAmount").value, 100000);

                                                    slider.attachEvent("onChange", handler);
                                                    slider.init();
                                    </script>

                                    <p class="insur-amt"></p>
                                </div>
                                <div class="slider_price4">
                                    <input id="IndividualInsuredAmount3" name="IndividualInsuredAmount3" type="hidden" value="<?php echo $individualInsuredAmountAssure1; ?>" />
                                    <input id="sumInsured2" name="sumInsured2" type="hidden" value="<?php echo $sumInsuredValue1; ?>" />
                                    <script language="javascript" type="text/javascript">
                                        window.dhx_globalImgPath = "images/";

                                        function handler2(pos2, slider) {
                                            if ((pos2 > 100000) && (pos2 <= 200000))
                                                pos2 = 500000;
                                            else if ((pos2 > 200000) && (pos2 <= 300000))
                                                pos2 = 1000000;

                                            document.getElementById("IndividualInsuredAmount3").value = pos2;
                                            document.getElementById("sumInsured2").value = pos2;
                       
                                            assuresearch();
                                        }

                                        var slider = new dhtmlxSlider(null, 252, null, null, 200000, 300000, document.getElementById("IndividualInsuredAmount3").value, 100000);

                                        slider.attachEvent("onChange", handler2);
                                        slider.init();
                                    </script>
                                    <p class="insur-amt"></p>
                                </div>

                            </td>
                            <td width="101" height="52" align="left"><p class="insur-amt">
                                    
                                    </p></td>
                            <td width="434" height="52" align="right" valign="middle" class="brdrotcLeft"><table width="410" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="26" align="left" valign="top" class="brdrotc">&nbsp;&nbsp;<strong>Tenure:&nbsp;&nbsp;&nbsp;
                                                <input name="tenure" type="radio" value="1" id="tenure1" onclick="assuresearch();" <?php if ($tenure == 1) { ?> checked="checked" <?php } ?> />
                                                &nbsp;1 year&nbsp;&nbsp;&nbsp;<input name="tenure" type="radio" value="2" id="tenure2" onclick="assuresearch();" <?php if ($tenure == 2) { ?> checked="checked" <?php } ?> />&nbsp;2 year&nbsp;&nbsp;&nbsp;<input name="tenure" type="radio" value="3" id="tenure3" onclick="assuresearch();" <?php if ($tenure == 3) { ?> checked="checked" <?php } ?> />&nbsp;3 year</strong></td>
                                    </tr>
                                    <tr>
                                        <td height="40" align="left" valign="bottom">&nbsp;&nbsp;<strong>Your premium is:&nbsp;&nbsp;&nbsp;
                                                <input name="radio2" type="radio" id="radio" value="radio2" checked /> 
                                                For  <img alt="" src="images/rupeesymbol_gr.png"> <span class="redtxt1" id="assurecaresi">--------</span> is   <img alt="" src="images/rupeesymbol_gr.png"> <span class="redtxt1" id="assurecare">-----</span></strong></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td class="tdpaddingTop"><span class="tandc"><a href="javascript:void(0)" onclick="window.open('http://rhicluat.religare.com/terms.html','_blank','width=700,height=400')">T &amp; C</a> Apply.</span><img src="images/clickHerebtn.png" alt="click here"  class="fr" border="0" id="clickbuy" style="cursor:pointer;"></td>
            </tr>
        </table>
    </div>







    <div class="cl"></div></div>
