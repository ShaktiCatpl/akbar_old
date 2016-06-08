<?php
$noofpost = $_POST['nooftravel'];


for ($i=1; $i<=$noofpost; $i++) {
                ?>

                    <div class="proposerDetailBoxFormgray fl">
                    <table width="949" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="180" valign="top">
                             <div class="" id="ValidRelationAddClass-<?php echo $i;?>" style="width:85px;">
                            <select name="relationCd[]" id="relationCd-<?php echo $i; ?>" class="" onChange="changeTitleCd(this,<?php echo $i; ?>);" style="width:80px; font-weight:normal;">
                            <option value="SELF">Self</option>      
                            </select>
                            </div>
                            </td>
                            <td width="180" valign="top"><div class="" style="width:85px;">
                            <select name="titleCd[]" id="titleCd-<?php echo $i; ?>" class="" style="width:80px; font-weight:normal;">
                           <option value="0" >Title</option>
                            <option value="MR">Mr</option>
                            <option value="MS">Ms</option>
                           
                             </select>
                             </div></td>
                            <td width="252" valign="top"><input type="text" name="firstNameCd[]" id="firstNamecd-<?php echo $i; ?>" class="txtfield_OTC required" style="width:125px;" placeholder="First Name" value="<?php echo @$jsonDependentDetail[$dep]->firstNameCd; ?>" />
                                &nbsp;<span class="mandatorytxt">*</span></td>
                            <td width="295" valign="top"><input type="text" name="lastNameCd[]" id="lastNamecd-<?php echo $i; ?>" class="txtfield_OTC" style="width:125px;" placeholder="Last Name" value="<?php echo @$jsonDependentDetail[$dep]->lastNameCd; ?>" />
                                &nbsp;<span class="mandatorytxt">*</span></td>
                            <td width="278" valign="top"><input type="text" name="dOBCd[]" id="datepickerCD-<?php echo $i; ?>" class="txtfield_OTCDate" style="width:125px;" placeholder="DOB - DD/MM/YYYY" value="<?php echo @$jsonDependentDetail[$dep]->dOBCd; ?>" /></td>
                            <td width="278" valign="top"> &nbsp;<span class="mandatorytxt">*</span><input type="text" name="passPort[]" id="passport-<?php echo $i; ?>" class="txtfield_OTC" style="width:125px;" placeholder="Passport" value="<?php //echo @$jsonDependentDetail[$dep]->lastNameCd; ?>" /></td>
                        </tr>
                    </table>
                    </div>
<?php } ?>

