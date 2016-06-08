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

$(document).ready(function() {
    $(".assuresearch").livequery('change', assuresearch);
    $(".slider_price3").show();
    $(".slider_price4").show();
    $(".assurecl").hide();
    checkProduct('health');
    $(".carewithncb").hide();
    $(".slider_price1").hide();
    $(".slider_price6").show();
    $(".login").click(function() {
        $("#login_box1").hide();
        $("#login_box").fadeIn(10, function() {
            $("#login_box").show()
        });
        return false
    });
    $(".login_close").click(function() {
        $("#login_box").hide();
        return false
    });
    $("#cback").click(function() {
        $("#callbackBox").animate({right: "0px"});
        $("#feedbackBox").animate({right: "-250px"})
    });
    $(".login_close1, #cbackclose, #cbackclose1, #bodyclk").click(function() {
        $("#callbackBox").animate({right: "-250px"})
    });
    $(".forgot_password_link").colorbox({width: "450px", height: "300px", inline: true, href: "#inline_example_forgot"});
    $("#insureyourhealth").hide();
    $('input:radio[id=oneYear1]').prop('checked', true);
    searchResult1();
    changeMemberList('INDIVIDUAL');
});
function encrypt() {
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if ((document.login.username.value == "") || (document.login.username.value == "Username")) {
        alert("Please enter the Username");
        return false;
    }
    if (reg.test(document.login.username.value) == false) {
        alert('Please enter the correct Email Address');
        return false;
    }
    if ((document.login.password.value == "") || (document.login.password.value == "Password")) {
        alert("Please enter the Password");
        return false;
    }
    document.forms['login'].password.value = encryptValue(document.forms['login'].password);
    return true;
}


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
function trim(str) {
    return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function showPlan(e) {
    $(".technology").hide();
    $(".sum" + e).show();
    $(".thelanguage").hide();
}

function kp_char(e)
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

    if ((keynum > 64 && keynum < 91)) {
    } else if ((keynum > 96 && keynum < 123)) {
    } else if (keynum == 32) {
    } else if (keynum == 8) {
    } else if (keynum == 46) {
    } else {
        return false;
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
function norm(num) {
    //alert(num)
    return +num.replace(',', '');
}
function validateEmail(email) {
    emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}

function buynow() {
    var goldPlan = $('input:radio[name=goldplan]:checked').val();



    var health = $("#insuranceType").val();
    var travellingTo = $("#travellingTo").val();
    var noOfTravellers = $("#noOfTravellers").val();
    var ageBandCheckWW = new Array();
    for (i = 1; i <= parseInt(noOfTravellers); i++) {

        ageBandCheckWW[i] = $("#age" + i).val();
    }
    var checkSinge60 = isInArray('61-70', ageBandCheckWW);
    if (((health == 'travel') && (travellingTo == 6)) && ((checkSinge60 == true) && (goldPlan == 'gold'))) {
        var t = confirm("If travelling to Schengen Countries, our recommended plan is: Platinum (No sublimits). Would you like to choose this plan before buying");
        if (t) {
            jQuery("#goldplan-2").attr('checked', true);
            return false;
        }
        else {
            var form = $("#from").val();
            var name = $("#travelname").val();
            var email = $("#travelemail").val();
            var mobile = $("#mobilenotr").val();
            if (!isCharsInBag1(mobile, "0123456789")) {
                alert("Mobile must only contain Numbers");
                return false;
            }
            if (mobile.length == 10) {
                if (form == "") {
                    alert("Kindly fill start date");
                    return false;
                }
                if (name == "") {
                    alert("Kindly fill your name");
                    return false;
                }
                if (email == "") {
                    alert("Kindly fill your email");
                    return false;
                }
                if (!validateEmail(email)) {
                    alert("Please enter the valid email");
                    return false;
                }


                document.quote_box.submit();
                return true;
            }
        }
    } else if (health == 'travel') {
        var name = $("#travelname").val();
        var form = $("#from").val();
        var email = $("#travelemail").val();
        var mobile = $("#mobilenotr").val();
        if (!isCharsInBag1(mobile, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        }
        if (mobile.length == 10) {
            if (name == "") {
                alert("Kindly fill your name");
                return false;
            }
            if (form == "") {
                alert("Kindly fill start date");
                return false;
            }
            if (email == "") {
                alert("Kindly fill your email");
                return false;
            }
            if (!validateEmail(email)) {
                alert("Please enter the valid email");
                return false;
            }
            $('#noday,#to').attr('disabled', false);
            document.quote_box.submit();
            return true;
        }
    } else {




        var mobile = $("#mobile").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var agentSeoName = trim($("#agentSeoName").val());
        if (!isCharsInBag1(mobile, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        }
        if (mobile.length == 10) {
            if (name == "") {
                alert("Kindly fill your name");
                return false;
            }
            if (email == "") {
                alert("Kindly fill your email");
                return false;
            }
            if (!validateEmail(email)) {
                alert("Please enter the valid email");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "../agent_customer_request.php",
                async: true,
                data: "agentSeoName=" + agentSeoName,
                success: function(msg) {
                    document.quote_box.submit();
                }
            });
        } else {
            alert("Kindly fill in your mobile number to buy");
            return false;
        }
    }
}
function check_mobile() {
    var e = $("#mobile").val();
    var v = $("#productId").val();
    if (!isCharsInBag1(e, "0123456789")) {
        alert("Mobile must only contain Numbers");
        return false;
    }

    switch (v) {
        case '5':
            {
                resultEnhane();
                break;
            }
        default :
            {
                if (e.length == 10) {
                    searchResult1();
                }
                break;
            }
    }

}
function submitTalkToOurExpert1() {
    var e = trim($("#yourName1").val());
    var t = trim($("#yourMobile1").val());
    var n = trim($("#plannerName").val());
    var agentid = trim($("#agentId").val());
    if (e == "" || e == "Your Name") {
        alert("Please enter your name");
        return false
    }
    if (t == "" || t == "Mobile No.") {
        alert("Please enter your mobile no.");
        return false;
    } else {
        if (!isCharsInBag1(t, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        } else if (t.length < 10) {
            alert("Mobile must only contain 10 digits");
            return false;
        } else {
        }
    }
    $("#submitRequestACallback1").html('<img src="../images/loading.gif" />');
    $.ajax({
        type: "POST",
        url: "../lead_creation_agent.php",
        async: true,
        data: "coverTypeCd=&productId=&sumInsured=&tenure=&premium1=&premium2=&emailaddress1=&firstname=" + e + "&mobilephone=" + t + "&agentId=" + agentid + "&type=Mobile&leadstage=talk to expert&subject=Callback Request",
        success: function(r) {
            sentRequestACallBackMail(e, t);
            alert("Thank you for your interest in Religare Health Insurance. Our Health Planner, " + n + " will get in touch with you shortly.");
            $("#submitRequestACallback1").html('<img src="/religare/images/submit.jpg"  alt="Submit" border="0" style="cursor:pointer;" onClick="submitTalkToOurExpert1();" />');
            $("#yourName1").val("");
            $("#yourMobile1").val("");
            $(window).colorbox.close();
        }
    });
}

function submitTalkToOurExpert() {
    var e = trim($("#yourName").val());
    var t = trim($("#yourMobile").val());
    var n = trim($("#plannerName").val());
    var agentid = trim($("#agentId").val());
    if (e == "" || e == "Your Name") {
        alert("Please enter your name");
        return false
    }
    if (t == "" || t == "Mobile No.") {
        alert("Please enter your mobile no.");
        return false;
    } else {
        if (!isCharsInBag1(t, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        } else if (t.length < 10) {
            alert("Mobile must only contain 10 digits");
            return false;
        } else {
        }
    }
    $("#submitRequestACallback").html('<img src="../images/loading.gif" />');
    $.ajax({
        type: "POST",
        url: "../lead_creation_agent.php",
        async: true,
        data: "coverTypeCd=&productId=&sumInsured=&tenure=&premium1=&premium2=&emailaddress1=&firstname=" + e + "&mobilephone=" + t + "&agentId=" + agentid + "&type=Mobile&leadstage=talk to expert&subject=Callback Request",
        success: function(r) {
            sentRequestACallBackMail(e, t);
            alert("Thank you for your interest in Religare Health Insurance. Our Health Planner, " + n + " will get in touch with you shortly.");
            $("#submitRequestACallback").html('<img src="../images/submit.jpg"  alt="Submit" border="0" style="cursor:pointer;" onClick="submitTalkToOurExpert();" />');
            $("#yourName").val("");
            $("#yourMobile").val("");
            $(window).colorbox.close();
        }
    });
}
function changeChildren() {
    var e = $("#numberOfAdult").val();

    var t = $("#c_select_skin_demo_7").html();
    if (e == "1") {
        $("#numberOfChildren option[value='4']").remove();
        $("#numberOfChildren option[value='3']").remove();
        $("#numberOfChildren option[value='2']").remove();
        $("#numberOfChildren option[value='1']").remove();
        $("#numberOfChildren option[value='0']").remove();
        $("#plantypenew option[value='INDIVIDUAL']").remove();
        $("#plantypenew option[value='FAMILYFLOATER']").remove();
        $("#plantypenew").append($("<option/>").attr("value", "INDIVIDUAL").text("Individual"));
        $("#plantypenew").append($("<option/>").attr("value", "FAMILYFLOATER").text("Floater"));
        $("#c_plantypenew").html("INDIVIDUAL");
        $(".floater1Plan").hide();
    } else {
        $(".floater1Plan").show();
        if (e == 6) {
            $(".agemember1").show();
            $(".agemember2").show();
            $(".agemember3").show();
            $(".agemember4").show();
            $(".agemember5").show();
            $("#numberOfChildren option[value='4']").remove();
            $("#numberOfChildren option[value='3']").remove();
            $("#numberOfChildren option[value='2']").remove();
            $("#numberOfChildren option[value='1']").remove();
            $("#numberOfChildren option[value='0']").remove();
            $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
            $("#c_numberOfChildren").html("04");
        }
        if (e == 5) {
            $(".agemember1").show();
            $(".agemember2").show();
            $(".agemember3").show();
            $(".agemember4").show();
            $(".agemember5").hide();
            $("#numberOfChildren option[value='4']").remove();
            $("#numberOfChildren option[value='3']").remove();
            $("#numberOfChildren option[value='2']").remove();
            $("#numberOfChildren option[value='1']").remove();
            $("#numberOfChildren option[value='0']").remove();
            $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
            $("#numberOfChildren").append($("<option/>").attr("value", "4").text("04"));
            if (t == "03" || t == "04") {
            } else {
                $("#c_numberOfChildren").html("03");
            }
        }
        if (e == 4) {
            $(".agemember1").show();
            $(".agemember2").show();
            $(".agemember3").show();
            $(".agemember4").hide();
            $(".agemember5").hide();
            $("#numberOfChildren option[value='4']").remove();
            $("#numberOfChildren option[value='3']").remove();
            $("#numberOfChildren option[value='2']").remove();
            $("#numberOfChildren option[value='1']").remove();
            $("#numberOfChildren option[value='0']").remove();
            $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
            $("#numberOfChildren").append($("<option/>").attr("value", "3").text("03"));
            if (t == "02" || t == "03") {
            } else {
                $("#c_numberOfChildren").html("02");
            }
        }
        if (e == 3) {
            $(".agemember1").show();
            $(".agemember2").show();
            $(".agemember3").hide();
            $(".agemember4").hide();
            $(".agemember5").hide();
            $("#numberOfChildren option[value='4']").remove();
            $("#numberOfChildren option[value='3']").remove();
            $("#numberOfChildren option[value='2']").remove();
            $("#numberOfChildren option[value='1']").remove();
            $("#numberOfChildren option[value='0']").remove();
            $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
            $("#numberOfChildren").append($("<option/>").attr("value", "2").text("02"));
            if (t == "01" || t == "02") {
            } else {
                $("#c_numberOfChildren").html("01");
            }
        }
        if (e == 2) {
            $(".agemember1").show();
            $(".agemember2").hide();
            $(".agemember3").hide();
            $(".agemember4").hide();
            $(".agemember5").hide();
            $("#numberOfChildren option[value='4']").remove();
            $("#numberOfChildren option[value='3']").remove();
            $("#numberOfChildren option[value='2']").remove();
            $("#numberOfChildren option[value='1']").remove();
            $("#numberOfChildren option[value='0']").remove();
            $("#numberOfChildren").append($("<option/>").attr("value", "0").text("0"));
            $("#numberOfChildren").append($("<option/>").attr("value", "1").text("01"));
            if (t == "0" || t == "01") {
            } else {
                $("#c_numberOfChildren").html("0");
            }
        }
    }
    searchResult1();
}
function searchResult() {
    // var valueBeforeChange = $('select[name="ageGroupOfEldestMember1[]"]').val();
    //  alert(valueBeforeChange);
    var e = $("#productId").val();
    var t = $("#numberOfAdult").val();
    var n = $("#numberOfChildren").val();

    var i = $("#c_numberOfChildren").html();
    var s = $("#mobileSend").val();
    var o = $("#mobile").val();
    var plT = $("#plantypenew").val();
    var u = $("#mobileAlert").val();
    var tnr = $('input[name=tenure]:radio:checked').val();
    if (e == '1') {
        $(".assurecl").hide();
        $(".careclass").show();
        var r = $("#sumInsuredNew").val();
        $(".slider_price1").hide();
        $(".slider_price6").show();
    } else if (e == '2') {
        $(".assurecl").hide();
        $(".careclass").show();
        var r = $("#sumInsured").val();
        $(".slider_price6").hide();
        $(".slider_price1").show();
    } else {
        $(".careclass").hide();
        $(".assurecl").show();
    }

    if (t == "1") {
        var a = $("#ageGroupOfEldestMember1").val();
        $("#onePremium").html('<img src="../images/loading.gif" />');
        $("#oneSumInsured").html('<img src="../images/loading.gif" />');
        $("#twoPremium").html('<img src="../images/loading.gif" />');
        $("#twoSumInsured").html('<img src="../images/loading.gif" />');
        $("#extraPremium").html('<img src="../images/loading.gif" />');
        $(".child1").hide();

        $("#floatermemer").hide();
        $(".floater1").hide();

        $("#individualmember").show();
        $(".individual1").show();






        if (s == "0" && o.length < 10) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            if (u == 0) {
                $("#mobileAlert").val("1");
                alert("Kindly fill in your mobile number to see your premium options");
                return false;
            } else if (u == 1 && o.length < 10 && o.length > 8) {
                $("#mobileAlert").val("2");
                alert("Mobile should be 10 digits");
                return false;
            } else {
                return false;
            }
        } else if (!isCharsInBag1(o, "0123456789")) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            if (e == '1') {
                $(".carewithncb").hide();
                $(".carencb").show();
                $.ajax({
                    type: "POST",
                    url: "../api_premium_for_agent_care_ncb.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + t + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + a + "&sumInsured=" + r + "&productTerm=1&tnr=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        $("#onePremium").html(t[0]);
                        $("#oneSumInsured").html(r);
                        $("#premium1").val(t[0]);
                        $("#twoPremium").html(t[2]);
                        //$("#premium2").val(t[1]);
                        $("#twoSumInsured").html(t[1]);
                        $("#extraPremium").html(t[3]);


                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                            $("#premium2").val('2500000');
                        } else {
                            $("#insureyourhealth").show();
                            $("#premium2").val(t[1]);
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '2') {
                $(".carencb").hide();
                $(".carewithncb").show();
                $("#care").html('<img src="../images/loading.gif" />');
                $("#ncb").html('<img src="../images/loading.gif" />');
                $("#ncbextraPremium").html('<img src="../images/loading.gif" />');
                $.ajax({
                    type: "POST",
                    url: "../ncp_premium_agent.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + t + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + a + "&sumInsured=" + r + "&productTerm=1&tenure=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        var carepremium = t[0];
                        var ncbpremium = t[1];
                        if ((r == '5000000') || (r == '6000000')) {
                            $("#caresecondrow").hide();
                        } else {
                            $("#caresecondrow").show();
                        }
                        $("#care").html(carepremium);
                        $("#ncb").html(ncbpremium);
                        var extprm = parseInt(norm(ncbpremium)) - parseInt(norm(carepremium));
                        $("#ncbextraPremium").html(extprm);
                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                        } else {
                            $("#insureyourhealth").show();
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '3') {
                $(".assurecl").show();
                assuresearch();
            }
        }
    } else {

        if (plT == 'FAMILYFLOATER') {
            $(".child1").show();
            $(".individual1").hide();
            $("#individualmember").hide();
            $(".floater1").show();
            $("#floatermemer").show();


        } else if (plT == 'INDIVIDUAL') {
            $(".child1").hide();
            $(".floater1").hide();
            $("#floatermemer").hide();
            $(".individual1").show();
            $("#individualmember").show();
        } else {
            $(".floater1").hide();
            $("#floatermemer").hide();
            $(".individual1").show();
            $("#individualmember").show();
        }



        //  $(".individual1").hide();

        // $(".floater1").show();
        var a = $("#ageGroupOfEldestMember").val();
        var f = parseInt(t) - parseInt(n);
        if (s == "0" && o.length < 10) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            if (u == 0) {
                $("#mobileAlert").val("1");
                alert("Kindly fill in your mobile number to see your premium options");
                return false;
            } else if (u == 1 && o.length < 10 && o.length > 8) {
                $("#mobileAlert").val("2");
                alert("Mobile should be 10 digits");
                return false;
            } else {
                return false;
            }
        } else if (!isCharsInBag1(o, "0123456789")) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            $("#onePremium").html('<img src="../images/loading.gif" />');
            $("#oneSumInsured").html('<img src="../images/loading.gif" />');
            $("#twoPremium").html('<img src="../images/loading.gif" />');
            $("#twoSumInsured").html('<img src="../images/loading.gif" />');
            $("#extraPremium").html('<img src="../images/loading.gif" />');
            if (e == '1') {
                $(".carewithncb").hide();
                $(".carencb").show();
                $.ajax({
                    type: "POST",
                    url: "../api_premium_for_agent_care_ncb.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + f + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + a + "&sumInsured=" + r + "&productTerm=1&tnr=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        $("#onePremium").html(t[0]);
                        $("#oneSumInsured").html(r);
                        $("#premium1").val(t[0]);
                        $("#twoPremium").html(t[2]);
                        //$("#premium2").val(t[1]);
                        $("#twoSumInsured").html(t[1]);
                        $("#extraPremium").html(t[3]);


                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                            $("#premium2").val('2500000');
                        } else {
                            $("#insureyourhealth").show();
                            $("#premium2").val(t[1]);
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == 1) {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '2') {
                $(".carencb").hide();
                $(".carewithncb").show();
                $("#care").html('<img src="../images/loading.gif" />');
                $("#ncb").html('<img src="../images/loading.gif" />');
                $("#ncbextraPremium").html('<img src="../images/loading.gif" />');
                $.ajax({
                    type: "POST",
                    url: "../api_premium_for_agent_care_ncb.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + f + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + a + "&sumInsured=" + r + "&productTerm=1&tenure=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        var carepremium = t[0];
                        var ncbpremium = t[1];
                        if ((r == '5000000') || (r == '6000000')) {
                            $("#caresecondrow").hide();
                        } else {
                            $("#caresecondrow").show();
                        }
                        $("#care").html(carepremium);
                        $("#ncb").html(ncbpremium);
                        var extprm = parseInt(norm(ncbpremium)) - parseInt(norm(carepremium));
                        $("#ncbextraPremium").html(extprm);
                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                        } else {
                            $("#insureyourhealth").show();
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '3') {
                $(".assurecl").show();
                assuresearch();
            }
        }
    }
}

function searchResult1() {
    var e = $("#productId").val();
    var t = $("#numberOfAdult").val();
    var plT = $("#plantypenew").val();
    // alert(plT);
    var n = $("#numberOfChildren").val();

    var i = $("#c_numberOfChildren").html();
    var s = $("#mobileSend").val();
    var o = $("#mobile").val();
    var tnr = $('input[name=tenure]:radio:checked').val();
    //alert(e)
    if (e == '1') {
        $(".assurecl").hide();
        $(".careclass").show();
        var r = $("#sumInsuredNew").val();
        $(".slider_price1").hide();
        $(".slider_price6").show();
    } else if (e == '2') {
        $(".assurecl").hide();
        $(".careclass").show();
        var r = $("#sumInsured").val();
        $(".slider_price6").hide();
        $(".slider_price1").show();
    } else {
        $(".careclass").hide();
        $(".assurecl").show();
        assuresearch();
    }
    //alert(r);
    if (t == "1") {
        $(".floater1Plan").hide();
        //   var u = $("#ageGroupOfEldestMember1").val();

        var $select = $('[name="ageGroupOfEldestMember1[]"]');
        var u = new Array();
        for (var i = 0, len = $select.length; i < len; i++) {
            u[i] = $select.eq(i).val();
        }


        $("#onePremium").html('<img src="../images/loading.gif" />');
        $("#oneSumInsured").html('<img src="../images/loading.gif" />');
        $("#twoPremium").html('<img src="../images/loading.gif" />');
        $("#twoSumInsured").html('<img src="../images/loading.gif" />');
        $("#extraPremium").html('<img src="../images/loading.gif" />');
        $(".child1").hide();
        $(".agemember5").hide();
        $(".agemember4").hide();
        $(".agemember3").hide();
        $(".agemember2").hide();
        $(".agemember1").hide();
        $("#floatermemer").hide();
        $(".floater1").hide();

        $("#individualmember").show();
        $(".individual1").show();

        if (s == "0" && o.length < 10) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
        } else if (!isCharsInBag1(o, "0123456789")) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            if (e == '1') {
                $(".carewithncb").hide();
                $(".carencb").show();
                $.ajax({
                    type: "POST",
                    url: "../api_premium_for_agent_care_ncb.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + t + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + u + "&sumInsured=" + r + "&productTerm=1&tnr=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        $("#onePremium").html(t[0]);
                        $("#oneSumInsured").html(r);
                        $("#premium1").val(t[0]);
                        $("#twoPremium").html(t[2]);
                        //$("#premium2").val(t[1]);
                        $("#twoSumInsured").html(t[1]);
                        $("#extraPremium").html(t[3]);


                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                            $("#premium2").val(t[1]);
                        } else {
                            $("#insureyourhealth").show();
                            $("#premium2").val(t[1]);
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '2') {
                $(".carencb").hide();
                $(".carewithncb").show();
                $("#care").html('<img src="../images/loading.gif" />');
                $("#ncb").html('<img src="../images/loading.gif" />');
                $("#ncbextraPremium").html('<img src="../images/loading.gif" />');
                $.ajax({
                    type: "POST",
                    url: "../ncp_premium_agent.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + t + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + u + "&sumInsured=" + r + "&productTerm=1&tenure=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        var carepremium = t[0];
                        var ncbpremium = t[1];
                        if ((r == '5000000') || (r == '6000000')) {
                            $("#premiumradio-1").attr("checked", true);
                            $("#caresecondrow").hide();
                            $("#careonerow").show();
                        } else if (r == '300000') {
                            $("#premiumradio-2").attr("checked", true);
                            $("#careonerow").hide();
                            $("#caresecondrow").show();
                        } else {
                            $("#premiumradio-1").attr("checked", true);
                            $("#caresecondrow,#careonerow").show();
                        }
                        $("#care").html(carepremium);
                        $("#ncb").html(ncbpremium);
                        var extprm = parseInt(norm(ncbpremium)) - parseInt(norm(carepremium));
                        $("#ncbextraPremium").html(extprm);
                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                        } else {
                            $("#insureyourhealth").show();
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '3') {
                $(".assurecl").show();
                assuresearch();
            }
        }
    } else {

        $(".floater1Plan").show();
        if (t == 2) {
            $(".agemember5").hide();
            $(".agemember4").hide();
            $(".agemember3").hide();
            $(".agemember2").hide();
            $(".agemember1").show();
        } else if (t == 3) {
            $(".agemember5").hide();
            $(".agemember4").hide();
            $(".agemember3").hide();
            $(".agemember2").show();
            $(".agemember1").show();
        } else if (t == 4) {
            $(".agemember5").hide();
            $(".agemember4").hide();
            $(".agemember3").show();
            $(".agemember2").show();
            $(".agemember1").show();
        } else if (t == 5) {
            $(".agemember5").hide();
            $(".agemember4").show();
            $(".agemember3").show();
            $(".agemember2").show();
            $(".agemember1").show();
        } else if (t == 6) {
            $(".agemember5").show();
            $(".agemember4").show();
            $(".agemember3").show();
            $(".agemember2").show();
            $(".agemember1").show();
        }
        if (plT == 'FAMILYFLOATER') {
            var u = $("#ageGroupOfEldestMember").val();
            $(".child1").show();
            $(".individual1").hide();
            $("#individualmember").hide();
            $(".floater1").show();
            $("#floatermemer").show();


        } else if (plT == 'INDIVIDUAL') {
            var $select = $('[name="ageGroupOfEldestMember1[]"]');
            var u = new Array();
            for (var i = 0, len = $select.length; i < len; i++) {
                u[i] = $select.eq(i).val();
            }
            $(".child1").hide();
            $(".floater1").hide();
            $("#floatermemer").hide();
            $(".individual1").show();
            $("#individualmember").show();
        } else {
            var u = $("#ageGroupOfEldestMember").val();
            $(".floater1").hide();
            $("#floatermemer").hide();
            $(".individual1").show();
            $("#individualmember").show();
        }



        // $(".individual1").hide();

        //  $(".floater1").show();

        var a = parseInt(t) - parseInt(n);
        if (s == "0" && o.length < 10) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>')
        } else if (!isCharsInBag1(o, "0123456789")) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            $("#onePremium").html('<img src="../images/loading.gif" />');
            $("#oneSumInsured").html('<img src="../images/loading.gif" />');
            $("#twoPremium").html('<img src="../images/loading.gif" />');
            $("#twoSumInsured").html('<img src="../images/loading.gif" />');
            $("#extraPremium").html('<img src="../images/loading.gif" />');
            if (e == '1') {
                $(".carewithncb").hide();
                $(".carencb").show();
                $.ajax({
                    type: "POST",
                    url: "../api_premium_for_agent_care_ncb.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + a + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + u + "&sumInsured=" + r + "&productTerm=1&tnr=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        $("#onePremium").html(t[0]);
                        $("#oneSumInsured").html(r);
                        $("#premium1").val(t[0]);
                        $("#twoPremium").html(t[2]);
                        //$("#premium2").val(t[1]);
                        $("#twoSumInsured").html(t[1]);
                        $("#extraPremium").html(t[3]);


                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                            $("#premium2").val('2500000');
                        } else {
                            $("#insureyourhealth").show();
                            $("#premium2").val(t[1]);
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == 1) {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '2') {
                $(".carencb").hide();
                $(".carewithncb").show();
                $("#care").html('<img src="../images/loading.gif" />');
                $("#ncb").html('<img src="../images/loading.gif" />');
                $("#ncbextraPremium").html('<img src="../images/loading.gif" />');
                $.ajax({
                    type: "POST",
                    url: "../ncp_premium_agent.php",
                    async: true,
                    data: "coverTypeCd=" + plT + "&productId=" + e + "&numberOfAdult=" + a + "&numberOfChildren=" + n + "&ageGroupOfEldestMember=" + u + "&sumInsured=" + r + "&productTerm=1&tenure=" + tnr,
                    success: function(e) {
                        var t = e.split(":");
                        var carepremium = t[0];
                        var ncbpremium = t[1];
                        if ((r == '5000000') || (r == '6000000')) {
                            $("#caresecondrow").hide();
                        } else {
                            $("#caresecondrow").show();
                        }
                        $("#care").html(carepremium);
                        $("#ncb").html(ncbpremium);
                        var extprm = parseInt(norm(ncbpremium)) - parseInt(norm(carepremium));
                        $("#ncbextraPremium").html(extprm);
                        if (r >= 2500000) {
                            $("#insureyourhealth").hide();
                            $('input:radio[id=oneYear1]').prop('checked', true);
                        } else {
                            $("#insureyourhealth").show();
                        }
                        if (t[0] == 0 || e == "") {
                            alert("The premium for selected Sum Insured is unavailable currently. Kindly select another Sum Insured");
                        }
                        var n = parseInt(s) + 1;
                        $("#mobileSend").val(n);
                        if (n == "1") {
                            smsQuotation1();
                        }
                    }
                });
            }
            if (e == '3') {
                $(".assurecl").show();
                assuresearch();
            }
        }
    }
}
function assuresearch() {
    $(".careclass").hide();
    var productId = $("#subplan").val();
    var totalMember = '1';
    var numberOfChildren = '0';
    var c_numberOfChildren = '';
    var tenure = $('input[name=assuretenure]:radio:checked').val();
    var ageGroupOfEldestMember = $("#select_skin_demo_12").val();
    if ((ageGroupOfEldestMember == '51 - 55') || (ageGroupOfEldestMember == '56 - 60') || (ageGroupOfEldestMember == '61 - 65')) {
        var sumInsured = $("#sumInsured2").val();
        $(".slider_price4").hide();
        $(".slider_price3").show();
    } else {
        var sumInsured = $("#sumInsured1").val();
        $(".slider_price4").show();
        $(".slider_price3").hide();
    }
    var mobile = $("#mobile").val();
    if (mobile == "" || mobile.length < 10) {
        /*alert("Please enter mobile number.");
         $("#mobile").focus();*/
    } else if (!isCharsInBag1(mobile, "0123456789")) {
        /*alert("Please enter numeric values.");
         $("#mobile").focus();   */
        return false;
    } else {
        //alert(sumInsured);
        //alert(ageGroupOfEldestMember);
        $("#assurecare").html('<img src="../images/loading.gif" />');
        $("#assurencb").html('<img src="../images/loading.gif" />');
        var carepremium = '';
        var ncbpremium = '';
        $.ajax({
            type: "POST",
            url: "../assure_premium.php",
            async: true,
            data: "coverTypeCd=INDIVIDUAL&productId=" + productId + "&numberOfAdult=" + totalMember + "&numberOfChildren=" + numberOfChildren + "&ageGroupOfEldestMember=" + ageGroupOfEldestMember + "&sumInsured=" + sumInsured + "&tenure=" + tenure + "&productTerm=1",
            success: function(assuremsg) {
                // alert(assuremsg);	
                $("#assuresi").val(sumInsured);
                $("#assureage").val(ageGroupOfEldestMember);
                var assuremsg1 = assuremsg.split(":");
                var careval = assuremsg1[0];
                var ncbval = assuremsg1[1];

                var care1 = careval.split("_");
                var carepremium = care1[0];
                var carepremiumsi = care1[1];

                var ncb1 = ncbval.split("_");
                var ncbpremium = ncb1[0];
                var ncbpremiumsi = ncb1[1];
                if (sumInsured == '10000000') {
                    $("#secondrow").hide();
                } else {
                    if ((ageGroupOfEldestMember == '51 - 55') || (ageGroupOfEldestMember == '56 - 60') || (ageGroupOfEldestMember == '61 - 65')) {
                        if (sumInsured == '1000000') {
                            $("#secondrow").hide();
                        } else {
                            $("#secondrow").show();
                        }
                    } else {
                        $("#secondrow").show();
                    }
                }
                $("#assurecare").html(carepremium);
                $("#assurencb").html(ncbpremium);
                $("#assurecaresi").html(carepremiumsi);
                $("#assurencbsi").html(ncbpremiumsi);
                $("#ncbextraPremiumassure").html(assuremsg1[2]);
            }
        });
    }
}
function assureradiobtn(type) {
    if (type == 'care') {
        var assuresival = $("#assurecaresi").html();
    } else {
        var assuresival = $("#assurencbsi").html();
    }
    //alert(assuresival);
    var assuresival = assuresival.replace(/[, ]+/g, "").trim();
    //alert(assuresival);
    $("#assuresi").val(assuresival);
}
function sentRequestACallBackMail(e, t) {
    var agentSeoName = trim($("#agentSeoName").val());
    $.ajax({
        type: "POST",
        url: "../agent_request_a_callback.php",
        async: true,
        data: "firstname=" + e + "&mobilephone=" + t + "&agentSeoName=" + agentSeoName,
        success: function(msg) {
        }
    });
}
function referYourFriend() {
    var e = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var t = trim($("#referyourName").val());
    var n = trim($("#referyourContact").val());
    var r = trim($("#referyourFriendsName").val());
    var i = trim($("#referyourFriendsContact").val());
    var s = trim($("#referyourFriendsEmail").val());
    var o = trim($("#plannerName").val());
    var agentSeoName = trim($("#agentSeoName").val());
    if (t == "" || t == "Your Name") {
        alert("Please enter your name");
        return false
    }
    if (n == "" || n == "Mobile No.") {
        alert("Please enter your mobile no.");
        return false;
    } else {
        if (!isCharsInBag1(n, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        } else if (n.length < 10) {
            alert("Mobile must only contain 10 digits");
            return false;
        } else {
        }
    }
    if (r == "" || r == "Your Name") {
        alert("Please enter your friend's name");
        return false;
    }
    if (i == "" || i == "Mobile No.") {
        alert("Please enter your friend's contact no.");
        return false;
    } else {
        if (!isCharsInBag1(i, "0123456789")) {
            alert("Mobile must only contain Numbers");
            return false;
        } else if (i.length < 10) {
            alert("Mobile must only contain 10 digits");
            return false;
        } else {
        }
    }
    if (i == n) {
        alert("Your Contact Number and Your Friend's Contact Number Cannot be same.");
        return false;
    }
    if (e.test(s) == false) {
        alert("Please enter the Friend's Correct Email");
        return false;
    }
    $("#ReferAFriend").html('<img src="../images/loading.gif" />');
    $.ajax({
        type: "POST",
        url: "../refer_a_friend.php",
        async: true,
        data: "referyourName=" + t + "&referyourContact=" + n + "&referyourFriendsName=" + r + "&referyourFriendsContact=" + i + "&referyourFriendsEmail=" + s + "&agentSeoName=" + agentSeoName,
        success: function(e) {
            alert("Thank you for referring your friend to the Religare Health Insurance family. Our Health Planner, " + o + " will get in touch with " + r + " shortly.");
            $("#ReferAFriend").html('<img src="../images/submit.jpg"  alt="Submit" border="0" style="cursor:pointer;" onClick="referYourFriend();" />');
            $("#referyourName").val("");
            $("#referyourContact").val("");
            $("#referyourFriendsName").val("");
            $("#referyourFriendsContact").val("");
            $("#referyourFriendsEmail").val("");
            $(window).colorbox.close();
        }
    });
}
function smsQuotation1() {
    var e = $("#mobileSend").val();
    var agentId = $("#agentId").val();
    if (e == "1") {
        var t = $("#numberOfAdult").val();
        var n = $("#productId").val();
        var r = 1;
        if (t == "1") {
            var i = "INDIVIDUAL"
        } else {
            var i = "FAMILYFLOATER"
        }
        var s = $("#sumInsured").val();
        var o = $("#premium1").val();
        var u = $("#premium2").val();
        var a = "";
        var f = $("#mobile").val();
        if (f == "" || f.length < 10) {
            alert("Kindly fill in your mobile number to see your premium options");
            return false;
        } else if (!isCharsInBag1(f, "0123456789")) {
            $("#onePremium").html('<span style="font-size:17px;">----</span>');
            $("#oneSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#twoPremium").html('<span style="font-size:17px;">----</span>');
            $("#twoSumInsured").html('<span style="font-size:17px;">----</span>');
            $("#extraPremium").html('<span style="font-size:17px;">----</span>');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../lead_creation_agent.php",
                async: true,
                data: "coverTypeCd=" + i + "&productId=" + n + "&sumInsured=" + s + "&tenure=" + r + "&premium1=" + o + "&agentId=" + agentId + "&premium2=" + u + "&leadstage=Quotation&emailaddress1=" + a + "&mobilephone=" + f + "&type=Email",
                success: function(e) {
                    $("#mobileSend").val(2);
                }
            });
        }
    } else {
    }
}
function changeMemberList(e) {

    if (e == 'FAMILYFLOATER') {
        $(".child1").show();
        $(".individual1").hide();
        $("#individualmember").hide();
        $(".floater1").show();
        $("#floatermemer").show();


    } else if (e == 'INDIVIDUAL') {
        $(".child1").hide();
        $(".floater1").hide();
        $("#floatermemer").hide();
        $(".individual1").show();
        $("#individualmember").show();
    }
    searchResult1();
}
function checkContentHealth() {

    var v = $("#productId").val();
    switch (v) {
        case '1':
            {

                $("#secureassure,#enhance,#agentassureinsurance,#assurecl,#carencb,#joyPopup,#agenthealthinsuranceenhance").hide();
                $("#agenthealthinsurance,#carewithncb,#careclass").show();
                searchResult1();
                break;

            }
        case '2':
            {
                $("#secureassure,#enhance,#agentassureinsurance,#assurecl,#careclass,#joyPopup,#agenthealthinsuranceenhance").hide();
                $("#agenthealthinsurance,#carewithncb,#careclass").show();
                searchResult1();
                break;
            }
        case '3':
            {
                $("#secureassure,#enhance,#agenthealthinsurance,#careclass,#joyPopup,#agenthealthinsuranceenhance").hide();
                $("#agentassureinsurance,#assurecl").show();
                searchResult1();
                break;
            }
        case '4':
            {
                $("#secureassure,#enhance,#agenthealthinsurance,#careclass,#enhance,#agentassureinsurance,#assurecl,#agenthealthinsuranceenhance").hide();
                $("#joyPopup").show();
                resultJoy();
                break;
            }

        case '5':
            {
                $("#agentassureinsurance,#agenthealthinsurance,#secureassure,#assurecl,,#carewithncb,#careclass,#joyPopup").hide();
                $("#enhance,#agenthealthinsuranceenhance").show();
                changeChildrenEnhance();
                handlerEnhance(140000, '');
                break;
            }
    }
    //  searchResult1();
}
function checkProduct(n) {
    var v = $("#productId").val();

    switch (n) {
        case 'health' :
            {
                $("#travelinsurance,#agenttravelinsurance,#hidenotetravel,#securehealth,#agenthealthinsuranceenhance,#healthinsurance,#agenthealthinsurance").hide();
                switch (v) {
                    case  '3' :
                        {
                            $("#agentassureinsurance").show();
                            break;
                        }
                    case '5' :
                        {
                            $("#agenthealthinsuranceenhance").show();
                            break;
                        }
                    default :
                        {
                            $("#healthinsurance,#agenthealthinsurance").show();
                            if (v == 1) {
                                $("#carencb").hide();
                                $("#carewithncb").show();
                            } else {
                                $("#carewithncb").hide();
                                $("#carencb").show();
                            }
                            break;
                        }
                }
                document.getElementById("termsconditionAgent").href = "../terms.html";

                break;

            }
        case 'travel' :
            {

                $("#agenthealthinsuranceenhance,#securehealth,#healthinsurance,#agenthealthinsurance,#agentassureinsurance,#agenthealthinsuranceenhance").hide();
                $("#travelinsurance,#agenttravelinsurance,#hidenotetravel").show();
                document.getElementById("termsconditionAgent").href = "../travel-terms.html";
                break;
            }
        case 'secure' :
            {
                $("#agenthealthinsuranceenhance,#healthinsurance,#travelinsurance,#hidenotetravel,#agenthealthinsuranceenhance,#agenttravelinsurance,#hidenotetravel").hide();
                $("#securehealth").show();
                break;
            }

    }

}
