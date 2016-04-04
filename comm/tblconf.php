<?php
# be part of /jdo.php

$isadmin = false;
$hlcolor = '#afc4e2'; $form_cols = 6; $hashiddenfield = false;

$hmconf = GTbl::xml2hash($xmlpathpre, $elementsep, $db, $tbl);
$gtbl = new GTbl($tbl, $hmconf[0], $elementsep, $tblrotate);
$hmfield = $hmfieldsort = array();
$hmfieldsortinxml = $hmconf[1];

$sql = "desc $tbl";
$hm = $gtbl->execBy($sql, null);
$max_idx = $hmi = 99; # max number of fields count
$min_idx = 0; $dispi = 0; $max_disp_cols = $gtbl->getListFieldCount(); # display field count
$hasid = false; $hmj = count($hmfieldsortinxml); #1; remedy Sun Jul 22 22:26:09 CST 2012
if($hm[0]){
    $hm = $hm[1];
    foreach($hm as $k=>$v){
        $field = $v['Field'];
        $fieldv = "fieldtype=".$v['Type'];
        if(strtolower($field)=='id'){
            $field = strtolower($field);
        }
        else if(strtolower($field) == 'name' || strtolower($field) == 'type'){
            print __FILE__.": field:[".$field."] in tbl:[".$tbl."]. It's bad idea to name a field as 'name' or 'type'. plz change it to xxxname or namexxx.\n";
        }
        $hmfield[$field] = $fieldv;
        $hmfield[$field."_default"] = $v['Default'];
        $tmpsort = $hmfieldsortinxml[$field];
        if($tmpsort == null || $tmpsort == ''){ 
            $tmpsort = $hmj++; # $hmi; # remedy on Wed Jul 11 18:57:32 CST 2012
            $hmi--;
        }
        $hmfieldsort[$tmpsort] = $field;
        $min_index = $tmpsort;
        if(!$hasid && $field == 'id'){
            $hasid = true;
        }
    }
}
#print_r($hmfield);
#print_r($hmfieldsort);

$hmsize = count($hmfield) + 1;
$gtbl->setFieldSort($hmfieldsort, $hmsize, $hmi);
$gtbl->setFieldList($hmfield);

$opfield = array('operator','author','op','creator','operatorid', 'authorid', 'creatorid');
$timefield = array('inserttime','insertime','updatetime','endtime','editime','edittime','modifytime');


?>
