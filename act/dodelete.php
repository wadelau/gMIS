<?php
# do delete for act=list-dodelete, Fri Apr  6 20:46:13 CST 2012

$Max_Allow_Count_Delete = 999;

$fieldlist = array();
if(!isset($fieldargv) || !is_array($fieldargv)){ $fieldargv = array(); }

if($hasid){
    $gtbl->setId($id);
    $tmpVal = $gtbl->getMyId()."=?";
    $fieldargv[] = $tmpVal;
}
else{
    #$fieldargv = "";
    for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){
        $field = $gtbl->getField($hmi);
        if($field == null | $field == '' 
                || $field == $gtbl->getMyId()){
            continue;
        }
        if(array_key_exists($field, $_REQUEST)){
            $gtbl->set($field, $_REQUEST[$field]);
            $fieldargv[] = $field."=?";
        }

        $fieldlist[] = $field;
    } 
}
$hmorig = $gtbl->getBy("*", implode(" and ", $fieldargv));
if($hmorig[0]){
    $hmorig = $hmorig[1][0]; # the first row
}

include("./act/checkconsistence.php");
//- allow deletion
$hm = $gtbl->rmBy(implode(" and ", $fieldargv));
#print_r(__FILE__.": delete:[".$hm."]\n");

$doDeleteResult = true;

# some triggers bgn, added on Sat May 26 10:22:14 CST 2012
include("./act/trigger.php");
# some triggers end, added on Sat May 26 10:22:27 CST 2012

//- check linktbl, Tue Jul  6 15:50:34 CST 2021
if(true){
    for($hmi=$min_idx; $hmi<=$max_idx;$hmi++){
        $field = $gtbl->getField($hmi);
        $fieldInputType = $gtbl->getInputType($field); $hasDefaultVal = 0;
        $extraInput = $gtbl->getExtraInput($field, $hmorig);
        
        if($field == null || $field == ''){
            continue;
        }   
        else if($extraInput != ''){
            if(inString('extra/linktbl.php', $extraInput)){
                $paramArr = explode('&', substr($extraInput, strpos($extraInput, '?')));
                $linkTbl = ''; $linkField = ''; $tmpArr = array();
                foreach($paramArr as $k=>$v){
                    if(inString('tbl=', $v)){
                        $tmpArr = explode('=', $v);
                        $linkTbl = $tmpArr[1];
                    }
                    else if(inString('linkfield=', $v)){
                        $tmpArr = explode('=', $v);
                        $linkField = $tmpArr[1];
                    }
                }
                if($linkTbl != '' && $linkField != ''){
                    $linkId = $hmorig['id']; # assume hasId?
                    $tmpSql = "delete from $linkTbl where $linkField=$linkId limit $Max_Allow_Count_Delete";
                    $hmResult = $gtbl->execBy($tmpSql, null, null);
                    debug("act/dodelete: linktbl: sql:[$tmpSql] result:".serialize($hmResult));
                }
            }
            #debug("act/dodelete: field:$field input:$fieldInputType extraInput:$extraInput linktbl:$linkTbl linkfield:$linkField params:".serialize($paramArr)." hmorig:".serialize($hmorig));
        }
    }
}

//- clean
$gtbl->setId('');
$_REQUEST[$gtbl->getMyId().'.old'] = $_REQUEST[$gtbl->getMyId()];
$_REQUEST[$gtbl->getMyId()] = ''; # remedy Thu Apr 17 08:41:11 CST 2014
$id = '';

//- resp
if($hm[0] && $doDeleteResult){
    $out .= "<script> parent.sendNotice(true, '".$lang->get('notice_success')."'); parent.switchArea('contentarea_outer','off'); </script>";
}
else{
	if(!$doDeleteResult){
		$out .= "<script> parent.sendNotice(false, '".$lang->get('notice_success').".".$out."');</script>";
	}
	else{
		$out .= "<script> parent.sendNotice(false, '".$lang->get('notice_success')."');</script>";
		$deleteErrCode = '201811241202';
	}
}

?>