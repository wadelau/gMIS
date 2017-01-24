<?php
/*
 * Pivot table or OLAP in -gMIS
 * added by wadelau@ufqi.com
 * Tue, 22 Nov 2016 21:16:30 +0800
 * update with data resort by Xenxin, Thu, 12 Jan 2017 13:28:13 +0800
 */

$formid = "gtbl_pivot_form"; //- ?

$hiddenfields = "";

$tblspan = 3;
$colsPerRow = 2;
if($_REQUEST['otbl'] != ''){
    $colsPerRow = 2;
}

if($act == 'pivot-do'){
    
    # submit form
    $navi = new PageNavi();
    $condi = $navi->getCondition($gtbl, $user);
    $grpby = Wht::get($_REQUEST, 'groupby');
    $calby = Wht::get($_REQUEST, 'calculateby');
    $ordby = Wht::get($_REQUEST, 'orderby');
    $sql = "select 1";
    $grpArr = explode(',', $grpby);
    $calArr = array();
    $grpTagArr = array();
    foreach ($grpArr as $k=>$v){ # group fields
        if($v != ''){
            $arr = explode('::', $v);
            if($arr[0] != ''){
                $arr[1] = str_replace('addgroupby', '', $arr[1]);
                if($arr[1] == ''){
                    $sql .= ",".$arr[0]." ";
                }
                else{
                    if($arr[1] == 'ymd'){
                        $itag = $arr[0]."ymd";
                        $sql .= ", substr(".$arr[0].", 1, 10) as $itag ";
                        $grpTagArr[$arr[0]] = $itag;
                    }
                }
            }
        }
    }
    $calArrDisp = array();
    foreach (explode(',', $calby) as $k=>$v){ # calculate fields
        if($v != ''){
            $arr = explode('::', $v);
            if($arr[0] != ''){
                $arr[1] = str_replace('addvalueby', '', $arr[1]);
                $func = $arr[1]."(".$arr[0].")";
                if($arr[1] == 'countdistinct'){
                    $func = "count(distinct ".$arr[0].")";
                }
                $sql .= ",".$func." as ".$arr[0].$arr[1]." ";
                $calArrDisp[$arr[0].$arr[1]] = 1;
                if(!isset($calArr[$arr[0]])){
                    $calArr[$arr[0]] = $arr[0].$arr[1];
                }
                if(true){
                    $calArr[$arr[0].$arr[1]] = $arr[0];
                }
            }
        }
    }
    $sql .= " from ".$gtbl->getTbl();
    $sql .= " where ".($condi=='' ? '1=1' : $condi);
    $sql .= " group by 1";
    $grpArrDisp = array();
    foreach ($grpArr as $k=>$v){ # group by fields
        if($v != ''){
            $arr = explode('::', $v);
            if($arr[0] != ''){
                if(isset($grpTagArr[$arr[0]])){
                    $arr[0] = $grpTagArr[$arr[0]];
                }
                $sql .= ",".$arr[0]." ";
                $grpArrDisp[$arr[0]] = 1;
            }
        }
    }
    $sql .= " order by 1";
    $ordArr = array();
    foreach (explode(',', $ordby) as $k=>$v){ # order by fields
        if($v != ''){
            $arr = explode('::', $v);
            if($arr[0] != ''){
                if(isset($calArr[$arr[0]])){
                    $arr[0] = $calArr[$arr[0]]; # use calcu result as order
                    $sql .= ",".$arr[0]." desc ";
                }
                else if(isset($grpTagArr[$arr[0]])){
                    $arr[0] = $grpTagArr[$arr[0]];
                    $sql .= ",".$arr[0]." ";
                }
                else{
                    $sql .= ",".$arr[0]." ";
                }
                $ordArr[$arr[0]] = 1;
            }
        }
    }
    $grpArrDispTmp = array(); # prioritize order fields 
    foreach ($ordArr as $ok=>$ov){
        if(isset($grpArrDisp[$ok])){
            $grpArrDispTmp[$ok] = 1;
        }
    }
    foreach ($grpArrDisp as $gk=>$gv){
        if(!isset($ordArr[$gk])){
            $grpArrDispTmp[$gk] = 1;
        }
    }
    $grpArrDisp = $grpArrDispTmp;
    #$out .= "sql:[$sql]";
    #debug(__FILE__.": sql:[$sql]");
    $hm = $gtbl->execBy($sql, null);
    if($hm[0]){
        $hm = $hm[1];
        # table headers
        $out .= "<b>透視數據繪圖</b><br/>";
        $out .= "<table id=\"pivot_resultset_g\" style=\"border:1px solid black; width:96%; margin-left:auto; margin-right:auto;\">";
        $out .= "<tr><td colspan=\"3\"></td></tr>";
        $out .= "<tr><td colspan=\"30\" style=\"text-align:center\">...Graphic...</td></tr>";
        $out .= "</table>";
        $out .= "<br/><b>透視數據列表</b>";
        $out .= "<table id=\"pivot_resultset\" style=\"border:1px solid black; width:96%; margin-left:auto; margin-right:auto;\""
                ." class=\"pivot_resultset\">";
        $out .= "<tr><td colspan=\"3\"></td></tr>";
        $out .= "<tr style=\"font-weight:bold;\"><td> &nbsp;No.</td>";
        foreach ($grpArrDisp as $gk=>$gv){
            $out .= "<td>".$gtbl->getCHN($gk)."</td>";
        }
        foreach ($hm[1] as $vk=>$vv){
            if($vk == '1'){ continue; }
            else if(isset($grpArrDisp[$vk])){ continue; }
            else{
                $out .= "<td>".$gtbl->getCHN($vk)."</td>";
            }
        }
        $out .= "</tr>";
        # resort data
        $dispArr = array();
        $dispSort = array();
        foreach ($hm as $dk=>$dv){
            $uniqk = '';
            $gi = 0; $lastK = '';
            foreach ($grpArrDisp as $gk=>$gv){
                $uniqk .= $dv[$gk]."\t";
                #debug(__FILE__.": uniqk:[$uniqk] dk:[$dk] lastk:[$lastK]");
                foreach ($calArrDisp as $ck=>$cv){
                    $dispArr[$uniqk][$ck] += $dv[$ck];
                }
                if($gi == 0){
                    if(!isset($dispSort[$uniqk])){
                        $dispSort[$uniqk] = sprintf("%04d", $dk+1); # every 4-digital as a segment
                    }
                }
                else{
                    if(!isset($dispSort[$uniqk])){
                        $prtk = $dispSort[$lastK];
                        $dispSort[$uniqk] = $prtk.sprintf("%04d", $dk+1);
                    }
                }
                $lastK = $uniqk;
                $gi++;
            }
        }
        #print_r($dispArr);
        #debug(__FILE__.": dispSort:".$gtbl->toString($dispSort));
        # display
        $colsum = array(); $colsumuniq = array();
        $rowi = 0;
        asort($dispSort, SORT_STRING); # sort by string and keep hash index
        $grpArrLen = count($grpArrDisp);
        foreach ($dispSort as $dk=>$dv){ #
            $dv = $dispArr[$dk];
            $out .= "<tr><td> &nbsp;".($rowi++)."</td>";
            $dkArr = explode("\t", $dk);
            array_pop($dkArr);
            foreach ($dkArr as $dkk=>$dkv){
                $out .= "<td>$dkv</td>";
                if(!isset($colsumuniq[$dkk][$dkv])){
                    $colsum[$dkk]++;
                    $colsumuniq[$dkk][$dkv] = 1;
                }
            }
            $isFullKey = true;
            $arrLenBala = $grpArrLen - count($dkArr);
            for($dki=0; $dki<$arrLenBala; $dki++){
                $out .= "<td style='background-color:silver;'>ALL</td>";
                $isFullKey = false;
            }
            foreach ($calArrDisp as $ck=>$cv){
                $out .= "<td>".sprintf("%.3f", $dispArr[$dk][$ck])."</td>";
                if($isFullKey){
                    $colsum[$ck] += $dispArr[$dk][$ck];
                }
            }
            $out .= "</tr>";
        }
        $out .= "<tr style=\"font-weight:bold;\"><td>GrandTotal</td>";
        foreach ($colsum as $sk=>$sv){
            $out .= "<td>".sprintf("%.3f", $sv)."</td>";
        }
        $out .= "</tr>";
        $out .= "<tr><td colspan=\"3\"></td></tr>";
        $out .= "</table>";
    }
    else{
        $out .= "No Data for query:[$sql]. 1612061412.";
    }
}
else{

    # form 
# reset old?
#$url = str_replace("&pnsk", "&oldpnsk", $url);

$out .= "<fieldset style=\"border-color:#5f8ac5;border: 1px solid #5f8ac5;\"><legend><h4>數據透視當前數據集("
        .number_format($_REQUEST['pntc']).")</h4></legend>"
       ."<form id=\"".$formid."\" name=\"".$formid."\" method=\"post\" action=\"".$url."&act=pivot-do\" "
	   .$gtbl->getJsActionTbl().">";
$out .= "<table style='border:0px; width:96%; margin-left:auto; margin-right:auto;'>";
        
$out .= "<tr><td colspan='$tblspan'>選擇待考察的對象, 形成待生成數據表的橫向列項:</td></tr>";
$out .= "<tr><td colspan='$tblspan' width='100%'>";

$hmorig = array();

if(true){
    foreach($_REQUEST as $k=>$v){
        if(startsWith($k,"pnsk")){
            $hmorig[substr($k,4)] = $v;
        }
        else if(startsWith($k, 'parent')){ # Attention! parentid
            $k2 = $v;
            $hmorig[$k2] = $_REQUEST[$k2];
        }
    }
    for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){
        $field = $gtbl->getField($hmi);
        if($field == null | $field == ''
                || $field == 'id'){
                    continue;
        }
        $fielddf = $gtbl->getDefaultValue($field);
        if($fielddf != ''){
            $tmparr = explode(":", $fielddf);
            if($tmparr[0] == 'request'){ # see xml/hss_info_attachfiletbl.xml
                $hmorig[$field] = $_REQUEST[$tmparr[1]];
            }else{
                $hmorig[$field] = $tmparr[0]; # see xml/hss_tuanduitbl.xml
            }
        }
    }
}

if($hmorig[0]){
    $hmorig = $hmorig[1][0];
}

$closedtr = 1; $opentr = 0; # just open a tr, avoid blank line, Sun Jun 26 10:08:55 CST 2016
$columni = 0; $my_form_cols = 4;
$firstField = '';
$secondField = '';

for($hmi=$min_idx; $hmi<=$max_idx;$hmi++){
    $field = $gtbl->getField($hmi);
    $fieldinputtype = $gtbl->getInputType($field);

    $filedtmpv = $_REQUEST['pnsk_'.$field];
    if(isset($fieldtmpv)){
        $hmorig[$field] = $fieldtmpv;
    }

    if($field == null || $field == ''){ # || $field == 'id'
        continue;
    }
    if($fieldinputtype == 'hidden'){
        $hiddenfields .= "<input type=\"hidden\" name=\"".$field."\" id=\"".$field."\" value=\"".$hmorig[$field]."\"/>\n";
    }
    if($gtbl->filterHiddenField($field, $opfield,$timefield)){
        #continue; # should be displayed
    }
    if($field == 'password'){
        $hmorig[$field] = '';
        continue;
    }
    else if($fieldinputtype == 'file'){
        continue;
    }
    
    # real input field
    if($firstField == '' && ($field != 'id' || $field != $gtbl->getMyId())){ $firstField = $field; }
    else if($secondField == '' && ($field != 'id' || $field != $gtbl->getMyId()) ){ $secondField = $field; }
    $chnName = $gtbl->getCHN($field);
    $out .= "<a href='javascript:void(0);' onmouseover=\"javascript:showPivotList($hmi, 1, '$field', '".$chnName."');\" "
            .">$hmi. ".$chnName."($field)"
            ."</a><span id='divPivotList_$hmi' style=\"display:none; position: relative; margin-left:-5px; "
            ." margin-top:-10px; z-index:97; background-color:silver;\" "
            ." ></span>&nbsp;&nbsp;&nbsp;&nbsp;"; # onmouseout=\"javascript:this.style.display='none';\"

}

$out .= "</td></tr>";

$firstFieldChn = $gtbl->getCHN($firstField);
$secondFieldChn = $gtbl->getCHN($secondField);
$out .= "<tr>"
    ."<td width='34%'><fieldset><legend title='目標數據表分組項'>分組項列</legend>"
    ."<span id='span_groupby'>"
    .$firstFieldChn."($firstField) addgroupby   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('$firstField', "
    ."'1', 'addgroupby', 0, '".$firstFieldChn."');\" title=\"Remove\"> X(Rm) </a>   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('"
    .$firstField."', '1', 'addorderby', 1, '".$firstFieldChn."');\" title=\"Order\"> ↿⇂(Od) </a><br>"
    ."</span><input type='hidden' name='groupby' id='groupby' value=',".$firstField."::addgroupby'/>"
    ."</fieldset></td>";
$out .= "<td width='33%'><fieldset><legend title='目標數據表計算項'>求值項列</legend>"
        ."<span id='span_calculateby'>"
        .$gtbl->getCHN($secondField)."($secondField) addvaluebycount   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('$secondField', "
        ."'1', 'addvaluebycount', 0, '".$gtbl->getCHN($secondField)."');\" title=\"Remove\"> X(Rm) </a>   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('"
        .$secondField."', '1', 'addorderby', 1, '".$secondFieldChn."');\" title=\"Order\"> ↿⇂(Od) </a><br>"
        ."</span><input type='hidden' name='calculateby' id='calculateby' value=',".$secondField."::addvaluebycount'/>"
        ."</fieldset></td>";
$out .= "<td><fieldset><legend title='目標數據表排序項'>排序項</legend>"
        ."<span id='span_orderby'>"
        .$gtbl->getCHN($firstField)."($firstField) addorderby   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('$firstField', "
        ."'1', 'addorderby', 0, '".$gtbl->getCHN($firstField)."');\" title=\"Remove\"> X(Rm) </a>   <a href=\"javascript:void(0);\" onclick=\"javascript:doPivotSelect('"
        .$firstField."', '1', 'addorderby', 1, '".$firstFieldChn."');\" title=\"Order\"> ↿⇂(Od) </a><br>"
        ."</span><input type='hidden' name='orderby' id='orderby' value=',".$firstField."::addorderby'/></fieldset></td>"
        ."</tr>";
	
$out .= "<tr><td colspan='$tblspan'> <input type=\"submit\" name=\"addsub\" id=\"addsub\" "
        ."onclick=\"javascript:doActionEx(this.form.name,'pivotarea');\" /> \n"; # value=\"递   交\"
        $out .= "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"".$id."\"/>\n ".$hiddenfields."\n";
        $out .= "&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"button\" name=\"cancelbtn\" value=\"取   消\" "
                ."onclick=\"javascript:switchArea('contentarea_outer','off');\" /> </td></tr></table>";

$out .= "</form> <br/> <div id='pivotarea'>Data Processing....</div> </fieldset>";

}

?>
