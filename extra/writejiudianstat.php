<?php
#embeded in xml/hss_fin_jiudiantbl, write stat data when modifying

if(1){
    $ruzhuriqi = $_REQUEST['ruzhuriqi'];
    $tuiliriqi = $_REQUEST['tuiliriqi'];
    $time = strtotime($ruzhuriqi);
    $tuilitime = strtotime($tuiliriqi);
    error_log(__FILE__.": ruzhuriqi:$ruzhuriqi, tuiliriqi:$tuiliriqi, now:".date($time));
    while($time < $tuilitime){
        $time += 86400; # 86400, a single day's seconds
        $thedate = date("Y-m-d", $time);
        if($act == 'list-dodelete'){
            $sql = "delete from hss_stat_jiudiantbl where thedate='".$thedate."' and jiudianid='".$_REQUEST['mingcheng']."'"; 
        }else{
            $sql = "replace into hss_stat_jiudiantbl set thedate='".$thedate."',jiudianid='".$_REQUEST['mingcheng']."'";
            $sql .= ", tuanid='".$_REQUEST['tuanid']."'";
            $sql .= ", biaojianjia='".$_REQUEST['biaojianjia']."'";
            $sql .= ", biaojianshu='".$_REQUEST['biaojianshu']."'";
            $sql .= ", biaojiankuan=biaojianjia*biaojianshu";
            $sql .= ", haohuafangjia='".$_REQUEST['haohuafangjia']."'";
            $sql .= ", haohuafangshu='".$_REQUEST['haohuafangshu']."'";
            $sql .= ", haohuafangkuan=haohuafangjia*haohuafangshu";
            $sql .= ", dachuangjia='".$_REQUEST['dachuangjia']."'";
            $sql .= ", dachuangshu='".$_REQUEST['dachuangshu']."'";
            $sql .= ", dachuangkuan=dachuangjia*dachuangshu";
            $sql .= ", zongkuan='".$_REQUEST['zongzhichu']."'";
        }
        $gtbl->execBy($sql, null);
        error_log(__FILE__.": ruzuriqi:$ruzhuriqi, tuiliriqi:$tuiliriqi, now:".date("Y-m-d",$time).", sql:[".$sql."]");
    }
}

?>
