function getAge(dateString) {
  var now = new Date();
  var today = new Date(now.getYear(),now.getMonth(),now.getDate());
  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();
  var dob = new Date(dateString.substring(6,10),
                     dateString.substring(0,2)-1,                    
                     dateString.substring(3,5)                   
  );
  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";
  yearAge = yearNow - yearDob;
  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow -monthDob;
  }
  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }
  age = {
      years: yearAge,
      months: monthAge,
      days: dateAge
	};
  if ( age.years > 1 ) yearString = " years";
  else yearString = " year";
  if ( age.months> 1 ) monthString = " months";
  else monthString = " month";
  if ( age.days > 1 ) dayString = " days";
  else dayString = " day";

 /* if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.years + yearString + ", " + age.months + monthString + ", and " + age.days + dayString + " old.";
   else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
    ageString = "Only " + age.days + dayString + " old!";
 else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
    ageString = age.years + yearString + " old. Happy Birthday!!";
  else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.years + yearString + " and " + age.months + monthString + " old.";
  else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
    ageString = age.months + monthString + " and " + age.days + dayString + " old.";
  else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
    ageString = age.years + yearString + " and " + age.days + dayString + " old.";
  else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
    ageString = age.months + monthString + " old.";
  else ageString = "Oops! Could not calculate age!";*/

  return age.years;
}
function assuresearch() {
    var tenure	= $('input[name=tenure]:radio:checked').val();
    var qdob 	= $("#qdob").val();
	//alert(qdob);
	var dobarr	=	qdob.split("/");
	var quotdob	=	dobarr[1]+'/'+dobarr[0]+'/'+dobarr[2];
	//alert(qdob);
	var ageyear	=	getAge(quotdob);	
	var ageGroupOfEldestMember	=	'';
	if(ageyear>=18 && ageyear<=25) {
   		ageGroupOfEldestMember	=	'18 - 25';
	}
	if(ageyear>=26 && ageyear<=30) {
   		ageGroupOfEldestMember	=	'26 - 30';
	}
	if(ageyear>=31 && ageyear<=35) {
   		ageGroupOfEldestMember	=	'31 - 35';
	}
	if(ageyear>=36 && ageyear<=40) {
   		ageGroupOfEldestMember	=	'36 - 40';
	}
	if(ageyear>=41 && ageyear<=45) {
   		ageGroupOfEldestMember	=	'41 - 45';
	}
	if(ageyear>=46 && ageyear<=50) {
   		ageGroupOfEldestMember	=	'46 - 50';
	}
	if(ageyear>=51 && ageyear<=55) {
   		ageGroupOfEldestMember	=	'51 - 55';
	}
	if(ageyear>=56 && ageyear<=60) {
   		ageGroupOfEldestMember	=	'56 - 60';
	}
	if(ageyear>=61 && ageyear<=65) {
   		ageGroupOfEldestMember	=	'61 - 65';
	}
	if(ageGroupOfEldestMember=='') {
		alert("Please select date of birth between 18 & 65 Years.");
		return false;
	}
	$("#ageGroupOfEldestMember").val(ageGroupOfEldestMember);
    if ((ageGroupOfEldestMember == '51 - 55') || (ageGroupOfEldestMember == '56 - 60') || (ageGroupOfEldestMember == '61 - 65')) {
        var sumInsured = $("#sumInsured2").val();
        $(".slider_price3").hide();
        $(".slider_price4").show();
    } else {
        var sumInsured = $("#sumInsured1").val();
        $(".slider_price3").show();
        $(".slider_price4").hide();
    }
    $("#assurecare").html('<img src="images/logo_loader.gif" />');
    $("#assurencb").html('<img src="images/logo_loader.gif" />');
    var dataSting = "ageGroupOfEldestMember=" + ageGroupOfEldestMember + "&sumInsured=" + sumInsured + "&tenure=" + tenure;
   if(tenure != ''){
        $("#proposalTenourCode").val(tenure);
    $.ajax({
        type: "POST",
        url: "getAssurePremium.php",
        async: true,
        data: dataSting,
        success: function(assuremsg) {			
				var assuremsg1 = assuremsg.split(":");
				var careval = assuremsg1[0];
				var ncbval = assuremsg1[1];
				$("#permiumamountValid").val(careval);
				$("#proposalDummySi").val(ncbval);
				$("#QuotationDOB").val(qdob);
				$("#proposalageGroupOfEldestMember").val(assuremsg1[3]);
				$("#assurecare").html(careval);
				$("#assurecaresi").html(ncbval);
				$("#proposalSumInsured").val(assuremsg1[2]);           
		}
    });
   }
}

function copyProposarVal() {
    if ($('#ValidTitle').val() != $('#ValidTitle').attr('placeholder')) {
        $("#CValidTitle").val($("#ValidTitle").val());
    }
    if ($('#ValidFName').val() != $('#ValidFName').attr('placeholder')) {
        $("#CValidFName").val($("#ValidFName").val());
    }
    if ($('#ValidLName').val() != $('#ValidLName').attr('placeholder')) {
        $("#CValidLName").val($("#ValidLName").val());
    }
    if ($('#datepicker').val() != $('#datepicker').attr('placeholder')) {
         $("#Cdatepicker").val($("#datepicker").val());
    }
    if ($('#ValidMobileNumber').val() != $('#ValidMobileNumber').attr('placeholder')) {
        $("#CValidMobileNumber").val($("#ValidMobileNumber").val());
    }
    if ($('#ValidAddressOne').val() != $('#ValidAddressOne').attr('placeholder')) {
        $("#CValidAddressOne").val($("#ValidAddressOne").val());
    }
    if ($('#ValidAddressTwo').val() != $('#ValidAddressTwo').attr('placeholder')) {
        $("#CValidAddressTwo").val($("#ValidAddressTwo").val());
    }
    if ($('#ValidEmail').val() != $('#ValidEmail').attr('placeholder')) {
        $("#CValidEmail").val($("#ValidEmail").val());
    }
    if ($('#ValidAddressOne').val() != $('#ValidAddressOne').attr('placeholder')) {
         $("#CValidCityName").val($("#ValidCityName").val());
    }
    if ($('#ValidCityName').val() != $('#ValidCityName').attr('placeholder')) {
        $("#CValidPinCode").val($("#ValidPinCode").val());
    }
    if ($('#ValidStateName').val() != $('#ValidStateName').attr('placeholder')) {
        $("#CValidStateName").val($("#ValidStateName").val());
    }
    
     if ($('#nomineeRelation').val() != $('#nomineeRelation').attr('placeholder')) {
        $("#CNomineeRelation").val($("#nomineeRelation").val());
    }
    
     if ($('#NomineeName').val() != $('#CNomineeName').attr('placeholder')) {
        $("#CNomineeName").val($("#NomineeName").val());
    }
    
    var permiumamountValid = $("#permiumamountValid").val();
    if(permiumamountValid > 50000){
      
         if ($('#ValidPanCard').val() != $('#CValidPanCard').attr('placeholder')) {
        $("#CValidPanCard").val($("#ValidPanCard").val());
    }
    }
    
    assuresearch();
}
