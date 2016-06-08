function secureResult(){
    securePlan();
    var sumInsuredSecure = $("#sumInsuredSecure").val();
    var tenure = $('input:radio[name=tenure]:checked').val();
    $.ajax({ 
			type: "POST", 
			url: "getSecure5Premium.php",
			async:true,
			data: "sumInsuredSecure="+sumInsuredSecure+"&tenure="+tenure, 
			success: function(msg){				
				$("#proposalTenourCode").val(tenure);
				$("#proposalDummySi").val(sumInsuredSecure);
				$("#proposalSumInsured").val(sumInsuredSecure);				
				var msg1=msg.split('|');				
				$("#secureprimiumone").html(msg1[0]);
				$("#secureprimiumtwo").html(msg1[1]); 
				$("#premium1").val(msg1[0]);
				$("#premium2").val(msg1[1]);
				var t = $('input:radio[name=premiumradio]:checked').val();
				if(t=='ncb') {
					var t	=	'2';
				}	else {	
					var t	=	'1';
				}
				secure5PremiumUpdated(t);
			}
		});
}
function secure5PremiumUpdated(t){
   //var t = $("input[name='premiumradio']:checked").val();
   if(t==2){
   var premium	=	$("#premium2").val();	
   } else {
   var premium	=	$("#premium1").val();	
   }
   $("#permiumamountValid").val(premium);
}
function securePlan(){
    var sumInsuredSecure = $("#sumInsuredSecure").val();
    $(".securebenifit").hide();
    switch(sumInsuredSecure){
        case '1000000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,").show();
                break;
        }
        case '1500000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-7,#secure-8,#secure-11,#secure-12,").show();
                break;
        }
        case '2000000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-7,#secure-8,#secure-11,#secure-12,").show();
                break;
        }
        case '2500000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-7,#secure-8,#secure-11,#secure-12,").show();
                break;
        }
        case '3000000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-7,#secure-8,#secure-11,#secure-12,").show();
                break;
        }
        case '5000000':{
                 $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-6,#secure-7,#secure-8,#secure-9,#secure-10,#secure-11,#secure-12,#secure-13").show();
                break;
        }
        case '10000000':{
                $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-6,#secure-7,#secure-8,#secure-9,#secure-10,#secure-11,#secure-12,#secure-13").show();
                break;
        }
        case '20000000':{
                 $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-6,#secure-7,#secure-8,#secure-9,#secure-10,#secure-11,#secure-12,#secure-13").show();
                break;
        }
        case '30000000':{
               $("#secure-1,#secure-2,#secure-3,#secure-4,#secure-5,#secure-6,#secure-7,#secure-8,#secure-9,#secure-10,#secure-11,#secure-12,#secure-13").show();
                break;
        }
       
    }
}
function securePremiumBenifit(){
   var t = $("input[name='premiumsecure']:checked").val();
   if(t==2){
    $("#secureaccidentalhopitalization").show();
   } else {
    $("#secureaccidentalhopitalization").hide();
   }
}