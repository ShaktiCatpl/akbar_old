<script>
    
function getagentfloat(type){
    var policynum 	= $("#pnm").val();
	if(type=='secure') {
		$("#securefloatresult").html('<img src="images/loading.gif" />');	
		//var policynum 	= '20008802';//$("#policynum").val();
    	var subsnum		= '303';//$("#subsnum").val();
	}	else {
		$("#carefloatresult").html('<img src="images/loading.gif" />');
		//var policynum 	= '20008802';	//$("#policynum").val();
    	var subsnum		= '103';	// $("#subsnum").val();
	}
    $.ajax({ 
			type: "POST", 
			url: "api/agentapi.php",
			//async:false,
			//data: "policynum="+policynum+"&subsnum="+subsnum, 
			success: function(msg){
                        if(msg=='Error') {
				alert('Please try after some time...');
				if(type=='secure') {
					 $("#securefloatresult").html('');		
				}	else {					
					 $("#carefloatresult").html(': Rs '+msg);
				}
			}	
                        else {	
				if(type=='secure') {
					 $("#securefloatresult").html(': Rs '+msg);		
				}	else {					
					 $("#carefloatresult").html(': Rs '+msg);	
					}
				}
			}
                        /*var msgarr	=	split.msg;
                        var msgarr	=	msg.split(":");
			var msg1	= msgarr[0];
			var msg2	= msgarr[1];
			if(msg1=='Error') {
				alert('Please try after some time...');
				if(type=='secure') {
					 $("#securefloatresult").html('');		
				}	else {					
					 $("#carefloatresult").html('');	
				}
			}	else {	
				if(type=='secure') {
					 $("#securefloatresult").html(': Rs '+msg2);		
				}	else {					
					 $("#carefloatresult").html(': Rs '+msg2);	
					}
				}
			}
                        */                                   
		});
}
function getagentfloatfooter(type){
	var policynum 	= $("#pnm").val();
	if(type=='secure') {
		$("#securefloatfooterresult").html('<img src="images/loading.gif" />');	
		//var policynum 	= '20008802';//$("#policynum").val();
    	var subsnum		= '303';//$("#subsnum").val();
	}	else {
		$("#carefloatfooterresult").html('<img src="images/loading.gif" />');
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
				alert('Please try after some time...');
				/*if(type=='secure') {
					 $("#securefloatresult").html('Group Secure Balance');		
				}	else {					
					 $("#carefloatresult").html('Group Care Balance');	
				}*/
			}	else {	
				if(type=='secure') {
					 $("#securefloatfooterresult").html(': Rs '+msg2);		
				}	else {					
					 $("#carefloatfooterresult").html(': Rs '+msg2);	
					}
				}
			}
		});
}
</script>
<?php if(@$_SESSION['username'])
  {
      $url = 'signout.php'; 
      $loginMsg = 'Log Out';
  }
  ?>
<header> <a href="index.php"><img src="images/religare_logo.jpg" alt="Religare" class="logo"></a>
  <!--<div class="congratulation">Congratulations! Welcome to the Religare family.</div>-->
  
  <div class="welcomeBox"> <span class="welcomeagent"><span>Welcome, <strong><?php echo @$_SESSION['username'] ? $_SESSION['username'] : 'Guest';//base64_decode(@$_SESSION['name']);?></strong></span> <!--<a href="profile.php" class="profile">Profile</a>-->  
  <a href="<?php echo $url;?>" class="logout"><?php echo $loginMsg; ?></a><br />
  </span>
  <?php        
  if($pagetype!='changepassword') { 
      $getAgentFloat = @$_SESSION['loginstatus'] ? "getagentfloat('care');" : "#";
      ?>
    <span class="lastlogin">Current Balance&nbsp;&nbsp;
<!--        <span class="agentbalance">-->
            <span id="carefloatresult" style="width:50px; padding-right:5px;">
                <?php echo @$_SESSION["agentbalance"] ? ' Rs : '. $_SESSION["agentbalance"] .' ': '';?>
            </span>
        <a id="carefloat" href="#" onclick="<?php echo $getAgentFloat;?>">
<!--        </span>-->
        <img src="images/referesh.png" /></a>
    </span>
     <?php }	?>  
<!--<span class="lastlogin">Partner Since: May/2014<br />
    Last Login: <?php //echo date('d-M-Y h:i:s',@$_SESSION['lastLogin']);?></span>--> </div>
  <div class="cl"></div>
</header>