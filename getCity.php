<?php
require_once 'inc/conf.php';
$pincode = sanitize_data(@$_REQUEST['pincode']);
$condition = " PINDCODE = $pincode";
$result=fetchListByPinCode("TBL_PINCODE",$condition);
function unique_sort($arrs, $id,$sid) {
    $unique_arr = array();
    $unique_arr1 = array();
    $h=0;
    foreach ($arrs AS $arr) {

        if (!in_array($arr[$id], $unique_arr1)) {
            $unique_arr1[] = $arr[$id];
            $unique_arr[$h][$id] = $arr[$id];
            $unique_arr[$h][$sid] = $arr[$sid];
        }
  $h++;  }
    return $unique_arr;
}
if(!empty($result)) {
$result1 =array(0=>array("CITY"=>"Select City"));

$result = array_merge($result1, $result);

echo json_encode($result);
} else {
   $array = array(0=>array("STATE"=>"error"));
echo json_encode($array);
}
?>
