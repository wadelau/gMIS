<?php
# print out a table, fields may come from mutiple tables
# added by Wadelau, on Sat Feb  4 13:18:25 CST 2012

$smttpl = substr($smttpl,0,strlen($smttpl)-5)."_".$tbl.".html";
if(1 && is_file($viewdir."/".$smttpl)){
    $out .= __FILE__.": smttpl:[".$smttpl."]\n";
}else{
    #$out .= "没有指定打印模板，使用默认模板. ".$viewdir."/".$smttpl."\n";
    $smttpl = '';
}

$data = array(); # 用于打印模板的数据集

$out .= "<div align=\"center\"><h2>".$_CONFIG['agentname'].$gtbl->getTblCHN()."</h2>";
$data['title'] = $_CONFIG['agentname'].$gtbl->getTblCHN();
$data['id'] = $id;

$hmorig = array();
if($hasid){
    $gtbl->setId($id);
    $hmorig = $gtbl->getBy("*", null);
    $gtbl->setId('');
}else{
    $fieldargv = "";
    for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){
        $field = $gtbl->getField($hmi);
        if($field == null | $field == '' 
                || $field == 'id'){
            continue;
        }
        if(array_key_exists($field, $_REQUEST)){
            $gtbl->set($field, $_REQUEST[$field]);
            $fieldargv[] = $field."=?";
        }
    } 
    $hmorig = $gtbl->getBy("*", implode(" and ", $fieldargv));
}
if($hmorig[0]){
    $hmorig = $hmorig[1][0]; 
}

$data['hmorig'] = $hmorig;

$printref = $gtbl->getPrintRef(0);
if($printref != ''){
    $refarr = explode("|",$printref);
    foreach($refarr as $k=>$ref){
        $refdetail = explode(":",$refarr[$k]);
        $linkinfo = explode("=", $refdetail[1]); $rdnum = rand(0,9999);
        $out .= "\n<span id=\"linkinfo_".$rdnum."\"></span><script type=\"text/javascript\"> doActionEx('./act/readfield.php?tbl=".$refdetail[0]."&pnsk".$linkinfo[0]."=".$hmorig[$linkinfo[1]]."&pnob".$linkinfo[0]."=1&fieldlist=".$refdetail[2]."&isheader=0&isoput=0','linkinfo_".$rdnum."');</script><br/>\n";
    }
}
//$out .= "<style>table.printtbl{} table.printtbl td{padding:5px;vertical-align:middle;border-right:1px dotted green;border-bottom:1px dotted green;} </style>";
$out .= "<table align=\"center\" width=\"800px\" cellspacing=\"0\" cellpadding=\"0\" border=\"0px\" class=\"printtbl\">";

$out .= "<tr height=\"30\" valign=\"middle\"  onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\">";
$lastclosed = 0;

for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){

    $field = $gtbl->getField($hmi);
	$fieldv = $hmorig[$field];
    $nextfield = $gtbl->getField($hmi+1);
    $fieldinputtype = $gtbl->getInputType($field);
    $nextfieldinputtype = $gtbl->getInputType($nextfield);
    if($field == null || $field == ''
            || $field == 'id'){

        continue;
    } 
    $hasclosed = 0;
    $needcloserow = 0;

    if($field == 'password'){
        $hmorig[$field] = '';
    }

    if(!$user->canRead($field, '', '', $_REQUEST['id'], $id)){
        $out .= "<--NOREAD-->";

    }else if($fieldinputtype == 'select'){
        $out .= "<td>".$gtbl->getCHN($field).":&nbsp;</td><td> ".$gtbl->getSelectOption($field, $hmorig[$field],'',1)."</td>";
        $needcloserow = 1;

    }else if($gtbl->getFieldPrint($field) != ''){
        $refdetail = explode(":", $gtbl->getFieldPrint($field));
        $urlpart = "";
        $tmparr = explode(",",$refdetail[1]);
        foreach($tmparr as $k=>$v){
            $link = explode("=",$v);
            $val = "";
            if($link[1] == 'THIS_TABLE'){
                $val = $tbl;
            }else{
                $val = $hmorig[$link[1]];
            }
            $urlpart .= "pnsk".$link[0]."=".$val."&pnob".$link[0]."=1&";
        }
        $urlpart = substr($urlpart, 0, strlen($urlpart)-1);
        $urlpart .= "&pnsm=1";
        $rdnum = rand(0,99999);
        if($lastclosed == 0){
            $out .= "\n</tr>";
        }
        $out .= "<tr><td width=\"20%\" nowrap>".$gtbl->getCHN($field).":</td><td colspan=\"".($form_cols)."\"><span id=\"linkinfo_".$rdnum."\"></span><script type=\"text/javascript\"> doActionEx('./act/readfield.php?tbl=".$refdetail[0]."&".$urlpart."&fieldlist=".$refdetail[2]."&isheader=0&isoput=0&mode=intbl','linkinfo_".$rdnum."');</script>\n";
            $out .= "</td>  </tr>";
            $out .= "<tr height=\"30\" valign=\"middle\"  onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\">";

    }
	else{

		if($fieldinputtype == 'file'){
			$isimg = isImg($fieldv);
			if(strpos($fieldv, "$shortDirName/") !== false){ $fieldv = str_replace("$shortDirName/", "", $fieldv); }
			if($isimg){
				$fieldv= "<img src='".$fieldv."' width='80%' alt='-x-' />";	
			}
		}

        if($gtbl->getSingleRow($field) == '1'){
            $out .= "</tr><tr><td>".$gtbl->getCHN($field).":&nbsp;</td><td colspan=\"".($form_cols)."\"> ".$fieldv." </td> </tr>";
            $out .= "<tr height=\"30\" valign=\"middle\"  onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\">";

        }else{
            $out .= "<td nowrap >".$gtbl->getCHN($field).":&nbsp;</td><td> ".$fieldv." </td>";
            $needcloserow = 1;
        }
    }

    if(false && $needcloserow == 1){
        if($gtbl->getExtraInput($nextfield) != '' || $gtbl->getSingleRow($nextfield) == '1'){
            $out .= "<td colspan=\"".($form_cols)."\"> </td>";
            $out .= "</tr>";
            $hasclosed = 1;
        }
    }

    if($hasclosed == 0 && ++$i % 2 == 0){ 
        $out .= "</tr>";
        $out .= "<tr height=\"30\" valign=\"middle\"  onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\">";
        $lastclosed = 0;
    }else{
        $lastclosed = 1;
    }

}

$out .= "</table> <br/>";

$out .= "</div>";

$printref = $gtbl->getPrintRef(1);

$smt->assign('data', $data);


?>
