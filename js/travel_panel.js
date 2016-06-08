$(document).ready(function() {
   /*
    $("#noOfTravellers").change(function() { 
     var travelno = $(this).val();
     //document.getElementById("TravellersUser").value = travelno;
    //$("#totalAdultMember").val(travelno);
     $.ajax({
        type: "POST",
       // url: "nooftravel.php",
        async: true,
        data: "nooftravel=" + travelno,
        success: function(data) {
          $("#nooftravel").html(data);
           
        }
    });
});
 
 */
 
 
 
 
 
 
    $("#noOfTravellers,#maximumtripduration").livequery('change', displayTravelSilider);
    $("#travellingTo").livequery('change', displayTripType);
    $("#travellingTo").livequery('change', chnageContent);
    $("#tripType").livequery('change', displayTravelCoverType);
    $("#coverType").livequery('change', displayTravelSumInsured);
    $("#sumInsured").livequery('change', searchResult);
    $(".age").livequery('change', displayTravelSilider);
    displayTripType();
});
function isInArray(obj, a) {
    var i = a.length;

    while (i--) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}
function displayTripType() {
    var travellingTo = $("#travellingTo").val();
    $.ajax({
        type: "POST",
        url: "ajaxGetTravelTripType.php",
        async: true,
        data: "travellingTo=" + travellingTo,
        success: function(msg) {
            var msg1 = msg.split('|');
            $('#tripType').children().remove();
            for (i = 0; i < msg1.length; i++) {
                $('#tripType').append('<option id="' + msg1[i] + '">' + msg1[i] + '</option>');
            }
            $("#c_tripType").html(msg1[0]);
            displayTravelCoverType();
        }
    });
}

function displayTravelSilider() {
    var tripType = $("#tripType").val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    
    var pedQuestion = $("[name=pedQuestion]:checked").val();
    $(".memberlist").hide();
   
    var ageBand1 = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        $("#aged_" + i).show();
        ageBand1[i] = $("#age" + i).val();
    }
    
    var checkSingle = isInArray('81-99', ageBand1);
    var checkSingleMulti = isInArray('71-80', ageBand1);
    var checkSingleMultiTwo = isInArray('61-70', ageBand1);
    switch (travellingTo) {
        case '1':
            {
                $("#triptypepr,#pletinumplan").hide();
                $("#asiatriptypepr,#glodplan").show();
                $("#maximumtrip").hide();
                $("#changesymbole").text("$");
                if (checkSingle == true) {
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_asia_seventy").show();
                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_aisa").show();
                }
                break;
            }
        case '2':
            {
                $("#triptypepr,#pletinumplan").hide();
                $("#asiatriptypepr,#glodplan").show();
                $("#maximumtrip").hide();
                $("#changesymbole").text("$");
                if (checkSingle == true) {
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_asia_seventy").show();
                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".slider_price_europe").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").show();
                }
                break;
            }
        case '3':
            {
                $("#triptypepr,#pletinumplan").hide();
                $("#asiatriptypepr,#glodplan").show();
                $("#maximumtrip").hide();
                $("#changesymbole").text("â‚¬");
                if (checkSingle == true) {
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".slider_price_asia_seventy").hide();
                    $(".single_price_all").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".singh_price_europe").show();
                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_europe").show();

                }
                break;
            }
        case '4':
            {

                $("#triptypepr,#pletinumplan").hide();
                $("#asiatriptypepr,#glodplan").show();
                $("#maximumtrip").hide();
                $("#changesymbole").text("$");
                if (checkSingle == true) {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_europe").hide();
                    $(".singh_price_europe").hide();
                    $(".single_price_all").show();


                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_canada").show();
                }
                break;
            }
        case '5':
            {
                $("#asiatriptypepr,#glodplan").hide();
                $("#triptypepr,#pletinumplan").show();
                if (tripType == 'Multi' || tripType == 'multi') {
                    $("#maximumtrip").show();
                } else {
                    $("#maximumtrip").hide();
                }
                $("#changesymbole").text("$");
                if (checkSingle == true) {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_europe").hide();
                    $(".singh_price_europe").hide();
                    $(".single_price_all").show();

                } else if (checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                    $(".slider_price_asia_seventy").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_canada").show();
                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_all").show();
                }
                break;
            }
        case '6':
            {

                $("#asiatriptypepr,#glodplan").hide();
                $("#triptypepr,#pletinumplan").show();
                if (tripType == 'Multi' || tripType == 'multi') {
                    $("#maximumtrip").show();
                } else {
                    $("#maximumtrip").hide();
                }
                $("#changesymbole").text("$");
                if (checkSingle == true) {
                    $(".slider_price_asia_seventy").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_all").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_europe").hide();
                    $(".singh_price_europe").hide();
                    $(".single_price_all").show();


                } else if (checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                    $(".slider_price_asia_seventy").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".slider_price_all").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_canada").show();
                } else {
                    $(".slider_price_asia_seventy").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_aisa").hide();
                    $(".single_price_all").hide();
                    $(".singh_price_europe").hide();
                    $(".slider_price_canada").hide();
                    $(".slider_price_europe").hide();
                    $(".slider_price_all").show();

                }

                break;
            }
    }

    var quoteMobile = $("#mobilenotr").val();
    var checkmobile = $("#checkmobile").val();
    if ((quoteMobile == "") || (quoteMobile.length < 10)) {
        if (checkmobile == 1) {
            alert("Kindly fill in your mobile number to see your premium options");
            $("#checkmobile").val('2');
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            return false;
        }
    } else {
        searchResult();
    }


}

function displayAgentContantTravelLeft() {
                        
                        var travellingToText = $("#travellingToAgent option:selected").text();
                        var travellingID = $("#travellingToAgent").val();
                       
                        if(travellingID == 3 || travellingID == 5){
                           $("#rightsideShowMassageValid,#homepageShowMassageValid").show();
                           
                        } else {
                           $("#rightsideShowMassageValid,#homepageShowMassageValid").hide();   
                        }
                        
                        
                        travellingID=travellingID-1;
                        $("#agentplannameval").html(travellingToText);
                        document.getElementById('travellingTo').getElementsByTagName('option')[travellingID].selected = 'selected';
                        $("#c_travellingTo").html(travellingToText);
                      
    $( "#agentasiapanel" ).slideUp();
    $( "#agentasiapanel" ).slideDown();

                       
                       
                    }


function chnageContent() {

    var travellingToText = $("#travellingTo option:selected").text();
    var travellingID = $("#travellingTo").val();
    travellingID = travellingID - 1;
    document.getElementById('travellingToAgent').getElementsByTagName('option')[travellingID].selected = 'selected';
    $("#c_travellingToAgent").html(travellingToText);
    displayAgentContantTravelLeft();
}


function removeAgeBandWithPost(agedata) {
    var tripType = $("#tripType").val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    alert(agedata);
    var arr;
    if (agedata)
    {
        arr = $.makeArray(agedata);
    }
    
    if (((travellingTo == '5') || (travellingTo == '6')) && (tripType == 'Multi' || tripType == 'multi')) {
        for (var b = 1; b <= noOfTravellers; b++) {            
            $("#age" + b + " option[value='0-40']").remove();
            $("#age" + b + " option[value='41-60']").remove();
            $("#age" + b + " option[value='61-70']").remove();
            $("#age" + b + " option[value='71-80']").remove();
            $("#age" + b + " option[value='81-99']").remove();
            if(arr)
            {
                if(arr[b-1] == "41-60")
                {              
                    $("#age" + b).append($("<option/>").attr("value", '41-60').attr('selected', 'selected').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));

                }
                if(arr[b-1] == "61-70")
                {
                    $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').attr('selected', 'selected').text('61 - 70'));
                }
            }
//            $("#age" + b).append($("<option/>").attr("value", '0-40').text('upto 40'));
//            $("#age" + b).append($("<option/>").attr("value", '41-60').attr(s4160,'').text('41 - 60'));
//            $("#age" + b).append($("<option/>").attr("value", '61-70').attr(s6170,'').text('61 - 70'));
            $("#c_age" + b).html('upto 40');
        }
    } else {
        for (var b = 1; b <= noOfTravellers; b++) {
            $("#age" + b + " option[value='0-40']").remove();
            $("#age" + b + " option[value='41-60']").remove();
            $("#age" + b + " option[value='61-70']").remove();
            $("#age" + b + " option[value='71-80']").remove();
            $("#age" + b + " option[value='81-99']").remove();
            $("#age" + b).append($("<option/>").attr("value", '0-40').text('upto 40'));
            if(arr)
            {
                if(arr[b-1] == "41-60")
                {              
                    $("#age" + b).append($("<option/>").attr("value", '41-60').attr('selected', 'selected').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));
                    $("#age" + b).append($("<option/>").attr("value", '71-80').text('71 - 80'));
                    $("#age" + b).append($("<option/>").attr("value", '81-99').text('80 +'));

                }
                if(arr[b-1] == "61-70")
                {
                    $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').attr('selected', 'selected').text('61 - 70'));
                    $("#age" + b).append($("<option/>").attr("value", '71-80').text('71 - 80'));
                    $("#age" + b).append($("<option/>").attr("value", '81-99').text('80 +'));
                }
                if(arr[b-1] == "71-80")
                {
                    $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));
                    $("#age" + b).append($("<option/>").attr("value", '71-80').attr('selected', 'selected').text('71 - 80'));
                    $("#age" + b).append($("<option/>").attr("value", '81-99').text('80 +'));
                }
                if(arr[b-1] == "81-99")
                {
                    $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
                    $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));
                    $("#age" + b).append($("<option/>").attr("value", '71-80').text('71 - 80'));
                    $("#age" + b).append($("<option/>").attr("value", '81-99').attr('selected', 'selected').text('80 +'));
                }
            }
            //alert('1:'+ s4160 + '-2:' +s6170 + '-3:'+s7180 + '-4:'+s8199);
//            $("#age" + b + " option[value='0-40']").remove();
//            $("#age" + b + " option[value='41-60']").remove();
//            $("#age" + b + " option[value='61-70']").remove();
//            $("#age" + b + " option[value='71-80']").remove();
//            $("#age" + b + " option[value='81-99']").remove();
//            $("#age" + b).append($("<option/>").attr("value", '0-40').text('upto 40'));
//            $("#age" + b).append($("<option/>").attr("value", '41-60').attr('a', s4160).text('41 - 60'));
//            $("#age" + b).append($("<option/>").attr("value", '61-70').attr('a', s6170).text('61 - 70'));
//            $("#age" + b).append($("<option/>").attr("value", '71-80').attr('a', s7180).text('71 - 80'));
//            $("#age" + b).append($("<option/>").attr("value", '81-99').attr('a', s8199).text('80 +'));
            $("#c_age" + b).html('upto 40');
        }
    }
}

function removeAgeBand() {
    var tripType = $("#tripType").val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    
    if (((travellingTo == '5') || (travellingTo == '6')) && (tripType == 'Multi' || tripType == 'multi')) {
        for (var b = 1; b <= noOfTravellers; b++) {
            $("#age" + b + " option[value='0-40']").remove();
            $("#age" + b + " option[value='41-60']").remove();
            $("#age" + b + " option[value='61-70']").remove();
            $("#age" + b + " option[value='71-80']").remove();
            $("#age" + b + " option[value='81-99']").remove();
            $("#age" + b).append($("<option/>").attr("value", '0-40').attr('abc', 'abc').text('upto 40'));
            $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
            $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));
            $("#c_age" + b).html('upto 40');
        }
    } else {
        for (var b = 1; b <= noOfTravellers; b++) {
            $("#age" + b + " option[value='0-40']").remove();
            $("#age" + b + " option[value='41-60']").remove();
            $("#age" + b + " option[value='61-70']").remove();
            $("#age" + b + " option[value='71-80']").remove();
            $("#age" + b + " option[value='81-99']").remove();
            $("#age" + b).append($("<option/>").attr("value", '0-40').text('upto 40'));
            $("#age" + b).append($("<option/>").attr("value", '41-60').text('41 - 60'));
            $("#age" + b).append($("<option/>").attr("value", '61-70').text('61 - 70'));
            $("#age" + b).append($("<option/>").attr("value", '71-80').text('71 - 80'));
            $("#age" + b).append($("<option/>").attr("value", '81-99').text('80 +'));
            $("#c_age" + b).html('upto 40');
        }
    }
    
   var agevalue=$("#selectedtravellers").val();
   var arr = agevalue.split(',');
//   if(arr[0] == travellingTo)
//   {
//    $("#age1 option[value="+arr[1]+"]").attr("selected","selected");
//    $("#age2 option[value="+arr[2]+"]").attr("selected","selected");
//    $("#age3 option[value="+arr[3]+"]").attr("selected","selected");
//    $("#age4 option[value="+arr[4]+"]").attr("selected","selected");
//    $("#age5 option[value="+arr[5]+"]").attr("selected","selected");
//    $("#age6 option[value="+arr[6]+"]").attr("selected","selected");
//   }

        $("#age1 option[value="+arr[0]+"]").attr("selected","selected");
        $("#age2 option[value="+arr[1]+"]").attr("selected","selected");
        $("#age3 option[value="+arr[2]+"]").attr("selected","selected");
        $("#age4 option[value="+arr[3]+"]").attr("selected","selected");
        $("#age5 option[value="+arr[4]+"]").attr("selected","selected");
        $("#age6 option[value="+arr[5]+"]").attr("selected","selected");
    
}

function displayTravelCoverType() {
   
    removeAgeBand();
    var tripType = $("#tripType").val();
    var travellingTo = $("#travellingTo").val();
    if (tripType == 'Multi' || tripType == 'multi') {
        $("#maximumtrip").show();
        $(".hidedaysfield").hide();
        $('#noday,#to').attr('disabled', true);
    } else {
        $("#maximumtrip").hide();
        $(".hidedaysfield").show();
        $('#noday,#to').attr('disabled', false);
        $("#to").addClass("hasDatepicker");
    }
//    if(travellingTo == '5' || travellingTo == '6'){            
//            $('#goldplan-3').removeAttr('checked');
//            $('#goldplan-1').attr('checked', 'checked');
//        }
    checkNodayTravel();
}

function checkNodayTravel() {
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
     
    $.ajax({
        type: "POST",
        url: "dateCheck.php",
        async: true,
        data: "fromvalue=" + fromvalue + "&noday=" + noday + "&tripType=" + tripType + "&tovalue=" + toValue,
        success: function(msg) {
            var t = msg.split(":");
            $("#noday").val(t[0]);
            $("#to").val(t[1]);
            
        }
    });
    }
    displayTravelSilider();
}
function displayTravelSumInsured() {
    var travellingTo = $("#travellingTo").val();
    var tripType = $("#tripType").val();
    var coverType = $("#coverType").val();
    $.ajax({
        type: "POST",
        url: "ajaxGetTravelSumInsured.php",
        async: true,
        data: "tripType=" + tripType + "&travellingTo=" + travellingTo + "&coverType=" + coverType,
        success: function(msg) {
            var msg1 = msg.split('|');
            $('#sumInsured').children().remove();
            for (i = 0; i < msg1.length; i++) {
                $('#sumInsured').append('<option id="' + msg1[i] + '">' + msg1[i] + '</option>');
            }
            $("#c_sumInsured").html(msg1[0]);
            searchResult();
        }
    });
}
function isCharsInBag(s, bag)
{
    var i;
    for (i = 0; i < s.length; i++)
    {
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1)
            return false;
    }
    return true;
}
function noOfTravellerPrashant() {
    var noOfTravellers = $("#noOfTravellers").val();
    $(".memberlist").hide();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        $("#aged_" + i).show();
    }
}
function noOfTravellerDisplay() {

    var noOfTravellers = $("#noOfTravellers").val();
    $(".memberlist").hide();

    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        $("#aged_" + i).show();
    }
    searchResult();
}
function searchResult() {
    var pedQuestion = $("[name=pedQuestion]:checked").val();
    var checkLeadCreation = $("#checkLeadCreation").val();
    var quoteMobile = $("#mobilenotr").val();
    var checkmobile = $("#checkmobile").val();
    if ((quoteMobile == "") || (quoteMobile.length < 10)) {
        if (checkmobile == 0) {
            alert("Kindly fill in your mobile number to see your premium options");
            $("#checkmobile").val('2');
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        } else {
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        }

    }
    var travellingTo = $("#travellingTo").val();
    if ((travellingTo == '5') || (travellingTo == '6')) {
        var tripType = $("#tripType").val();
    } else {
        var tripType = $("#tripTypeSigle").val();
    }

    var coverType = $("#coverType").val();
    //var sumInsured =$("#sumInsured").val();	
    var noOfTravellers = $("#noOfTravellers").val();
    var startDate = $("#from").val();
    var endDate = $("#to").val();
    var ageBand1 = '';
    var maximumtripduration = $("#maximumtripduration").val();


    var ageBand2 = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        $("#aged_" + i).show();
        ageBand2[i] = $("#age" + i).val();
    }
    var checkSeventy = isInArray('81-99', ageBand2);
    var checkSingleMulti = isInArray('71-80', ageBand2);
    var checkSingleMultiTwo = isInArray('61-70', ageBand2);

    switch (travellingTo) {
        case '1' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel70").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel1").val();
                }
                break;
            }
        case '2' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel70").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel1").val();
                }
                break;
            }
        case '3' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel3").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel3").val();

                }
                break;
            }
        case '4' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel").val();

                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel4").val();
                }
                break;
            }
        case '5' :
            {
                 if (checkSeventy == true) {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 } else if(checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                     var sumInsuredTravel = $("#sumInsuredTravel4").val();
                 } else {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 }
                break;
            }
        case '6':
            {
                if (checkSeventy == true) {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 } else if(checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                     var sumInsuredTravel = $("#sumInsuredTravel4").val();
                 } else {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 }
                break;
            }
    }
    for (i = 1; i <= noOfTravellers; i++) {
        var ageBand1 = ageBand1 + '' + $("#age" + i).val() + ',';
    }
if(endDate == '')
{
                        var tripType = $("#tripType").val();
                        var fromvalue = $("#from").val();
                        var tovalue = $("#to").val();
                         if (fromvalue != '' && (fromvalue != 'Start Date')) {
                            $.ajax({
                                type: "POST",
                                url: "dateCheck.php",
                                async: true,
                                data: "fromvalue=" + fromvalue + "&tripType=" + tripType + "&tovalue=" + tovalue,
                                success: function(msg) {
                                    var t = msg.split(":");
                                    $("#noday").val(t[0]);
                                    $("#to").val(t[1]);
                                    searchResultDate();
                                }
                            });
                        }
}
    if ((endDate != 'End Date') && (startDate != 'Start Date')) {
        if ((endDate != '') && (startDate != '')) {

            $.ajax({
                type: "POST",
                url: "getTravelPremium.php",
                async: true,
                data: "maximumtripduration=" + maximumtripduration + "&tripType=" + tripType + "&travellingTo=" + travellingTo + "&coverType=" + coverType + "&sumInsured=" + sumInsuredTravel + "&noOfTravellers=" + noOfTravellers + "&startDate=" + startDate + "&endDate=" + endDate + "&ageBand=" + ageBand1,
                success: function(msg) {
                    $("#carebuynowimage").attr("src", "images/buynow_new.gif");
                    if (checkLeadCreation == 1) {
                        createLeadTravel();
                    }
                    if ((travellingTo == '5') || (travellingTo == '6')) {
                        var msg1 = msg.split('|');
                         
                        $("#travelPremiumgold").html(msg1[0]);
                        $("#travelPremiumgolddata").val(msg1[0]);
                        $("#travelPremiumpletinum").html(msg1[1]);
                        $("#travelPremiumplatinumdata").val(msg1[1]);
                    } else {
                        $("#travelPremium").html(msg);
                        $("#travelPremiumdata").val(msg);
                    }
                }
            });
        } else {
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        }
    } else {
        $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
        return false;
    }

}
function searchResultDate() {
    var pedQuestion = $("[name=pedQuestion]:checked").val();
    var checkLeadCreation = $("#checkLeadCreation").val();
    var quoteMobile = $("#mobilenotr").val();
    var checkmobile = $("#checkmobile").val();
    if ((quoteMobile == "") || (quoteMobile.length < 10)) {
        if (checkmobile == 0) {
            //alert("Kindly fill in your mobile number to see your premium options");
            // $("#checkmobile").val('2');
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        } else {
            $("#travelPremium").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumpletinum").html('<span style="font-size:17px;">----</span>');
            $("#travelPremiumgold").html('<span style="font-size:17px;">----</span>');
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        }

    }
    var travellingTo = $("#travellingTo").val();
    if ((travellingTo == '5') || (travellingTo == '6')) {
        var tripType = $("#tripType").val();
    } else {
        var tripType = $("#tripTypeSigle").val();
    }

    var coverType = $("#coverType").val();
    //var sumInsured						=$("#sumInsured").val();	
    var noOfTravellers = $("#noOfTravellers").val();
    var startDate = $("#from").val();
    var endDate = $("#to").val();
    var ageBand1 = '';
    var maximumtripduration = $("#maximumtripduration").val();




    var ageBand2 = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        $("#aged_" + i).show();
        ageBand2[i] = $("#age" + i).val();
    }
    var checkSeventy = isInArray('81-99', ageBand2);
    var checkSingleMulti = isInArray('71-80', ageBand2);
    var checkSingleMultiTwo = isInArray('61-70', ageBand2);

    switch (travellingTo) {
        case '1' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel70").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel1").val();
                }
                break;
            }
        case '2' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel70").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel1").val();
                }
                break;
            }
        case '3' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel3").val();
                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel3").val();

                }
                break;
            }
        case '4' :
            {
                if (checkSeventy == true) {
                    var sumInsuredTravel = $("#sumInsuredTravel").val();

                } else {
                    var sumInsuredTravel = $("#sumInsuredTravel4").val();
                }
                break;
            }
        case '5' :
            {
                 if (checkSeventy == true) {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 } else if(checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                     var sumInsuredTravel = $("#sumInsuredTravel4").val();
                 } else {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 }
                break;
            }
        case '6':
            {
                if (checkSeventy == true) {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 } else if(checkSingleMulti == true || checkSingleMultiTwo == true || pedQuestion == 'YES') {
                     var sumInsuredTravel = $("#sumInsuredTravel4").val();
                 } else {
                     var sumInsuredTravel = $("#sumInsuredTravel").val();
                 }
                break;
            }
    }


    for (i = 1; i <= noOfTravellers; i++) {
        var ageBand1 = ageBand1 + '' + $("#age" + i).val() + ',';
    }
    if ((endDate != 'End Date') && (startDate != 'Start Date')) {
        if ((endDate != '') && (startDate != '')) {
            $.ajax({
                type: "POST",
                url: "getTravelPremium.php",
                async: true,
                data: "maximumtripduration=" + maximumtripduration + "&tripType=" + tripType + "&travellingTo=" + travellingTo + "&coverType=" + coverType + "&sumInsured=" + sumInsuredTravel + "&noOfTravellers=" + noOfTravellers + "&startDate=" + startDate + "&endDate=" + endDate + "&ageBand=" + ageBand1,
                success: function(msg) {
                    $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
                    if (checkLeadCreation == 1) {
                          createLeadTravel();
                    }
                    if ((travellingTo == '5') || (travellingTo == '6')) {
                        var msg1 = msg.split('|');
                        $("#travelPremiumgold").html(msg1[0]);
                        //$("#travelPremiumgolddata").val(msg1[0]);
                        $("#travelPremiumpletinum").html(msg1[1]);
                        //$("#travelPremiumplatinumdata").val(msg1[1]);
                    } else {
                        $("#travelPremium").html(msg);
                        //$("#travelPremiumdata").val(msg);
                    }
                }
                
                
            });
        } else {
            $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
            return false;
        }
    } else {
        $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
        return false;
    }

}
function checkMobileTravel() {
    var mobile = $("#mobilenotr").val();
    if (!isCharsInBag(mobile, "0123456789")) {
        alert("Mobile must only contain Numbers");
        $("#carebuynowimage").attr("src", "images/Proceed_Proposal.png");
        return false;
    }
    if (mobile.length == 10) {
        searchResult();
    }

}
function kp_numeric(e)
{
    if (window.event) {
        // for IE, e.keyCode or window.event.keyCode can be used
        keynum = e.keyCode;
    }
    else if (e.which) {
        // netscape
        keynum = e.which;
    }
    else {
        // no event, so pass through
        return true;
    }
    if ((keynum != 46) && (keynum != 8) && (keynum < 48 || keynum > 57))
        return false;

}
function createLeadTravel() {
    var travellingTo = $("#travellingTo").val();
    var quoteMobile = $("#mobilenotr").val();
    var coverType = $("#coverType").val();
    $.ajax({
        type: "POST",
        url: "lead_creation.php",
        async: true,
        data: "travellingTo=" + travellingTo + "&coverTypeCd=" + coverType + "&leadstage=Quotation&mobilephone=" + quoteMobile + "&type=Email",
        success: function(msg) {
            $("#checkLeadCreation").val(2);
        }
    });
}

/*

function isCharsInBag1(s, bag)
{
    var i;
    for (i = 0; i < s.length; i++)
    {
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1)
            return false;
    }
    return true;
}
*/
function buynow() {
    var goldPlan = $('input:radio[name=goldplan[]]:checked').val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    
    var ageBandCheckWW = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        ageBandCheckWW[i] = $("#age" + i).val();
    }

    var checkSinge60 = isInArray('61-70', ageBandCheckWW);
    var form = $("#from").val();
    var to = $("#to").val();
    var mobile = $("#mobilenotr").val();
    if (form == "" || form == "Start Date") {
        alert("Kindly fill start date");
        return false;
    }
    if (to == "" || form == "End Date") {
        alert("Kindly fill end date");
        return false;
    }
    else if (mobile == '') {
        alert("Kindly fill mobile number");
        return false;
    }
   
      $.colorbox({width: "auto", height: "auto", inline: true, href: "#inline_proceedpay"});   

}
var win = null;
function NewWindow(mypage, myname, w, h, scroll, pos) {
    if (pos == "random") {
        LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
        TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
    }
    if (pos == "center") {
        LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
        TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
    }
    else if ((pos != "center" && pos != "random") || pos == null) {
        LeftPosition = 0;
        TopPosition = 20
    }
    settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes';
    win = window.open(mypage, myname, settings);
}




function buynowafterlogin() {
    var goldPlan = $('input:radio[name=goldplan[]]:checked').val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    
    var ageBandCheckWW = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {
        ageBandCheckWW[i] = $("#age" + i).val();
    }

    var checkSinge60 = isInArray('61-70', ageBandCheckWW);
    var form = $("#from").val();
    var to = $("#to").val();
    var mobile = $("#mobilenotr").val();
    if (form == "" || form == "Start Date") {
        alert("Kindly fill start date");
        return false;
    }
    if (to == "" || form == "End Date") {
        alert("Kindly fill end date");
        return false;
    }
    else if (mobile == '') {
        alert("Kindly fill mobile number");
        return false;
    }
    
   // $("#getSearch").hide();
   //$("#proposal_form").show();
   // $("#datepicker").val(qdob);
    
    $("#select_skin_form_9").submit();
}	