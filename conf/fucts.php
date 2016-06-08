<?php
function sanitize_data($input_data) {
	$searchArr=array("document","write","alert","%","$",";","+","|","#","<",">",")","(","'","\'",",","<img","src=",".ini","<iframe","java:","window.open","http","!",":boot",".com",".exe",".php",".js",".txt","@",".css");	
	$input_data	= 	str_replace("script","",$input_data);
	$input_data	= 	str_replace("iframe","",$input_data);
	$input_data	= 	str_replace($searchArr,"",$input_data);
	$input_data	=	trim($input_data);
	$input_data	= 	strip_tags($input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
function sanitize_email($input_data) {
	$searchArr=array("document","write","alert","%","$",";","+","|","#","<",">",")","(","'","\'",",","<img","src=",".ini","<iframe","java:","window.open","http","!",":boot",".exe",".php",".js",".txt",".css");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
	$input_data=trim($input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}
function sanitize_without_comma($input_data) {
	$searchArr=array("document","write","alert","%","$",";","+","|","#","<",">",")","(","'","\'","<img","src=",".ini","<iframe","java:","window.open","http","!",":boot",".com",".exe",".php",".js",".txt","@",".css");	
	$input_data	= 	str_replace("script","",$input_data);
	$input_data	= 	str_replace("iframe","",$input_data);
	$input_data	= 	str_replace($searchArr,"",$input_data);
	$input_data	=	trim($input_data);
	$input_data	= 	strip_tags($input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function sanitize_password($input_data) {
	$searchArr=array("document","write","alert",";","+","|","#","<",">",")","(","'","\'",",","<img","src=",".ini","<iframe","java:","window.open","http","!",":boot",".exe",".php",".js",".txt",".css");
	$input_data= str_replace("script","",$input_data);
	$input_data= str_replace("iframe","",$input_data);
	$input_data= str_replace($searchArr,"",$input_data);
	$input_data=trim($input_data);
    return htmlentities(stripslashes($input_data), ENT_QUOTES);
}

function dateChange($date){
	if($date!="00000000"){
	return substr(@$date,6,2).'-'.substr(@$date,4,2).'-'.substr(@$date,0,4);
	}else{
	return '';
	}
        
}
function fetchcolumnListCond($col,$table,$cond){
	global $conn;
	$dataArray=array();
		$query="SELECT $col FROM $table $cond";
		$sql = @oci_parse($conn, $query);
		// Execute Query
		@oci_execute($sql);
		$i=0;
		while (($row = oci_fetch_assoc($sql))) {
			foreach($row as $key=>$value){
				$dataArray[$i][$key] = $value;				
			}
			$i++;
		}
	return $dataArray;
}

function fetchListCond($table,$cond){
	global $conn;
	$dataArray=array();
		$query="SELECT * FROM $table $cond";
		$sql = @oci_parse($conn, $query);
		// Execute Query
		@oci_execute($sql);
		$i=0;
		while(($row = oci_fetch_array($sql))) {
			foreach($row as $key=>$value){
				$dataArray[$i][$key] = $value;				
			}
			$i++;
		}
	return $dataArray;
}

function fetchListCondPagination($qyery){
	global $conn;
	$dataArray=array(); 
	$query=@$qyery;
		$sql = @oci_parse($conn, $query);
		//Execute Query
		@oci_execute($sql);
		$i=0;
		while (($row = oci_fetch_assoc($sql))) {
			foreach($row as $key=>$value){
				$dataArray[$i][$key] = $value;				
			}
			$i++;
		}
	return $dataArray;
}
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'baljeetpoonia_se';
    $secret_iv 	= 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
   
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function isNumeric($numeric) {
	if(trim($numeric)=='') {	$result = 'no';	}
	$var = preg_match("/^[0-9]+$/", trim($numeric));
	if($var==1){ $result = 'yes'; } else {
		$result = 'no';
		//header('Location: index.php?message=Invalid request');	
	}
	return $result; 
}

function isVarChar($varchar) {
	if(trim($varchar)=='') {	$result = 'no';	}
	$var = preg_match('/^[a-zA-Z]+$/',trim($varchar));	
	if($var==1){	$result = 'yes'; 	} else {
		//header('Location: index.php?message=Invalid request');
		$result = 'no';
	}
	return $result; 
}
?>