<?php
    include_once("conf/session.php");
    $formData   = array();
    $createdOn = strtotime(date('Y-m-d H:i:s', time()));
    
    $formData['travellingTo'] = @$_POST['travellingTo'];
    $formData['tripType'] = @$_POST['tripType'];
    $formData['maximumtrip'] = @$_POST['maximumtrip'];
    
    $formData['startDate'] = @$_POST['startDate'];
    $formData['endDate'] = @$_POST['endDate'];
    $formData['noday'] = @$_POST['noday'];
    $formData['noOfTravellers'] = @$_POST['noOfTravellers'];
    $formData['eachmember'] = @$_POST['eachmember'];
    $formData['mobilenotr'] = @$_POST['mobilenotr'];
    $formData['checkmobile'] = @$_POST['checkmobile'];
    $formData['pedQuestion'] = @$_POST['pedQuestion'];
    $formData['premiumamount'] = @$_POST['premiumamount'];
    

/*    
    if(@$_POST['travelPremiumdata'] || @$_POST['travelPremiumgolddata'] || @$_POST['travelPremiumpletinumdata'])
    {
        if(!@$_POST['goldplan'][0] && !@$_POST['travelPremiumgolddata'])
        {
            $travelPremium = @$_POST['travelPremiumdata'];
            $formData['travelPremiumdata'] = $travelPremium;
        }
        else if(@$_POST['goldplan'][0] == 'gold')
        {
            $travelPremium = @$_POST['travelPremiumgolddata'];
            $formData['travelPremiumgolddata'] = $travelPremium;
        }
        else if(@$_POST['goldplan'][0] == 'pletinum')
        {
            $travelPremium = @$_POST['travelPremiumpletinumdata'];
            $formData['travelPremiumpletinumdata'] = $travelPremium;
        }        
    }
  */
    $travelPremium = @$_POST['premiumamount'];
    if(@$_POST['travelPremType'] == 'undefined')
    {
            $formData['travelPremium'] = $travelPremium;
    }
    else if(@$_POST['travelPremType'] == 'gold')
    {
            $formData['travelPremiumgold'] = $travelPremium;            
    }
    else if(@$_POST['travelPremType'] == 'pletinum')
    {            
            $formData['travelPremiumpletinum'] = $travelPremium;
    }
    
    $travelPremium = preg_replace('/,/', '', @$travelPremium);
    
    if(is_float(@$travelPremium) || is_numeric(@$travelPremium))
    {   
        if(@$_SESSION['UTL'])
        {
            $utl = $_SESSION['UTL'];
        }
        else
        {
            $utl = $_SESSION['UTL'] = time();
        }
        //$transdetail = serialize($formData);
        $transdetail = json_encode($formData);
        
        $statusValue = (@$_POST['formtype'] == 'loginquotation') ? 2 : 1;
        $countQuery ="SELECT COUNT(*) FROM ATAGENTTRANSACTION WHERE AGENTUTL=" .$utl. " AND STATUS=".$statusValue;
        
        global $sdbc;
        $countSql = @oci_parse($sdbc, $countQuery);
        $result   = @oci_execute($countSql);

        $row = oci_fetch_row($countSql);
        if($row[0])
        {            
            $sql = "UPDATE ATAGENTTRANSACTION SET STATUS=1, TRANSDETAIL='". $transdetail ."', UPDATEDON=". $createdOn .", TRANSTYPE='". @$_POST['formtype'] ."' WHERE AGENTUTL=". $utl ." AND STATUS =1";     
        }
        else
        {
            $sql = "INSERT INTO ATAGENTTRANSACTION (ID, AGENTUTL, TRANSTYPE, TRANSDETAIL, STATUS, CREATEDON, UPDATEDON) values
                    (ATAGENTTRANSACTION_SEQ.nextval, ". $utl . ", '".@$_POST['formtype']. "', '" . $transdetail . "', 2, ". $createdOn .", " . $createdOn. ")";    
        }
        $stdid = @oci_parse($sdbc, $sql);	
        oci_execute($stdid)  or die(print_r(oci_error($stdid)));
        //$_SESSION['agentbalance']
    
        if(@$_SESSION['loginstatus'])
        {
            if($travelPremium <= $_SESSION['agentbalance'])
            {
                echo 'successagentbalance';	
            }
            else
            {
                echo 'errorlessagentbalance';
            }
        }
        else
        {
            echo 'errorlogin';
        }
    exit;
}

?>