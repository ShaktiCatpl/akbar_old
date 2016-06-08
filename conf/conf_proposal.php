<?php   
	/*$db_hostName="172.16.0.120"; //defined host name
	$db_hostPort="1521"; //defined host name
	$db_serviceName="religare"; *///defined db name
	$db_hostName="10.216.6.27"; //defined host name
	$db_hostPort="1521"; //defined host name
	$db_serviceName="orcl"; //defined db name
	$db_username="rhicl";  // define db username
	$db_password="rhicl"; // define db password
	// Connection  string with Oracle
	$conn=@oci_connect("$db_username","$db_password","(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
		(HOST=".$db_hostName.")(PORT=".$db_hostPort."))
		(CONNECT_DATA=(SERVICE_NAME=".$db_serviceName.")))") or die("cannot connect to database");
	@$mandatory_field="<span class=\"redtxt\">*</span>"; // Define mandatory_field
	/*define('URL','localhost/');
	define('IMG_URL','../../fileupload/');
	define('APIURLPATH','../api/api.php');*/
	ob_start();
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
	$footerurl	=	"http://rhicluat.religare.com/religare";
?>