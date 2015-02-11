<?php
# embedded in xml/hss_fin_jingdiantbl.xml
# added on Sat Jun  2 15:25:13 CST 2012 by wadelau@ufqi.com

if(1){

$totalnum = 0;
$mytuanid = $_REQUEST['tuanid'];
if($mytuanid == ''){
    $mytuanid = $_REQUEST['pnsktuanid'];
}

$myfromtbl = "hss_fin_jingdiantbl"; # 源数据表
$mytypename = "leixing"; # 源数据表里的类型字段名称
$myzongshu = "zongzhichu"; # 在源数据表里的总额字段名称
$mytotbl = "hss_lizhangtbl"; # 目标数据表
$tofield0 = "menpiaoxianfu"; # 目标数据表类型0时的字段名
$tofield1 = "menpiaoqiandan"; # 目标数据表类型1时的字段名

$mytype = $_REQUEST[$mytypename];
if(!isset($mytype)){
    $mytype = $hmorig[$mytypename];
}

$sql = "select sum($myzongshu) as totalnum from $myfromtbl where $mytypename='".$mytype."' and tuanid='".$mytuanid."'";
$tmphm = $gtbl->execBy($sql, null);
if($tmphm[0]){
    $tmphm = $tmphm[1];
    $totalnum = $tmphm[0]['totalnum'];
    if($mytype == 0){
        $sql = "update $mytotbl set $tofield0 = '".$totalnum."' ";
    }else{
        $sql = "update $mytotbl set $tofield1='".$totalnum."' ";
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
