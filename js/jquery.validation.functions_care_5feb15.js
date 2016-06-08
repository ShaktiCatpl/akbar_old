/**
 * @author Prashant Gupta
 * @date 17 July 2014
 */
/*
 * This functions checks where an entered date is valid or not.
 * It also works for leap year feb 29ths.
 * @year: The Year entered in a date
 * @month: The Month entered in a date
 * @day: The Day entered in a date
 */
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
		
	  return age.years+':'+age.months+':'+age.days;
	}
function getFinalDate() {
    var n = $("#checkrelationidposition").val();
    var datepicker = $("#datepicker").val();
    if (datepicker != '') {
        $("#datepickerCD-" + n).val(datepicker);
        $("#datepickerCD-" + n).removeClass("ErrorField");
        $("#datepickerCD-" + n).next('.ValidationErrors').remove();
    } else {
        $("#datepickerCD-" + n).val(datepicker);
    }
	changeTitleList();
	caresearch();
}

function checkMicr(){
    var micr = $("#micr").val();
    var dataSting = "micr=" + micr;
    $.ajax({
        type: "POST",
        url: "checkMicr.php",
        async: true,
        data: dataSting,
        success: function(assuremsg) {
            var assuremsg1 = assuremsg.split(":");
            var careval = assuremsg1[0];
            var ncbval = assuremsg1[1];
           $("#policypageBranchName").val(ncbval);
           $("#policypagebankname").val(careval);
        }
    });
}


function fadeOut() {
    $("#healthidContent").delay(300).show(200);
    $("#healthid1").hide();
    $("#healthid").show();
}

$(document).ready(function() {





    $(".example8").colorbox({width: "auto", height: "auto", inline: true, href: "#inline_example1"});
    $(".exampleTerm").colorbox({width: "auto", height: "auto", inline: true, href: "#inline_exampleTerm"});





});

function setVisibility(id, visibility) {
    document.getElementById(id).style.display = visibility;

}
$(document).ready(function() {

    $("#healthid").click(function() {
        $("#healthidContent").delay(300).hide(200);
        $("#healthid").hide();
        $("#healthid1").show();
    });
    $("#healthid1").click(function() {
        $("#healthidContent").delay(300).show(200);
        $("#healthid1").hide();
        $("#healthid").show();
    });


    $("#savecnt").click(function() {
        $("#savebtn").hide();
        $("#thanku").show();
    });

    $("#clck1").click(function() {
        $("#id1").toggle();
        if ($('#question-2').is(':checked')) {
            setVisibility('id1', 'none');
        } else if ($('#question-1').is(':checked')) {
            setVisibility('id1', 'inline');
        }

    });

    $("#clck2").click(function() {
        $("#id2").toggle();
        if ($('#question1-2').is(':checked')) {
            setVisibility('id2', 'none');
        } else if ($('#question1-1').is(':checked')) {
            setVisibility('id2', 'inline');
        }
    });
    $("#clck3").click(function() {
        $("#id3").toggle();
        if ($('#question2-2').is(':checked')) {
            setVisibility('id3', 'none');
        } else if ($('#question2-1').is(':checked')) {
            setVisibility('id3', 'inline');
        }
    });
    $("#clck4").click(function() {
        $("#id4").toggle();
        if ($('#question3-2').is(':checked')) {
            setVisibility('id4', 'none');
        } else if ($('#question3-1').is(':checked')) {
            setVisibility('id4', 'inline');
        }
    });
    $("#clck5").click(function() {
        $("#id5").toggle();
        if ($('#question4-2').is(':checked')) {
            setVisibility('id5', 'none');
        } else if ($('#question4-1').is(':checked')) {
            setVisibility('id5', 'inline');
        }
    });


});
function isValidDate(year, month, day) {
    var date = new Date(year, (month - 1), day);
    var DateYear = date.getFullYear();
    var DateMonth = date.getMonth();
    var DateDay = date.getDate();
    if (DateYear == year && DateMonth == (month - 1) && DateDay == day) {

        return true;
    } else {
        return false;
    }
}

/*
 * This function checks if there is at-least one element checked in a group of check-boxes or radio buttons.
 * @id: The ID of the check-box or radio-button group
 */
function isChecked(id) {
    var ReturnVal = false;
    $("#" + id).find('input[type="radio"]').each(function() {
        if ($(this).is(":checked"))
            ReturnVal = true;
    });
    $("#" + id).find('input[type="checkbox"]').each(function() {
        if ($(this).is(":checked"))
            ReturnVal = true;
    });
    return ReturnVal;
}
function clearText(thefield) {
    if (thefield.defaultValue == thefield.value) {
        thefield.value = ""
    }
}
function replaceText(thefield) {
    if (thefield.value == "") {
        thefield.value = thefield.defaultValue
    }
}
function checkFirstNameVal(thefield, n) {

    if (thefield.value != 'First Name') {
        $("#insuredCdOne-" + n).html(thefield.value);
        $("#insuredCdTwo-" + n).html(thefield.value);
        $("#insuredCdThree-" + n).html(thefield.value);
        $("#insuredCdFour-" + n).html(thefield.value);
        $("#insuredCdFive-" + n).html(thefield.value);
    } else {
        $("#insuredCdOne-" + n).html("Insured " + n);
        $("#insuredCdTwo-" + n).html("Insured " + n);
        $("#insuredCdThree-" + n).html("Insured " + n);
        $("#insuredCdFour-" + n).html("Insured " + n);
        $("#insuredCdFive-" + n).html("Insured " + n);
    }
}

function checkFirstNameValTest(n) {
    var fieldVal = $("#firstNamecd-" + n).val();
    $("#insuredCdOne-" + n).html(fieldVal);
    $("#insuredCdTwo-" + n).html(fieldVal);
    $("#insuredCdThree-" + n).html(fieldVal);
    $("#insuredCdFour-" + n).html(fieldVal);
    $("#insuredCdFive-" + n).html(fieldVal);
}



function checkFirstInc(n) {
    var t;
    for (t = 1; t <= n; t++) {
        $("#insuredCdOne-" + t).html($("#firstNamecd-" + t).val());
        $("#insuredCdTwo-" + t).html($("#firstNamecd-" + t).val());
        $("#insuredCdThree-" + t).html($("#firstNamecd-" + t).val());
        $("#insuredCdFour-" + t).html($("#firstNamecd-" + t).val());
        $("#insuredCdFive-" + t).html($("#firstNamecd-" + t).val());

    }
}
function insuredCdQuestionChkEdit(n, t, year) {
    var datepickerCD = $("#datepickerCD-" + t).val();
    var values = new Array();
    $("." + n + ":checked").each(function() {
        values.push($(this).val());
    });

    if (datepickerCD != '') {
        var datepickerCD1 = datepickerCD.split('/');
        var combobox = $("#YYYY-" + n + "-" + t);
        var selectedVal = $("#YYYY-" + n + "-" + t).attr("did");
        //alert(selectedVal);
        $("#YYYY-" + n + "-" + t).empty().append('<option value="0">YYYY</option>').find('option:first').attr("selected", "selected");
        $("#cat-YYYY-" + n + "-" + t).html("YYYY");
        for (var y = year; y >= datepickerCD1[2]; y--) {
            if (!combobox.find('option[value="' + y + '"]').length) {
                if(selectedVal == y){
                $("#cat-YYYY-" + n + "-" + t).html(y);
                combobox.append($("<option/>").attr("value", y).attr("selected", "selected").text(y));
                } else {
                    combobox.append($("<option/>").attr("value", y).text(y));
                }
            }
        }

    } 






    if (values.length > 0) {
        $("#insuredCdQuestionMMYYYY-" + n).show();
        if ($('#insuredCdQuestionOne-' + n + '-' + t).is(":checked"))
        {
            $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).show();
        } else {
            $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).hide();
        }
    } else {
        $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).hide();
        $("#insuredCdQuestionMMYYYY-" + n).hide();
    }
}
function insuredCdQuestionChk(n, t, year) {
    var datepickerCD = $("#datepickerCD-" + t).val();
    var values = new Array();
    $("." + n + ":checked").each(function() {
        values.push($(this).val());
    });

    if (datepickerCD != '') {
        var datepickerCD1 = datepickerCD.split('/');
        var combobox = $("#YYYY-" + n + "-" + t);
        var selectedVal = $("#YYYY-" + n + "-" + t).attr("did");
        //alert(selectedVal);
        $("#YYYY-" + n + "-" + t).empty().append('<option value="0">YYYY</option>').find('option:first').attr("selected", "selected");
        $("#cat-YYYY-" + n + "-" + t).html("YYYY");
        for (var y = year; y >= datepickerCD1[2]; y--) {
            if (!combobox.find('option[value="' + y + '"]').length) {
                if(selectedVal == y){
                combobox.append($("<option/>").attr("value", y).attr("selected", "selected").text(y));
                } else {
                    combobox.append($("<option/>").attr("value", y).text(y));
                }
            }
        }

    } else {
        $("#insuredCdQuestionOne-" + n + "-" + t).attr("checked", false);
        alert("Please enter the Insured member DOB");
        return false;
    }






    if (values.length > 0) {
        $("#insuredCdQuestionMMYYYY-" + n).show();
        if ($('#insuredCdQuestionOne-' + n + '-' + t).is(":checked"))
        {
            $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).show();
        } else {
            $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).hide();
        }
    } else {
        $("#insuredCdQuestionMMYYYYP-" + n + "-" + t).hide();
        $("#insuredCdQuestionMMYYYY-" + n).hide();
    }
}
function isInArray(obj, a) {
    var i = a.length;
    while (i--) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

function changeTitleList() {    
    //var n = $("#checkrelationidposition").val();
	var n =1;
    if (n != '0') {
        var ValidFName = $("#ValidFName").val();
        if (ValidFName != '') {
            $("#firstNamecd-" + n).val(ValidFName);
            $("#firstNamecd-" + n).removeClass("ErrorField");
            $("#firstNamecd-" + n).next('.ValidationErrors').remove();
        }
        var ValidLName = $("#ValidLName").val();
        if (ValidLName != '') {
            $("#lastNamecd-" + n).val(ValidLName);
            $("#lastNamecd-" + n).removeClass("ErrorField");
            $("#lastNamecd-" + n).next('.ValidationErrors').remove();
        }
        var datepicker = $("#datepicker").val();
        if (datepicker != '') {
            $("#datepickerCD-" + n).val(datepicker);
            $("#datepickerCD-" + n).removeClass("ErrorField");
            $("#datepickerCD-" + n).next('.ValidationErrors').remove();
        }

        $("#titleCd-" + n + " option[value='0']").remove();
        $("#titleCd-" + n + " option[value='MR']").remove();
        $("#titleCd-" + n + " option[value='MS']").remove();
        $("#checkrelationidposition").val(n);
        $("#titleCd-" + n).append($("<option/>").attr("value", $("#ValidTitle").val()).text($("#ValidTitle option:selected").text()));
        $("#c_titleCd-" + n).html($("#ValidTitle option:selected").text());		
        checkFirstNameValTest(n);
		var relationCd =  $("#relationCd-1").val();
		//alert(datepicker);	alert(relationCd);
		if(relationCd=='SELF') {
		$("#firstNamecd-1").val(ValidFName);
		$("#lastNamecd-1").val(ValidLName);
		$("#datepickerCD-1").val(datepicker);	
		}
    }
}

function changeTitleCd(t, n) {
    var relationTitle = t.value;
    var values = new Array();
    $.each($("select[name='relationCd[]'] option:selected"), function() {
        values.push($(this).val());
    });
    var checkSingle = isInArray('SELF', values);
    var checkBrother = isInArray('BOTH', values);
    var checkSister = isInArray('SIST', values);

    if ((checkSingle == true) && (checkBrother == true)) {
        $("#firstNamecd-" + n).val('');
        $("#lastNamecd-" + n).val('');
        $("#datepickerCD-" + n).val('');
        $("#titleCd-" + n + " option[value='0']").remove();
        $("#titleCd-" + n + " option[value='MR']").remove();
        $("#titleCd-" + n + " option[value='MS']").remove();
        $("#relationCd-" + n).val(" ");
        $("#titleCd-" + n).append($("<option/>").attr("value", "0").text("Title"));
        $("#c_titleCd-" + n).html("Title");
        alert("Self and brother are not valid combination");
        return false;
    }
    if ((checkSingle == true) && (checkSister == true)) {
        $("#firstNamecd-" + n).val('');
        $("#lastNamecd-" + n).val('');
        $("#datepickerCD-" + n).val('');
        $("#titleCd-" + n + " option[value='0']").remove();
        $("#titleCd-" + n + " option[value='MR']").remove();
        $("#titleCd-" + n + " option[value='MS']").remove();
        $("#relationCd-" + n).val(" ");
        $("#titleCd-" + n).append($("<option/>").attr("value", "0").text("Title"));
        $("#c_titleCd-" + n).html("Title");
        alert("Self and Sister are not valid combination");
        return false;
    }
    var checkrelationid = $("#checkrelationid").val();
    if (checkSingle === true) {
        if (checkrelationid == 1 && relationTitle == 'SELF') {
            $("#relationCd-" + n).val(" ");
            alert("SELF-PRIMARY MEMBER Cannot be Duplicate");
            return false;
        }
        $("#checkrelationid").val("1");
    } else {
        $("#checkrelationid").val("0");
    }
    if (relationTitle == 'SELF') {
        $("#firstNamecd-" + n).attr("readonly", true);
        $("#lastNamecd-" + n).attr("readonly", true);
        $("#datepickerCD-" + n).attr("readonly", true);
        $("#titleCd-" + n).attr("readonly", true);
        $("#firstNamecd-" + n).val($("#ValidFName").val());
        $("#lastNamecd-" + n).val($("#ValidLName").val());
        $("#datepickerCD-" + n).val($("#datepicker").val());
        $("#titleCd-" + n + " option[value='0']").remove();
        $("#titleCd-" + n + " option[value='MR']").remove();
        $("#titleCd-" + n + " option[value='MS']").remove();
        $("#checkrelationidposition").val(n);
        $("#titleCd-" + n).append($("<option/>").attr("value", $("#ValidTitle").val()).text($("#ValidTitle option:selected").text()));
        $("#c_titleCd-" + n).html($("#ValidTitle option:selected").text());
        $("#firstNamecd-" + n).removeClass("ErrorField");
        $("#firstNamecd-" + n).next('.ValidationErrors').remove();
        $("#lastNamecd-" + n).removeClass("ErrorField");
        $("#lastNamecd-" + n).next('.ValidationErrors').remove();
        $("#datepickerCD-" + n).removeClass("ErrorField");
        $("#datepickerCD-" + n).next('.ValidationErrors').remove();
    } else {
        $("#checkrelationidposition").val("0");
        $("#firstNamecd-" + n).attr("readonly", false);
        $("#lastNamecd-" + n).attr("readonly", false);
        $("#datepickerCD-" + n).attr("readonly", false);
        $("#titleCd-" + n).attr("readonly", false);
        $("#firstNamecd-" + n).val('');
        $("#lastNamecd-" + n).val('');
        $("#datepickerCD-" + n).val('');
        switch (relationTitle) {
            case 'SPSE':
                {

                    var checkS = $("#ValidTitle").val();
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    if (checkS == 'MS') {
                        $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                        $("#c_titleCd-" + n).html("Mr");
                    } else if (checkS == 'MR') {
                        $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                        $("#c_titleCd-" + n).html("Ms");
                    } else {

                        $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                        $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                        $("#c_titleCd-" + n).html("Mr");
                    }
                    break;

                }
            case 'NBON':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;

                }
            case 'NEPH':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));

                    $("#c_titleCd-" + n).html("Mr");
                    break;

                }

            case 'SLAW':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));

                    $("#c_titleCd-" + n).html("Mr");
                    break;

                }
            case 'NIEC':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();

                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;

                }
            case 'COUS':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;

                }
            case 'SONM':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'UDTR':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'FATH':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'CPAR':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'KARTA':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'PUNC':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'MUNC':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'MDTR':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'MMBR':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'PANT':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'MANT':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }

            case 'MOTH':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'BOTH':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'SIST':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'GFAT':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'GMOT':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'GSON':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'GDAU':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'FLAW':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MR").text("Mr"));
                    $("#c_titleCd-" + n).html("Mr");
                    break;
                }
            case 'MLAW':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            case 'DLAW':
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#titleCd-" + n).append($("<option/>").attr("value", "MS").text("Ms"));
                    $("#c_titleCd-" + n).html("Ms");
                    break;
                }
            default:
                {
                    $("#titleCd-" + n + " option[value='0']").remove();
                    $("#titleCd-" + n + " option[value='MR']").remove();
                    $("#titleCd-" + n + " option[value='MS']").remove();
                    $("#c_titleCd-" + n).html('');
                    break;
                }

        }
    }
    checkFirstNameValTest(n);
}
/* <![CDATA[ */
jQuery(function() {

    var t = $("#totalAdultMember").val();
    var k;
    var permiumamountValid = $("#permiumamountValid").val();



    jQuery("#ValidPanCard").validate({
        expression: "if (VAL.match(/^([A-Z]{5})([0-9]{4})([A-Z]{1})$/)){ return true;} else{ jQuery('#errordisplayPrashant').show(); return false;}",
        message: "Please enter the pan number"

    });

    jQuery("#ValidTitle").validate({
        expression: "if (VAL != '0'){  $('#ValidTitleAddClass').removeClass();$('#ValidTitleAddClass').addClass('drop_Health gapBl'); return true; }else{ $('#ValidTitleAddClass').addClass('ErrorField'); jQuery('#errordisplayPrashant').show(); return false;}"
    });
    jQuery("#ValidFName").validate({
        expression: "if (VAL.match(/^[a-zA-Z\(\)]+$/) && VAL) { return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
        message: "Please enter valid first name"
    });
    jQuery("#ValidLName").validate({
        expression: "if (VAL.match(/^[a-zA-Z\(\)]+$/) && VAL) { return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
       message: "Please enter valid last name"

    });
    jQuery("#datepicker").validate({
        expression: "if (!isValidDate(parseInt(VAL.split('/')[2]), parseInt(VAL.split('/')[1]), parseInt(VAL.split('/')[0]))){ jQuery('#errordisplayPrashant').show(); return false; } else {  return true; }",
        message: "Please enter valid date of birth"
    });
    jQuery("#ValidMobileNumber").validate({
        expression: "if (VAL.match(/^[0-9]*$/) && VAL) { if(VAL.length==10){ return true; } else { jQuery('#errordisplayPrashant').show(); return false; } } else { jQuery('#errordisplayPrashant').show();  return false;}",
        message: "Please enter valid mobile number"
    });
    jQuery("#ValidAddressOne").validate({
        expression: "if (VAL !='') {  return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
		message: "Please enter valid address"

    });
     
     jQuery("#ValidCityName").validate({
        expression: "if (VAL !='Select City') {  return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
        message: "Please select city"
    });
     
     
    jQuery("#ValidEmail").validate({
        expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)){ return true;} else{ jQuery('#errordisplayPrashant').show(); return false;}",
        message: "Please enter valid email Id"
    });
    jQuery("#ValidPinCode").validate({
        expression: "if (VAL.match(/^[0-9]*$/) && VAL) { if(VAL.length==6){  return true; } else { jQuery('#errordisplayPrashant').show(); return false; } } else { jQuery('#errordisplayPrashant').show(); return false;}",
         message: "Please enter valid pin code"
    });
   
    for (k = 1; k <= t; k++) {
        jQuery("#relationCd-" + k).validate({
            expression: "if (VAL != '0'){  $('#ValidRelationAddClass-" + k + "').removeClass();$('#ValidRelationAddClass-" + k + "').addClass('drop_Health'); return true; }else{ $('#ValidRelationAddClass-" + k + "').addClass('ErrorField'); return false;}"
        });
        jQuery("#titleCd-" + k).validate({
            expression: "if (VAL != '0'){  $('#ValidSubTitleAddClass-" + k + "').removeClass();$('#ValidSubTitleAddClass-" + k + "').addClass('drop_Health_title'); return true; }else{ $('#ValidSubTitleAddClass-" + k + "').addClass('ErrorField'); return false;}"
        });
        jQuery("#firstNamecd-" + k).validate({
            expression: "if (VAL.match(/^[a-zA-Z\(\)]+$/) && VAL) { return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
            message: "Please enter valid first name"

        });
        jQuery("#lastNamecd-" + k).validate({
            expression: "if (VAL.match(/^[a-zA-Z\(\)]+$/) && VAL) { return true; } else { jQuery('#errordisplayPrashant').show(); return false; }",
            message: "Please enter valid last name"

        });

        if (k == t) {
            jQuery("#datepickerCD-" + k).validate({
                expression: "if (VAL !='') { fadeOut(); return true; } else {  return false; }",
                message: "Please enter valid date of birth"

            });
        } else {
            jQuery("#datepickerCD-" + k).validate({
                expression: "if (VAL !='') {  return true; } else {  return false; }",
                message: "Please enter valid date of birth"

            });
        }
    }
    jQuery("#question").validate({
        expression: "if (isChecked(SelfID)){ return true; } else { openHealthQues(); return false; } "

    });
    jQuery("#question1").validate({
        expression: "if (isChecked(SelfID)){ return true; } else { openHealthQues(); return false; } "

    });
    jQuery("#question2").validate({
        expression: "if (isChecked(SelfID)){ return true; } else { openHealthQues(); return false; } "

    });
    jQuery("#question3").validate({
        expression: "if (isChecked(SelfID)){ return true; } else { openHealthQues(); return false; } "

    });
    jQuery("#question4").validate({
        expression: "if (isChecked(SelfID)){ return true; } else { openHealthQues(); return false; } "

    });
    jQuery("#validTermCondition").validate({
        expression: "if (isChecked(SelfID)) return true; else return false;",
    });
    jQuery('.AdvancedForm').validated(function() {

        jQuery("#errordisplayPrashant").hide();

        try {
            /*var x = new Date($("#datepicker").val());
            var Cnow = new Date();//current Date
           	if (Cnow.getFullYear() - x.getFullYear() < 18) {
                alert('Proposer`s age should be 18 years or more');
                return;
            }*/
			var qdob	=	$("#datepicker").val();
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
				$("#care").html('--');	
				$("#qdob").html('');
				$("#qdob").val('');
				return false;
			}
        }
        catch (ejs) {
            alert('Please enter valid date');
            return;
        }


        var checkFlag = checkQuestionData(t);
        if (checkFlag == false) {
            return;
        }



        document.savePageenhanceForm.submit();

    });

});
/* ]]> */

function openHealthQues() {
    $("#healthidContent").delay(300).show(200);
    $("#healthid1").hide();
    $("#healthid").show();
}


function checkQuestionData(n) {

    if ($('#question-2').is(':checked')) {
        return true;
    }

    var err_msg = "";
    for (var u = 1; u <= n; u++) {
        var selectedVal = $("#sonu" + u).val();
        //alert(selectedVal);
        //return false;
        var values = new Array();
        if (selectedVal == 'YES') {
            // err_msg = err_msg +" :" +n +": ";
            if ($(".prashant" + u + ":checked").length) {
                $(".prashant" + u + ":checked").each(function() {
                    values.push($(this).val());
                    var msg = $(this).attr('id');
                    var msg1 = msg.split('-');
                    var mm = 'MM-' + msg1[1] + '-' + msg1[2];
                    var yyyy = 'YYYY-' + msg1[1] + '-' + msg1[2];
                    if (($("#" + mm).val() == '0') || ($("#" + yyyy).val() == '0')) {
                        err_msg = "Please select 'Existing since?(MM/YYYY)' in Health Questionnaire for Pre-existing diseases";
                    }
                });

            } else {
                err_msg = "Please select one of the questions in Health Questionnaire for Pre-existing diseases";
            }
        }
        else if (selectedVal == '0') {
            err_msg = "Please select in Health Questionnaire for Pre-existing diseases";
        }
    }

    if (err_msg != "") {
        alert(err_msg);
        openHealthQues();
        return false;
    } else {
        return true;
    }
}
function displayQuestion(n) {
    var selectedVal = $("#sonu" + n).val();
    if (selectedVal == 'NO') {
        $(".year-month-" + n).hide();
        $(".prashant" + n).attr('checked', false);
        $("input.prashant" + n).attr('disabled', 'disabled');

    } else {
        $("input.prashant" + n).removeAttr("disabled");
    }
}


function getCityName() {
    var pincode = $("#ValidPinCode").val();
    if (pincode != "")
        $.post("getCity.php", {"pincode": pincode}, stateReply, 'json');
}
function stateReply(d, s)
{

    var elSel = document.getElementById('ValidCityName');
    var i;
    for (i = elSel.length; i >= 0; i--) {
        elSel.remove(i);
    }

    $.each(d,
            function() {
                $("#ValidStateName").val('');
                var str = this.CITY;
                var state = this.STATE;
                var option = new Option(str, str);
                    var dropdownList = $("#ValidCityName")[0];
                    dropdownList.add(option, null);
                if (state == 'error') {
                    alert("Please enter valid pincode");
                    $("#ValidPinCode").val('');
                    $("#ValidStateName").val('');
                } else {
                    
                    $("#ValidStateName").val(state);
                }
            }
    );

}
function checkClickEvent(n) {
    $("#checkclickid").val(n);
    if (n == 2) {
        $("#confirmMail").val($("#ValidEmail").val());
        $(".saveContinue").colorbox({width: "auto", height: "auto", inline: true, href: "#inline_saveContinue"});
    }
}

function saveform() {
    var n = $("#confirmMail").val();
    var r = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (r.test(n) == false) {
        alert("Please enter valid email id");
        return false;
    } else {
        $("#saveandcontinueemail").val(n);
        document.savePageenhanceForm.submit();
    }
}
function hideColorBox() {
    $.colorbox.close();
}
function checkYear(yearVal, serverY, n, m, mo) {
    var m_names = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var k = 0;
    var i;
    $("#MM-" + n + "-" + m + " option[value='0']").remove();
    $("#MM-" + n + "-" + m).append($("<option/>").attr("value", '0').text('MM'));
    $("#cat-MM-" + n + "-" + m).html("MM");
    if (yearVal == serverY) {
        for (i = 1; i <= 12; i++) {
            $("#MM-" + n + "-" + m + " option[value='" + i + "']").remove();
        }
        for (i = 1; i <= mo; i++) {
            $("#MM-" + n + "-" + m).append($("<option/>").attr("value", i).text(m_names[k]));
            k++;
        }

    } else {

        for (i = 1; i <= 12; i++) {
            $("#MM-" + n + "-" + m + " option[value='" + i + "']").remove();

            $("#MM-" + n + "-" + m).append($("<option/>").attr("value", i).text(m_names[k]));

            k++;
        }

    }
}
function checkDateVal(n) {
    var y = $("#ValidRelationAddClass-" + n + " option:selected").val();
    if (y == 'SELF') {
        return false;
    } else {
        return true;
    }
}

