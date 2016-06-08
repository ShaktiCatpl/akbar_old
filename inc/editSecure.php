<div class="mid_inner_container_otc" id="getSearch">
  <div class="quoteBoxgreen">Get a Quick Quote > Secure</div>
  <div class="quoteBoxgreenBottom fl">
    <form action="" method="POST" name="editCareBox" id="editCareBox">
      <table width="959" border="0" cellspacing="0" cellpadding="0" class="fl">
        <tr>
          <td><table width="959" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40" align="left" valign="middle"><strong>DOB:</strong></td>
                <td height="40" align="left" valign="middle" class="brdrotc"><div>
                    <input type="text" name="qdob" id="qdob" class="txtfield_OTCDate" style="width:170px;" placeholder="DOB - DD/MM/YYYY" value="<?php 
							if($QuotationDOB!='') { echo $QuotationDOB;	}	else { echo '13/01/1982';	}?>" onClick="var retval = checkDateVal();
                                                                if (retval == false) {
                                                                    return false;
                                                                }
                                                                scwShow(scwID('qdob'), event, '<?php echo $curentData; ?>');" maxlength="10" />
                    <input type="hidden" name="ageGroupOfEldestMember" id="ageGroupOfEldestMember" value="" />
                  </div></td>
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
                <td width="275" height="52"><div class="slider_pricen1_secure">
                    <input id="sumInsuredSecure" name="sumInsuredSecure" type="hidden" value="<?php echo $sumInsuredValue1?>" />
                    <input id="IndividualInsuredAmountSecure" name="IndividualInsuredAmountSecure" type="hidden" value="<?php echo $individualInsuredAmountAssure?>" />
                    <script language="javascript" type="text/javascript">
                                                        window.dhx_globalImgPath = "images";
                                                    </script> 
                    <script language="javascript" type="text/javascript">
                                                        function handlerSecure(pos, slider) {
                                                            if ((pos > 100000) && (pos <= 200000))
                                                                pos = 1500000;
                                                            else if ((pos > 200000) && (pos <= 300000))
                                                                pos = 2000000;                                                     

                                                            document.getElementById("IndividualInsuredAmountSecure").value = pos;
                                                            document.getElementById("sumInsuredSecure").value = pos;
                                                            $("#premvalSecure").html(pos);                                                           
                                                            secureResult();
                                                        }
                                                        var sliderSecure = new dhtmlxSlider(null, 252, null, null, 200000, 300000, document.getElementById("IndividualInsuredAmountSecure").value, 100000);

                                                        sliderSecure.attachEvent("onChange", handlerSecure);
                                                        sliderSecure.init();
                                                    </script>
                    <p class="insur-amt">&nbsp; </p>
                  </div></td>
                <td width="101" height="52" align="left"><p class="insur-amt">
                    <label> <img src="images/rupeesymbol_otc.png" alt="" /></label>
                    <label id="premvalSecure"><?php echo $sumInsuredValue1?></label>
                  </p></td>
                <td width="434" height="52" align="right" valign="middle" class="brdrotcLeft"><table width="410" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="26" align="left" valign="top" class="brdrotc">&nbsp;&nbsp;<strong>Tenure:&nbsp;&nbsp;&nbsp;
                        <input name="tenure" type="radio" id="tenure1" value="1" checked onclick="secureResult();" />
                        &nbsp;1 year
                       </strong></td>
                    </tr>
                    <tr>
                      <td height="45" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="32%" valign="top">&nbsp;&nbsp;<strong>Your premium is:&nbsp;</strong></td>
                            <td width="68%"><strong>
                              <div id="careonerow">
                                <input type="radio" name="premiumradio" id="premiumradio-1" value="care" checked="checked"/>
                                <input type="hidden" name="premium1" id="premium1" value=""/>
                                <img alt="" src="images/rupeesymbol_gr.png">
                                <div class="redtxt1" id="secureprimiumone" style="display:inline-block;">----</div>
                                <br />
                              </div>
                              <!--<div id="caresecondrow">
                              <input type="radio" name="premiumradio" id="premiumradio-2" value="ncb"/>
                              <input type="hidden" name="premium2care" id="premium2" value=""/>
                              <img alt="" src="images/rupeesymbol_gr.png">
                              <div class="redtxt1" id="secureprimiumtwo" style="display:inline-block;">----</div>
                              with Add – on Benefit</strong></div>-->
                              </td>
                          </tr>
                          <!--<tr><td colspan="2"><div style="color:red;"><b>Note:</b> Policy tenure is only for 1 year.</div></td></tr>-->
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td class="tdpaddingTop"><span class="tandc"><a href="javascript:void(0)" onclick="window.open('http://rhicluat.religare.com/terms.html','_blank','width=700,height=400')">T &amp; C</a> Apply.</span>
            <input type="hidden" name="checkPageOpen" id="CheckPageOpen" value="9">
            <img src="images/Proceed_Proposal.png" alt="click here"  class="fr" border="0" id="clickbuy" style="cursor:pointer;"></td>
        </tr>
         <tr>
          <td class="tdpaddingTop" colspan="2"><div style="color:red;"><b>Note:</b> Policy tenure is only for 1 year.</div></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="cl"></div>
</div>