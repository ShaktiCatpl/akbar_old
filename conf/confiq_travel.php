<?php 
	$mysql_server	= "10.216.6.59";
	$mysql_uesrname	= "root";
	$mysql_password="0kwp6aNR";
	$mysql_dbname="travel";	  
        mysql_connect($mysql_server,$mysql_uesrname,$mysql_password) or die("cannot connect to database");
	mysql_select_db($mysql_dbname) or die("cannot select database");
        
	/* function sanitize_data($input_data) {
	$searchArr=array("document","write","alert","%","$",";","+","|","#","<",">",")","(","'","\'",",");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
        return htmlentities(stripslashes($input_data), ENT_QUOTES);
	} */
        
        function sanitize_data_travel($input_data) {
	$searchArr=array("document","write","alert","%",";","+","|","#","<",">",")","(","'","\'");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
      

?>
