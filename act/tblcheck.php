<?php

# do some action defined in table::check tag in xxxx.xml
$checkactions = $gtbl->getTblCHK();
if(count($checkactions) > 0){
    foreach($checkactions as $chkact=>$do){
        if($chkact == $act){
            #$out .= __FILE__.": found preset checkaction:[".$do."]\n";
            include($appdir."/".$do);
        }
    }
}

# manage mode check
$mode = $gtbl->getMode();
if($mode != ''){
    $act2mode = array('add'=>'w',
            'list-addform'=>'w',
            'modify'=>'w',
            'updatefield'=>'w',
            'list'=>'r',
            'list-toexcel'=>'r',
            'view'=>'r',
            'list-dodelete'=>'d',
            );
    $modechar = $act2mode[$act];
    if(!isset($modechar)){
        error_log(__FILE__.": unknown act:[$act] in act2mode.201202282117");
    }else{
        if(strpos($mode, $modechar) === false){
            $out .= "act:[$act] is not allowed in mode:[$mode]. 201202282143\n";
            $out .= "<br/><br/> <a href='./ido.php?tbl=hss_fin_managemodetbl&pnskparenttype=".$tbl."&pnskparentid=".$id."&pnsm=1' target=\"_top\">申请变更</a> ";
            print $out;
            exit(0);
        }else{
            #$out .= "act:[$act] is ready.\n";
        }
    }
}

?>
