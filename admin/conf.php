<?php

session_start();
$mand_field = "";
$mand_field_msg = $mand_field . " fields are mandatory  ";
if (!defined("_WWWROOT"))
    define("_WWWROOT", "http://" . @$_SERVER['SERVER_NAME'] . '');
if (!defined("_SITEURL"))
    define("_SITEURL", "http://" . @$_SERVER['SERVER_NAME'] . '');

/*if (substr_count(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
    ob_start("ob_gzhandler");*/

else
 ob_start();
date_default_timezone_set('Asia/Calcutta');
define('RECORDLIMITPERPAGE', '300');
define('PAGEROW', '60');
define('NOOFLINK', '2');
$basicUrl = "http://" . @$_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
$ip = @$_SERVER['REMOTE_ADDR'];
$URL = @$_SERVER['REQUEST_URI'];
$_SESSION['PHPSESSID1'] = @$_REQUEST['PHPSESSID'];
if (@$_SESSION['mobileSend'] == "") {
    $_SESSION['mobileSend'] = 0;
}
$sitepath = _SITEURL . "/";
$linkpath = _SITEURL . "/";
$target_path = "../mediaupload/";
$prefix = substr(time(), 6, 2);
$filePath = $_SERVER['DOCUMENT_ROOT'] . '';
$resourceFilePath = $filePath . '/resource';
$searchArray = array("<p>", "</p>");
$replaceArray = array("");
define("ADMINURL", "../", true);
/* http://10.216.6.50/cordys/WSDLGateway.wcp?service=http%3A%2F%2FCrmService%2FWebService/Createlead&organization=o%3DReligareHealth%2Ccn%3Dcordys%2Ccn%3DdevInst%2Co%3Dreligare.in&version=isv */
//define("SITEUPLOAD", "F:\religare 18-jan-2012\images", true);
define("SITEUPLOAD", "../siteupload/", true);
define("TRAVELURL","http://traveluat.religaretravelinsurance.com/");
$quotationURL = "http://10.216.9.176:80/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devinst,o=religare.in";
$leadURL = "http://10.216.9.176:80/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devinst,o=religare.in";
$policyURL = "http://10.216.9.176:80/cordys/com.eibus.web.soap.Gateway.wcp?organization=o=ReligareHealth,cn=cordys,cn=devinst,o=religare.in";
$LOGOUTURL = "https://rhicluat.religare.com:443/portalui/jsp/logout.jsp";
$proposalURL = "https://rhicluat.religare.com:443/portalui/PortalExtProposal.run";
$assurePortalProposal = "https://rhicluat.religare.com:443/portalui/PortalExtProposal.run";
define("LOGINURL", "https://rhicluat.religare.com:443/portalui/jsp/login", true);
define("REGISTRATIONURL", "https://rhicluat.religare.com:443/portalui/jsp/RegisterPolicy.jsp", true);
define("RENEWALURL", "https://rhicluat.religare.com:443/portalui/jsp/RenewalLogin.jsp", true);
define("MYACCOUNTURL", "https://rhicluat.religare.com:443/portalui//PortalSearchController.run?mode=INIT", true);
define("AGENTPORTAL", "https://rhicluat.religare.com:443/agencyportal/jsp/AgencyLogin.jsp");
//define("AGENTPORTAL", "https://rhicluat.religare.com:443/portalui/jsp/agency/AgencyLogin.jsp");
define("SMSURL", "http://luna.a2wi.co.in:7501/failsafe/HttpLink?aid=508460&pin=rh12");
define("CUSTOMERSUPPORTEMAIL", "careers@religarehealthinsurance.com", true);
define("CAREEREMAIL", "careers@religarehealthinsurance.com", true);
define("FEEDBACKEMAIL", "careers@religarehealthinsurance.com", true);
define("AGENTEMAIL", "careers@religarehealthinsurance.com", true);
define("AGENTID", "20008135", true);
//define("AGENTID", "00000836", true);
//define("AGENTID", "20000057", true);
$benefitGroupArray = array("HADS" => "ADDITIONAL SERVICES", "HAMB" => "AMBULANCE CHARGES", "HAMT" => "ALTERNATE METHOD OF TREATMENT", "HAYS" => "AYUSH", "HB30" => "PRE-HOSPITALIZATION 30 DAYS", "HB60" => "POST-HOSPITALIZATION 60 DAYS", "HCOI" => "COVER OUTSIDE INDIA", "HCRT" => "CATARACT", "HDCS" => "HOSPITALIZATION DAY CARE", "HDME" => "DURABLE MEDICAL EQUIPMENT", "HDOM" => "DOMICILIARY TREATMENT", "HDTL" => "DENTAL CHARGES", "HENH" => "ENHANCE", "HEOP" => "E-OPINION", "HHCK" => "HEALTH CHKUP", "HHDA" => "HOSPITAL DAILY CASH ALLOWANCE", "HHIC" => "HIV COMPREHENSIVE COVER", "HHIV" => "HIV BASIC COVER", "HIPD" => "HOSPITALIZATION -IPD", "HMAT" => "MATERNITY BENEFITS", "HMBT" => "MATERNITY BENEFIT", "HMDG" => "MAJOR DAIGNOSTICS", "HMTC" => "MATERNITY COMPLICATIONS", "HNBB" => "NEW BORN BABY - MATERNITY", "HOPD" => "HOSPITALIZATION -OPD", "HORD" => "ORGAN DONAR", "HPCR" => "PATIENT CARE", "HPNT" => "PRE NATAL", "HPOT" => "POST NATAL", "HPPC" => "PRE POLICY HEALTH CHECK UP", "HPSY" => "PSYCHIATRIC TREATMENT", "HREC" => "RECHARGE", "HSAB" => "SHARED ACCOMDATION BENEFIT", "HWOB" => "WORLD OVER BENEFIT", "H0PD" => "HOSPITALIZATION -OPD", "H0RD" => "ORGAN DONAR", "ACCG" => "ACCG TEST", "B001" => "B001 TEST");
$claimStatusArray = array("CA" => "Claim Approved", "CC" => "Claim Closed", "CD" => "Claim Deficient", "CN" => "Claim Cancelled", "CP" => "Claim Pending  ", "CR" => "Claim Rejected", "CV" => "Claim Reversed", "AC" => "AL Cancelled", "AD" => "AL Deficiency", "AE" => "AL Entered", "AH" => "AL Hold", "AI" => "AL Issued", "AR" => "AL Rejected", "CM" => "AL - Attached to Claim");
$secondaryStatusArray = array("AP" => "Approved", "AI" => "Approve & Investigate", "CN" => "Cancelled", "PE" => "Pending Data Entry", "PD" => "Pending Doctor's Entry", "PI" => "Pending Investigation", "PR" => "Pending Requirement", "PA" => "Pending AMT Approval", "RJ" => "Rejected");
$disallowanceArray = array("0000" => "Incremental charges", "0001" => "DIFFERENCE IN TARIFF", "0002" => "NON MEDICAL EXPENSES", "0003" => "ADMISSION CHARGES", "0004" => "MRD CHARGES", "0005" => "DOCUMENTATION CHARGES", "0006" => "MEDICOLEGAL CHARGES", "0007" => "MEDICAL CERTIFICATE CHARGES", "0008" => "PATIENT DIET CHARGES", "0009" => "ATTENDANT CHARGES", "0010" => "ATTENDANT DIET CHARGES", "0011" => "INVESTIGATION/TREATMENT FOR UN", "0012" => "ANY EXPENSES RELATED TO HIV, S", "0013" => "DONOR SCREENING CHARGES", "0014" => "HOME VISIT CHARGES", "0015" => "COST OF SPECTACLES/ CONTACT LE", "0016" => "WEIGHT CONTROL PROGRAMS/ SUPPL", "0017" => "SERVICE CHARGES", "0018" => "LUXARY TAX", "0019" => "HOUSE KEEPING CHARGES", "0020" => "SURCHARGES", "0021" => "BIRTH CERTIFICATE CHARGES", "0022" => "DISCHARGE PROCEDURE CHARGES", "0023" => "ENTRANCE PASS / VISITORS PASS", "0024" => "MAINTAINANCE CHARGES", "0025" => "HOSPITAL DISCOUNT", "0026" => "HOSPITAL REFUND CHARGES.", "0027" => "OTHERS", "0028" => "MEMBER PAID", "0029" => "RMO CHARGES", "0030" => "HAIR REMOVING CREAM CHARGES", "0031" => "BABY  FOOD", "0032" => "BABY  UTILITES CHARGES", "0033" => "BABY  SET", "0034" => "BABY  BOTTLES", "0035" => "BOTTLE", "0036" => "BRUSH", "0037" => "COSY TOWEL", "0038" => "HAND WASH", "0039" => "MOISTURISER PASTE BRUSH", "0040" => "POWDER", "0041" => "RAZOR", "0042" => "TOWEL", "0043" => "SHOE COVER", "0044" => "BEAUTY SERVICES", "0045" => "BUDS", "0046" => "BARBER CHARGES", "0047" => "CAPS", "0048" => "COLD  PACK/HOT PACK", "0049" => "CARRY  BAGS", "0050" => "CRADLE CHARGES", "0051" => "COMB", "0052" => "DISPOSABLE RAZOR  CHARGES ( FO", "0053" => "EYE PAD", "0054" => "EYE SHEILD", "0055" => "EMAIL  / INTERNET CHARGES", "0056" => "FOOD CHARGES (OTHER THAN PATIE", "0057" => "FOOT COVER", "0058" => "LAUNDRY CHARGES", "0059" => "MINERAL WATER", "0060" => "OIL CHARGES", "0061" => "SANITARY PAD", "0062" => "SLIPPERS", "0063" => "TELEPHONE CHARGES", "0064" => "TISSUE PAPER", "0065" => "TOOTH  PASTE", "0066" => "TOOTH  BRUSH", "0067" => "GUEST SERVICES", "0068" => "BED PAN", "0069" => "BED UNDER PAD  CHARGES", "0070" => "CAMERA COVER", "0071" => "CLINIPLAST", "0072" => "CREPE BANDAGE", "0073" => "CURAPORE", "0074" => "DIAPER OF ANY TYPE", "0075" => "DVD, CD CHARGES", "0076" => "EYELET COLLAR", "0077" => "FACE MASK", "0078" => "FLEXI MASK", "0079" => "GAUSE SOFT", "0080" => "GAUZE", "0081" => "HAND HOLDER", "0082" => "HANSAPLAST/ ADHESIVE BANDAGES", "0083" => "LACTOGEN/ INFANT FOOD", "0084" => "INFERTILITY/ SUBFERTILITY/ ASS", "0085" => "BLADE", "0086" => "URINE CONTAINER", "0087" => "BLOOD RESERVATION CHARGES AND", "0088" => "COURIER CHARGES", "0089" => "CONVENYANCE CHARGES", "0090" => "DIABETIC CHART CHARGES", "0091" => "FILE OPENING CHARGES", "0092" => "PREPARATION CHARGES", "0093" => "PHOTOCOPIES CHARGES", "0094" => "PATIENT IDENTIFICATION BAND /", "0095" => "WASHING CHARGES", "0096" => "MEDICINE BOX", "0097" => "WALKING AIDS CHARGES", "0098" => "BIPAP MACHINE", "0099" => "COMMODE", "0100" => "OXYGEN CYLINDER (FOR USAGE OUT", "0101" => "SPACER", "0102" => "SPO2  PROBE", "0103" => "NEBULIZER KIT", "0104" => "STEAM INHALER", "0105" => "THERMOMETER", "0106" => "CERVICAL COLLAR", "0107" => "SPLINT", "0108" => "DIABETIC FOOT WEAR", "0109" => "KNEE BRACES ( LONG/ SHORT/ HIN", "0110" => "KNEE IMMOBILIZER/SHOULDER IMMO", "0111" => "AMBULANCE COLLAR", "0112" => "AMBULANCE EQUIPMENT", "0113" => "MICROSHEILD", "0114" => "PRIVATE NURSES CHARGES- SPECIA", "0115" => "SUGAR FREE", "0116" => "VACCINE CHARGES FOR BABY", "0117" => "AESTHETIC TREATMENT / SURGERY", "0118" => "TPA CHARGES", "0119" => "VISCO BELT CHARGES", "0120" => "ANY KIT WITH NO DETAILS MENTIO", "0121" => "EXAMINATION GLOVES", "0122" => "KIDNEY TRAY", "0123" => "MASK", "0124" => "OUNCE GLASS", "0125" => "OXYGEN MASK", "0126" => "PAPER GLOVES", "0128" => "PAN  CAN", "0129" => "SOFNET", "0130" => "TROLLY COVER", "0131" => "UROMETER", "0132" => "SOFTOVAC POWDER", "0133" => "ARTIFICIAL LIMB CHARGES", "0134" => "BABY CARE", "0135" => "CASHLES PROCEDURE CHARGE", "0136" => "CMO CHARGE", "0137" => "CREDIT BILL", "0138" => "DUPLICATE REPORT CHARGES", "0139" => "FILE CHARGE", "0140" => "JUNIOR DOCTOR ASSISSTANT CHARG", "0141" => "LAB VISIT ATTENDANT CHARGE", "0142" => "MEDICAL SUPERVISION", "0143" => "SPECIAL PROCEDURE CHARGES", "0144" => "WAITING CHARGES", "0145" => "ABDUCTION WEDGE CHARGES", "0146" => "ADULT ROMSON CLIPPER BLADE", "0147" => "ALPHA BED", "0148" => "BABY BATH", "0149" => "BABY POWDER", "0150" => "BANDAGE", "0151" => "BENTEX", "0152" => "BIG TAGS", "0153" => "BIO MEDICAL CHARGES", "0154" => "BLOOD BANK DEPOSIT", "0155" => "BMW CHARGES", "0156" => "BOOK CHARGES", "0157" => "CANULA FIXATOR CHARGES", "0158" => "CARDIAC MONITORING CHARGES", "0159" => "CASETTE CHARGE", "0160" => "CD BOX", "0161" => "CHALAN BILL", "0162" => "COLLECTION MATERIAL", "0163" => "COLOGNE", "0164" => "COLOSTOMY KIT", "0165" => "COMODE CHAIR", "0166" => "CREDIT CARD CHARGE", "0167" => "CRUTCH", "0168" => "DARK GLASS", "0169" => "DISCO FIX CHARGES", "0170" => "DISPOSABLE GARMENTS", "0171" => "DISPOSABLE GLASS", "0172" => "DONATION", "0173" => "DRAW SHEET", "0174" => "DRESSING TRAY", "0175" => "DVD CHARGES", "0176" => "DYNAPLAST", "0177" => "EASY FIX CHARGES", "0178" => "EPBX CHARGE", "0179" => "ESCORTING CHARGES", "0180" => "EXCESS VISIT CHARGES", "0181" => "EXTENSION BRACE", "0182" => "EXTENSION TUBE", "0183" => "EXTERNAL APPLIANCES CHARGES NO", "0184" => "FAX CHARGES", "0185" => "FLAME GRIP", "0186" => "FLUID ADMINISTRATION CHARGES", "0187" => "FUMIGATION CHARGE", "0188" => "HEATER CHARGE", "0189" => "HOT WATER CHARGES", "0190" => "INHALER", "0191" => "IV MAINTENANCE", "0192" => "LANCET", "0193" => "PRE AUTH LETTER CHARGES", "0194" => "PRE-OP ROOM CHARGES", "0195" => "REFRIGERATION CHARGES", "0196" => "ROOM FRESHENER", "0197" => "ROOM HOLDING CHARGES", "0198" => "SEALED POUCHES", "0199" => "SITZ BATH", "0200" => "SOLID WASTE MANAGEMENT", "0201" => "STOCKINET", "0202" => "THREE WAYS", "0203" => "VACUTAINNER", "0204" => "VAT CHARGES", "0205" => "WARD COMMON CHARGES", "0206" => "WASTE DISPOSAL CHARGES", "0207" => "EXTERNAL DURABLE DEVICES", "0208" => "BELTS/ BRACES", "0209" => "GOWN", "0210" => "LEGGINGS", "0211" => "SLINGS", "0212" => "DENTAL TREATMENT EXPENSES THAT", "0213" => "HORMONE REPLACEMENT THERAPY", "0214" => "PSYCHIATRIC & PSYCHOSOMATIC DI", "0215" => "CORRECTIVE SURGERY FOR REFRACT", "0216" => "TREATMENT OF SEXUALLY TRANSMIT", "0217" => "ADMISSION/REGISTRATION CHARGES", "0218" => "HOSPITALISATION FOR EVALUATION", "0219" => "EXPENSES FOR INVESTIGATION/ TR", "0220" => "ANY EXPENSES WHEN THE PATIENT", "0221" => "STEM CELL IMPLANTATION/ SURGER", "0222" => "WARD AND  THEATRE BOOKING CHAR", "0223" => "ARTHROSCOPY & ENDOSCOPY INSTRU", "0224" => "MICROSCOPE COVER", "0225" => "SURGICAL BLADES,HARMONIC SCALP", "0226" => "SURGICAL DRILL", "0227" => "EYE KIT", "0228" => "EYE DRAPE", "0229" => "SPUTUM CUP", "0230" => "BOYLES APPARATUS CHARGES", "0231" => "BLOOD GROUPING AND  CROSS MATC", "0232" => "SAVLON", "0233" => "STERILE INJECTIONS, NEEDLES, S", "0234" => "COTTON", "0235" => "COTTON BANDAGE", "0236" => "MICROPORE/ SURGICAL TAPE", "0237" => "APRON", "0238" => "TORNIQUET", "0239" => "ORTHOBUNDLE, GYNAEC BUNDLE", "0240" => "HVAC", "0241" => "TELEVISION & AIR CONDITIONER C", "0242" => "CLEAN SHEET", "0243" => "EXTRA  DIET OF PATIENT(OTHER T", "0244" => "BLANKET/WARMER BLANKET", "0245" => "MORTUARY CHARGES", "0246" => "CPAP/ CPAD EQUIPMENTS", "0247" => "INFUSION PUMP  - COST", "0248" => "PULSEOXYMETER CHARGES", "0249" => "SPIROMETER", "0250" => "ARMSLING", "0251" => "LUMBO SACRAL  BELT", "0252" => "NIMBUS BED OR WATER OR AIR BED", "0253" => "ABDOMINAL BINDER", "0254" => "BETADINE  HYDROGEN PEROXIDES", "0255" => "CREAM POWDER LOTION", "0256" => "DIGENE  GEL/ ANTACID GEL", "0257" => "ECG ELECTRODES", "0258" => "HIV KIT", "0259" => "LISTERINE/ ANTISEPTIC MOUTHWAS", "0260" => "LOZENGES", "0261" => "MOUTH PAINT", "0262" => "NEOSPRIN", "0263" => "NOVARAPID", "0264" => "VOLINI GEL/ ANALGESIC GEL", "0265" => "ZYTEE GEL", "0266" => "ALCOHOL SWABES", "0267" => "SCRUB SOLUTION/STERILLIUM", "0269" => "PELVIC TRACTION BELT", "0270" => "ACCU CHECK ( GLUCOMETERY/ STRI)");
$relationArray = array(
    'MMBR' => 'primary member', 'UDTR' => 'daughter', 'BOTH' => 'brother',
    'CHD2' => 'Child', 'CHD3' => 'Child', 'CHLD' => 'Child',
    'DLAW' => 'Daughter In Law', 'EFAT' => 'father', 'EFLW' => 'father In Law',
    'EMLW' => 'mother In Law', 'EMOT' => 'mother', 'FATH' => 'father',
    'FLAW' => 'father In Law', 'GDAU' => 'Grand Daughter', 'GFAT' => 'grand father',
    'GMOT' => 'grand mother', 'GSON' => 'grand son', 'MLAW' => 'mothe in law',
    'MOTH' => 'mother', 'SIST' => 'sister', 'SLAW' => 'son in law',
    'SONM' => 'son', 'SPSE' => 'Spouse', 'UDTR' => 'daughter',
);

function dateChange($date) {
    if ($date != "00000000") {
        return substr(@$date, 6, 2) . '-' . substr(@$date, 4, 2) . '-' . substr(@$date, 0, 4);
    } else {
        return '';
    }
}

global $INDIVIDUAL, $FAMILYFLOATER, $GroupCareArray;
$GroupCareArray = array("200000" => "2 Lac + 2 Lac", "300000" => "3 Lac + 3 Lac", "400000" => "4 Lac + 4 Lac", "500000" => "5 Lac + 5 Lac", "700000" => "7 Lac + 7 Lac", "1000000" => "10 Lac + 10 Lac", "1500000" => "15 Lac + 10 Lac", "2000000" => "20 Lac + 10 Lac", "2500000" => "25 Lac + 10 Lac", "5000000" => "50 Lac + 10 Lac", "6000000" => "60 Lac + 10 Lac");
$INDIVIDUAL = array(
    "200000" => "001",
    "300000" => "003",
    "400000" => "005",
    "500000" => "007",
    "700000" => "009",
    "1000000" => "011",
    "1500000" => "013",
    "2000000" => "015",
    "2500000" => "017",
    "5000000" => "019",
    "6000000" => "021"
);
$FAMILYFLOATER = array(
    "200000" => "002",
    "300000" => "004",
    "400000" => "006",
    "500000" => "008",
    "700000" => "010",
    "1000000" => "012",
    "1500000" => "014",
    "2000000" => "016",
    "2500000" => "018",
    "5000000" => "020",
    "6000000" => "022"
);
$WEBSUMINSURED = array(
    "200000" => "1",
    "300000" => "2",
    "400000" => "3",
    "500000" => "4",
    "700000" => "5",
    "1000000" => "6",
    "1500000" => "7",
    "2000000" => "8",
    "2500000" => "9",
    "5000000" => "10",
    "6000000" => "11"
);
$WEBSUMINSURED1 = array(
    "1" => "200000",
    "2" => "300000",
    "3" => "400000",
    "4" => "500000",
    "5" => "700000",
    "6" => "1000000",
    "7" => "1500000",
    "8" => "2000000",
    "9" => "2500000",
    "10" => "5000000",
    "11" => "6000000"
);
$RHDFCSUMINSURED = array(
    "300000" => "1",
    "500000" => "2"
);
$IIB_INDIVIDUAL = array(
    "250000" => "001",
    "400000" => "003",
    "600000" => "005",
    "800000" => "007"
);
$IIB_FAMILYFLOATER = array(
    "250000" => "002",
    "400000" => "004",
    "600000" => "006",
    "800000" => "008"
);
$TRAVELPLAN = array(
	"1" => "Asia",
        "2" => "Africa",
	"3" => "Europe",
	"4" => "Canada",	
	"5" => "Worldwide",
	"6" => "WW-Excl. US / Canada",
	
);
$metaTitleForInner = "Religare Health Insurance India, Buy Medical Insurance Policies online";
$metaDescriptionForInner = "Buy Religare health insurance policy online in 2 mins. Medical insurance plan with industry leading features.";
$metaKeywordsForInner = "health insurance India, medical insurance India, buy health insurance policy, compare health insurance plans, buy insurance online, health insurance company";
//include_once("csrf-magic.php");https://uattractus.religarehealthinsurance.com/
$tractus = "https://uattractus.religarehealthinsurance.com";
?>