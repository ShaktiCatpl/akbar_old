function secureResult(){
	var sumInsuredSecure 	= $("#sumInsuredSecure").val();
	var qdob 				= $("#qdob").val();
    var tenure 				= $('input:radio[name=tenure]:checked').val();	
	//alert(qdob);
	/*var dobarr	=	qdob.split("/");
	var quotdob	=	dobarr[1]+'/'+dobarr[0]+'/'+dobarr[2];
	//alert(quotdob);
	var ageyear	=	getAge(quotdob);*/
	//alert(ageyear);
	var dobarr	=	qdob.split("/");
	var quotdob	=	dobarr[1]+'/'+dobarr[0]+'/'+dobarr[2];
	//alert(quotdob);
	var ageyearres		=	getAge(quotdob);
	//alert(ageyearres);
	var ageyearresarr	=	ageyearres.split(":");
	var yearres		=	ageyearresarr[0];
	var monthres	=	ageyearresarr[1];
	var dayres		=	ageyearresarr[2];
	var ageyear	=	yearres;
	if(yearres==65) {
		if(monthres>0){
			alert("Please select age between 18 years & 65 years");
			$("#care").html('--');	
			$("#qdob").html('');
			$("#qdob").val('');
			return false;			
		}
		if(dayres>0){
			alert("Please select age between 18 years & 65 years");
			$("#care").html('--');	
			$("#qdob").html('');
			$("#qdob").val('');
			return false;			
		}
	}
	//alert(ageyear);
	if((ageyear<18)||(ageyear>65)) {
		alert("Please select age between 18 years & 65 years");
		$("#secureprimiumone").html('--');	
		$("#qdob").html('');
		$("#qdob").val('');
		return false;
	}
	/*alert(sumInsuredSecure);
	alert(tenure);//275, 349*/
	if(sumInsuredSecure=='2000000') {
		var premiumresult	=	'354';
	}	else {
		var premiumresult	=	'279';//with services tax
	}
	$("#proposalDummySi").val(sumInsuredSecure);
	$("#permiumamountValid").val(premiumresult);
	$("#secureprimiumone").html(premiumresult);		
    /*securePlan();
    var sumInsuredSecure = $("#sumInsuredSecure").val();
    var tenure = $('input:radio[name=tenure]:checked').val();
    $.ajax({ 
			type: "POST", 
			url: "getSecurePremium.php",
			async:true,
			data: "sumInsuredSecure="+sumInsuredSecure+"&tenure="+tenure, 
			success: function(msg){
                            var msg1=msg.split('|');
                                $("#secureprimiumone").html(msg1[0]);
				$("#secureprimiumtwo").html(msg1[1]);
				
                            
                            
			}
		});*/
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