<?php

# update hss_xingchengtbl when list items from this table 
# Wed Feb 22 20:06:07 CST 2012

$tuanid = $_REQUEST['tuanduiid'];
if($tuanid == ''){
    $tuanid = $_REQUEST['pnsktuanduiid'];
}

#print_r($_REQUEST);

$xingchengtbl = "hss_xingchengtbl";
$tuanduitbl = "hss_tuanduitbl";

# read total records of xingcheng
$xingchengdatearr = array();
$hm = $gtbl->getBy("id,xingchengdate", "tuanduiid='$tuanid'");
if($hm[0]){
    $hm = $hm[1];
    foreach($hm as $k=>$v){
        $xingchengdatearr[$v['id']] = $v['xingchengdate'];
    }
}
# read date span from tuantuitbl
$oldhmf = $gtbl->hmf;
$chufadida = 0;
$fanchriqi = 0;
$dayseconds = 86400;
$gtbl->setTbl($tuanduitbl);
$hm = $gtbl->getBy("chufadida,fanchriqi","id='$tuanid'");
if($hm[0]){
    $hm = $hm[1][0];
    $chufadida = strtotime($hm['chufadida']);
    $fanchriqi = strtotime($hm['fanchriqi']);
}
$gtbl->hmf = $oldhmf;

if($chufadida == 0 || $fanchriqi == 0){
    $out .= __FILE__.": found error. chufadida:[".$chufadida."] or fanchriqi:[".$fanchriqi."] is zero with tuanduiid:[$tuanid]!\n";
}else{
    if($fanchriqi == $chufadida){
        $fanchriqi = $chufadida + 1;
    }
   $days = floor(($fanchriqi - $chufadida) / $dayseconds);
   if($days == 0){
        $days = 1;
   }
    if(count($xingchengdatearr) < $days){
       $out .= "need more xingchengdate";
       for($i=$chufadida; $i<=$fanchriqi; $i+=$dayseconds){
           $date = date("Y-m-d",$i);
           if(in_array($date, $xingchengdatearr)){
                $out .= __FILE___.": date:[$date] exists with tuanduiid:[$tuanid]\n"; 
           }else{
               $gtbl->set("tuanduiid",$tuanid);
               $gtbl->set("xingchengdate",$date);
               $gtbl->setBy("xingchengdate, tuanduiid", null);
               $out .= __FILE__.": insert date:[$date] with tuanduiid:[$tuanid]\n";
           } 
       }
    }else{
        #print_r($xingchengdatearr);
    }
}

?>
