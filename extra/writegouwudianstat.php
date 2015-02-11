<?php
# embeded in xml/hss_fin_gouwudiantbl, write stat data when modifying
# wadelau@ufqi.com, Mon Jun 25 22:18:59 CST 2012

$targettbl = 'hss_stat_gouwudiantbl';
$targetMingCheng = 'gouwudianid';
$datafields = array('tuanid'=>'tuanid',
        'zongrenshu'=>'zongrenshu',
        'rentoushouru'=>'rentoushouru',
        'liushuishouru'=>'liushuishouru'
        );
$sumfields = array('zongshouru'=>'rentoushouru+liushuishouru');

if(1){
    $riqi = $_REQUEST['riqi'];
    $time = strtotime($riqi);
    if($time > 0){
        $thedate = $riqi;
        if($act == 'list-dodelete'){
            $sql = "delete from ".$targettbl." where thedate='".$thedate."' and ".$targetMingCheng."='".$_REQUEST['gouwudianmingcheng']."'"; 
        }else{
            $sql = "replace into ".$targettbl." set thedate='".$thedate."', ".$targetMingCheng."='".$_REQUEST['gouwudianmingcheng']."'";
            /*
            $sql .= ", tuanid='".$_REQUEST['tuanid']."'";
            $sql .= ", zongrenshu='".$_REQUEST['zongrenshu']."'";
            $sql .= ", rentoushouru='".$_REQUEST['rentoushouru']."'";
            $sql .= ", liushuishouru='".$_REQUEST['liushuishouru']."'";
            */
            foreach($datafields as $k=>$v){
                $sql .= ", ".$k."='".$_REQUEST[$v]."'";
            }

            foreach($sumfields as $k=>$v){
                $sql .= ", ".$k."=".$v;
            }
        }
        $gtbl->execBy($sql, null);
        error_log(__FILE__.": riqi:$riqi, now:".date("Y-m-d",$time).", sql:[".$sql."]");
    }else{
    
        error_log(__FILE__.": TRIGGER with wrong riqi:$riqi, now:".date("Y-m-d",$time).", sql:[".$sql."]");
    }
}

?>
