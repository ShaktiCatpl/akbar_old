function changeChildrenEnhance() {
    var e = $("#numberOfAdult option:selected").val();

    var t = $("#numberOfChildren option:selected").val();

    switch (e) {
        case '1':
            {
                $("#enhanceonemember").show();
                $("#childrenEnhanceShow,#enhancetwomoremember").hide();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();
                $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                $("#c_numberOfChildren").html("0");
                break;
            }
        case '2':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();

                if (t == 1) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                    $("#c_numberOfChildren").html("01");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#c_numberOfChildren").html("0");
                }
                break;
            }
        case '3':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();


                if (t == 1) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#c_numberOfChildren").html("01");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));

                    $("#c_numberOfChildren").html("02");
                }

                break;
            }
        case '4':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();


                if (t == 3) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#c_numberOfChildren").html("03");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));


                    $("#c_numberOfChildren").html("02");
                }
                break;
            }
        case '5':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();

                if (t == 3) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                    $("#c_numberOfChildren").html("03");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));



                    $("#c_numberOfChildren").html("04");
                }
                break;
            }
        case '6':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();
                $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                $("#c_numberOfChildren").html("04");
                break;
            }
    }
    enhanceSelect();
}

function enhanceSelect() {
    var enhance = $('input:radio[name=productCode]:checked').val();
    switch (enhance) {
        case '11001001':
            {
                $("#selectAnyWhereEnhanceCal").hide();
                $("#selectEnhanceCal").show();
                break;
            }
        case '11001002':
            {
                $("#selectEnhanceCal").hide();
                $("#selectAnyWhereEnhanceCal").show();
                break;
            }
    }
    resultEnhane();
}
function changeChildrenEnhanceTest(n) {
    var e = $("#numberOfAdult option:selected").val();
    var t = $("#numberOfChildren option:selected").val();

    switch (e) {
        case '1':
            {
                $("#enhanceonemember").show();
                $("#childrenEnhanceShow,#enhancetwomoremember").hide();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();
                $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                $("#c_numberOfChildren").html("0");
                break;
            }
        case '2':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();

                if (t == 1) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                    $("#c_numberOfChildren").html("01");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#c_numberOfChildren").html("0");
                }
                break;
            }
        case '3':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();


                if (t == 1) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#c_numberOfChildren").html("01");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));

                    $("#c_numberOfChildren").html("02");
                }

                break;
            }
        case '4':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();


                if (t == 3) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#c_numberOfChildren").html("03");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));


                    $("#c_numberOfChildren").html("02");
                }
                break;
            }
        case '5':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();

                if (t == 3) {

                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                    $("#c_numberOfChildren").html("03");
                } else {
                    $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                    $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));



                    $("#c_numberOfChildren").html("04");
                }
                break;
            }
        case '6':
            {
                $("#enhanceonemember").hide();
                $("#childrenEnhanceShow,#enhancetwomoremember").show();
                $("#numberOfChildren option[value='4']").remove();
                $("#numberOfChildren option[value='3']").remove();
                $("#numberOfChildren option[value='2']").remove();
                $("#numberOfChildren option[value='1']").remove();
                $("#numberOfChildren option[value='0']").remove();
                $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
                $("#c_numberOfChildren").html("04");
                break;
            }
    }
    enhanceSelectTest(n);
}

function enhanceSelectTest(n) {

    var enhance = $('input:radio[name=productCode]:checked').val();
    switch (enhance) {
        case '11001001':
            {
                $("#selectAnyWhereEnhanceCal").hide();
                $("#selectEnhanceCal").show();
                break;
            }
        case '11001002':
            {
                $("#selectEnhanceCal").hide();
                $("#selectAnyWhereEnhanceCal").show();
                break;
            }
    }
 

}


function resultEnhane() {

    var tenure = $('input:radio[name=tenure]:checked').val();
    
    var totalmem = $("#numberOfAdult").val();
    var children = $("#numberOfChildren").val();
    var enhance = $("#sumInsured").val();
    
    var ageEnhane = '';
    var coverType = '';
    if (totalmem == 1) {
        ageEnhane = $("#select_skin_demo_enhance_8").val();
        coverType = "INDIVIDUAL";
    } else {
        ageEnhane = $("#select_skin_demo_enhance_9").val();
        coverType = "FAMILYFLOATER";
    }
    $.ajax({
        headers: {
            Accept: "text/plain; charset=utf-8",
            "Content-Type": "text/plain; charset=utf-8"
        },
        type: "POST",
        url: "api_premium.php",
        async: true,
        data: "tenure=" + tenure  + "&totalmem=" + totalmem + "&children=" + children + "&coverType=" + coverType + "&ageEnhane=" + ageEnhane  + "&enhance=" + enhance,
        beforeSend: function(req) {
            req.setRequestHeader("Accept", "text/xml");
            $("#enhancePremiumResultOne").html('<img src="img/logo_loader.gif" />');
            $("#enhancePremiumResultTwo").html('<img src="img/logo_loader.gif" />');
        },
        success: function(msg) {

            var msg1 = msg.split('|');
           
            $("#enhancePremiumResultOne").html(msg1[0]);
            $("#enhancePremiumResultTwo").html(msg1[1]);
            $("#sumInsuredData").val(msg1[2]);
            $("#coverTypeProposalPage").val(coverType);
            $("#proposalTenourCode").val(tenure);
            $("#changeageGroup").val(ageEnhane);



        }
    });
}
function getResultEnhane() {

    var tenure = $("#proposalTenourCode").val();
    var enhanceany = $("#proposalProductCode").val();
    var totalmem = $("#totalAdultMember").val();
    var children = $("#totalChildMember").val();
    var enhance = $("#proposalDummyDe").val();
    var enhanceSI = $("#proposalDummySi").val();
    var addOnsValid = $("#addOnsValid").val();
    var coverType = '';
    if (totalmem == 1) {
        coverType = "INDIVIDUAL";
    } else {
        coverType = "FAMILYFLOATER";
    }
    var ageEnhane = $("#proposalageGroupOfEldestMember").val();

    $.ajax({
        headers: {
            Accept: "text/plain; charset=utf-8",
            "Content-Type": "text/plain; charset=utf-8"
        },
        type: "POST",
        url: "api_premium.php",
        async: true,
        data: "tenure=" + tenure + "&enhanceany=" + enhanceany + "&totalmem=" + totalmem + "&children=" + children + "&coverType=" + coverType + "&ageEnhane=" + ageEnhane + "&enhanceSI=" + enhanceSI + "&enhance=" + enhance,
        beforeSend: function(req) {

            req.setRequestHeader("Accept", "text/xml");
        },
        success: function(msg) {

            var msg1 = msg.split('|');

            if (addOnsValid == 'YES') {
                var premiumValue = msg1[0].replace(',', '');
                premiumValue = parseInt(premiumValue);
                $("#pancarddetail").hide();
                if (premiumValue > 50000) {
                    $("#pancarddetail").show();
                }
                $("#enhancePremiumResultRroposalOne").html(msg1[1]);
                $("#permiumamountValid").val(premiumValue);
            } else {
                var premiumValue = msg1[0].replace(',', '');
                premiumValue = parseInt(premiumValue);
                $("#pancarddetail").hide();
                if (premiumValue > 50000) {
                    $("#pancarddetail").show();
                }
                $("#enhancePremiumResultRroposalOne").html(msg1[0]);
                $("#permiumamountValid").val(premiumValue);
            }

        }
    });
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
    changeChildrenEnhance();
}
function checkEditProposalCode(n) {
    changeChildrenEnhanceTest(n);

}