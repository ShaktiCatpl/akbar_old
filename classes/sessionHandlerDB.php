<?php
class SessionHandlerDb{ 
    private static $lifetime = 0; 
	public $sdbc=null;
    function __construct() //object constructor
    { 
	
        global $sdbc;
        
        /*
	  $db_hostName="10.216.9.197"; //defined host name
	  $db_hostPort="1521"; //defined host name
	  $db_serviceName="orcl"; //defined db name
	  $db_username="rhicl";  // define db username
	  $db_password="rhicl"; // define db password
         
         */
        
        
         $db_hostName="172.16.0.143"; //defined host name
	  $db_hostPort="1521"; //defined host name
	  $db_serviceName="orcl"; //defined db name
	  $db_username="system";  // define db username
	  $db_password="admin";
        
	 
	 // Connection  string with Oracle
	  $sdbc=@oci_connect("$db_username","$db_password","(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
            (HOST=".$db_hostName.")(PORT=".$db_hostPort."))
            (CONNECT_DATA=(SERVICE_NAME=".$db_serviceName.")))") or header("Location: sitedown.php");	
	
       session_set_save_handler(
           array($this,'open'),
           array($this,'close'),
           array($this,'read'),
           array($this,'write'),
           array($this,'destroy'),
           array($this,'gc')
       );
    }

   public function start($session_name = null)
   {
       session_start($session_name);  //Start it here
   }

    public static function open()
    {
		 global $sdbc;
		return true;
    }

    public static function read($id)
    {
		 global $sdbc;
			$query="SELECT DATA
		FROM CRMEMPLOPYEESESSION
		WHERE id = '$id'"; 
			$sql = @oci_parse($sdbc, $query);
			// Execute Query
			$result = @oci_execute($sql);
		if(isset($result) && !empty($result)){
			$row=oci_fetch_row(@$sql);
			return $row[0]?$row[0]->load():'';
		} else {
			return '';	
		}
        //Get data from DB with id = $id;
    }

    public static function write($id, $data)
    {
		 global $sdbc;
	$CurrentTime = time();
		 $query="SELECT * FROM CRMEMPLOPYEESESSION WHERE ID='".$id."'";  
		$sql = @oci_parse($sdbc, $query);
		$result = @oci_execute($sql);
		$row=oci_fetch_assoc(@$sql);
		$access = time();
		if(count($row) > 0){
			
			$delquery = "DELETE FROM CRMEMPLOPYEESESSION WHERE ID='".$id."'";
	   			$stdid = @oci_parse($sdbc, $delquery);					//query to update records
				$r = @oci_execute($stdid);
				
			  $insquery = "INSERT INTO CRMEMPLOPYEESESSION (ID,ACCESSTIME,DATA) values ('".$id."','".$access."',:datas)";
	   			$stdid2 = @oci_parse($sdbc, $insquery);		
				oci_bind_by_name($stdid2, ':datas', $data);
			//query to update records
			
				$r2 = @oci_execute($stdid2)  or die(print_r(oci_error($stdid2)));
				
		} else {
			  $insquery = "INSERT INTO CRMEMPLOPYEESESSION (ID,ACCESSTIME,DATA) values ('".$id."','".$access."',:datas)";
	   			$stdid2 = @oci_parse($sdbc, $insquery);		
				oci_bind_by_name($stdid2, ':datas', $data);
			//query to update records
			
				$r2 = @oci_execute($stdid2)  or die(print_r(oci_error($stdid2)));
		
		}
//echo $data;
//echo $insquery;
	//echo mysql_affected_rows(); 
		return 1; 
    }

    public static function destroy($id)
    {
       global $sdbc;
	$q="delete from CRMEMPLOPYEESESSION where id='".$id."'";
		$sql = @oci_parse($sdbc, $q);
		// Execute Query
		$result = @oci_execute($sql) ;
	//return mysql_query($sdbc, $q);
    }

    public static function gc()
    {
        return true;
    }
    public static function close()
    {
        global $sdbc;
	
		return true;
    }
    public function __destruct()
    {
        session_write_close();
    }
}?>