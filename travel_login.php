<script type="text/javascript">

function agentValidation()
{
    var premiumamount = 0;
    var atLeastOneIsChecked = $('input[name="goldplan"]:checked').length;
    if(atLeastOneIsChecked == 1)
    {
        $('input[name="goldplan"]:checked').each(function() {
        premiumamount = $("#travelPremium"+this.value+'data').val();
    });
    }
    else
    {
        premiumamount = $("#travelPremiumdata").val();        
    }
    $.ajax({ 
                type: "POST", 
                //url: "api/agentloginapi.php",
                url: "api/agentapi.php",
                //async:false,
                dataType:'json',
                data: {username: $("#username").val(), password: $("#password").val(), premiumamount: premiumamount}, 
                beforeSend: function(){   
                                if($("#username").val()=='' || $("#password").val() == ''){                                    
                                    alert('Please fill the login detail');
                                    return false;
                                }
                                $('.loader').css('display', 'block');
                            },
                success: function(data) {  
                            $('.loader').css('display', 'none');   
                            if(data == '' || data == null || data.error == 'errorlogin')
                            {
                                alert('Username or password is not valid');
                            }                            
                            else if(data.error == '' || data.error == 'errorlessagentbalance')
                            {          
                                $.colorbox.close();                                
                                document.getElementById("carefloat").setAttribute('onclick','getagentfloat("care");');
                                document.getElementById("carebuynowimage").setAttribute('onclick','saveTransQuotation();');     
                                $('.welcomeagent').html(data.spanwelcomeagent);
                                $('.agentbalance').html(data.spanagentbalance);
                                $('#carefloatresult').html(data.spanagentbalance);                                
                                if(data.error == 'errorlessagentbalance')
                                {                                
                                    $('#errorinfo').html('*You do not have sufficient balance to proceed further.');
                                }
                                else
                                {
                                    $("#select_skin_form_9").submit();                                    
                                }
                            }
                            else
                            {
                                console.log(data);
                            }
                            //submit_form(data);
                          }                          
         });
 }
 

</script>


<div class="mid_inner_container_otc_pop" id="proposal_form1" >

     <form id="select_skin_form_1" name="quote_box" method="post" style="margin:0px;" action="travel_login.php">
       
      <table border="0" cellspacing="0" cellpadding="0" class="date" align="center">
          
        <tr>
          <td width="100" height="35">Username</td>
          <td><input type="text" name="username" id="username" /></td>
        </tr>
   
        <tr>
          <td height="35">Password</td>
          <td><input type="password" name="password" id="password" /></td>
        </tr>
   
        <tr>
            <td>&nbsp;</td>
            <td><input type="button" class="agentlogin" name="do_login" value="Login" onclick="agentValidation()"/></td>
            <td><img class='loader' src="images/loading.gif" alt='' style="display:none"></td>
        </tr>
   
      </table>
    </form>

   <!-- <img src="images/grayotcBot.jpg" class="fl">-->
    <div class="cl"></div>

</div>

