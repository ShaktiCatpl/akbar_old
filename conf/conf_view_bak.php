<?php   
	  $db_hostName="10.216.6.27"; //defined host name
	  $db_hostPort="1521"; //defined host name
	  $db_serviceName="rhprod"; //defined db name
	  $db_username="c2lbizprod";  // define db username
	  $db_password="reli123"; // define db password 
	// Connection  string with Oracle
	$conn=@oci_connect("$db_username","$db_password","(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
		(HOST=".$db_hostName.")(PORT=".$db_hostPort."))
		(CONNECT_DATA=(SERVICE_NAME=".$db_serviceName.")))") or die("cannot connect to database");
	@$mandatory_field="<span class=\"redtxt\">*</span>"; // Define mandatory_field
	define('URL','localhost/');
	define('IMG_URL','../../fileupload/');
	define('APIURLPATH','../api/api.php');
	ob_start();
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
	$RMARR = array(
		"1" => "Agency Manager",
		"2" => "Agency Trainee",
		"3" => "Sr Agency Manager",
	);
	$SMARR = array(
		"1" => "Manager-Online Sales",
		"2" => "Sales Manager",
		"3" => "Sales Manager–Travel",
		"4" => "Sales Trainee",
		"5" => "Sr Manager–Bancassurance",
		"6" => "Sr Sales Manager–Travel",
	);
?>