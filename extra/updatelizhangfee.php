<?php
# embedded in xml/hss_lizhang_shouzhitbl.xml

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
        $sql = "update hss_lizhangtbl set zongshouru='".$totalnum."' ";
    }else{
        $sql = "update hss_lizhangtbl set zongzhichu='".$totalnum."' ";
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

//餐厅，景点，做例子。
//餐厅分为现金已付 canxianfu ，简称现付。单据付款，canqiandan 简称签单。
//门票现付字段           menpiaoxianfu                  门票签单字段：                      menpiaoqiandan

?>
