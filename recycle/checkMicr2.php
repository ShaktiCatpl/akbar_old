<?php 
require_once 'inc/conf.php';
$micr = sanitize_data('636026002');
$data = fetchListByMicr('MICRBANKMAP_VIEW',$micr);
$data1 = fetchAllMicrData('MICRBANKMAP_VIEW');
echo '<pre>';
print_r($data1); 
?>