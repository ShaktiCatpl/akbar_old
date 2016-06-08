<?php 
require_once 'inc/conf.php';
$micr = sanitize_data(@$_REQUEST['micr']);
$data = fetchListByMicr('MICRBANKMAP_VIEW',$micr);
echo $data[0]['BANKNAME'].':'.$data[0]['BANKBRANCH'];exit;
?>