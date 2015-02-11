<?php
# embedded in xml/hss_tuandui_shouzhitbl.xml

if(1){

$totalnum = 0;
$mytuanid = $_REQUEST['tuanid'];
if($mytuanid == ''){
    $mytuanid = $_REQUEST['pnsktuanid'];
}
$shouzhi = $_REQUEST['shouzhi'];
if(!isset($shouzhi)){
    $shouzhi = $hmorig['shouzhi'];
}
$sql = "select sum(zongjia) as totalnum from hss_tuandui_shouzhitbl where shouzhi='".$shouzhi."' and tuanid='".$mytuanid."'";
$tmphm = $gtbl->execBy($sql, null);
if($tmphm[0]){
    $tmphm = $tmphm[1];
    $totalnum = $tmphm[0]['totalnum'];
    if($shouzhi == 0){
        $sql = "update hss_tuanduitbl set zongshouru='".$totalnum."' ";
    }else{
        $sql = "update hss_tuanduitbl set zongzhichu='".$totalnum."' ";
    }
    $sql .= " where id='".$mytuanid."' limit 1";
    $tmphm = $gtbl->execBy($sql, null);
    print_r($tmphm);
    if($tmphm[0]){
        //-- succ
        error_log(__FILE__.": FoundSucc: sql:[$sql] tmphm:[".$gtbl->toString($tmphm)."]");
    }else{
        error_log(__FILE__.": FoundError: sql:[$sql] tmphm:[".$gtbl->toString($tmphm)."]");
    }
}

}

?>
