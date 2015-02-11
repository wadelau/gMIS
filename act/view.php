<?php
# part of jdo.php, view details of a record
# added by wadelau on Tue Apr 10 19:52:51 CST 2012

$colsPerRow = 3;
if($_REQUEST['pnsktuanid'] != '' && $_REQUEST['otbl'] != ''){
    $colsPerRow = 2;
}

$out .= "<fieldset style=\"border-color:#5f8ac5;border: 1px solid #5f8ac5\"><legend><h4>详细内容</h4></legend><table align=\"center\" width=\"95%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0px\">";
$out .= "<tr><td width=\"11%\">&nbsp;</td>
            <td width=\"22%\">&nbsp;</td>
            <!-- <td width=\"2%\">&nbsp;</td> -->
            <td width=\"11%\">&nbsp;</td>
            <td width=\"22%\">&nbsp;</td>
            <td width=\"11%\">&nbsp;</td>
            <td width=\"22%\">&nbsp;</td>
            </tr>";
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
foreach($_REQUEST as $k=>$v){
	if(startsWith($k,"pnsk")){
		$hmorig[substr($k,4)] = $v;
	}
	else if(startsWith($k, 'parent')){
		$k2 = $v;
		$hmorig[$k2] = $_REQUEST[$k2];	
	}
}
if($hmorig[0]){
    $hmorig = $hmorig[1][0]; 
}

$closedtr = 1;
$columni = 0;
for($hmi=$min_idx; $hmi<=$max_idx; $hmi++){
    $field = $gtbl->getField($hmi);
    $fieldinputtype = $gtbl->getInputType($field);
    if($field == null || $field == ''
            ){ # || $field == 'id'

        continue;
    } 
    if($closedtr == 1){
        $out .= "<tr height=\"30\" valign=\"middle\"  onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\">";
        $closedtr = 0;
    }

    if($field == 'password'){
        $hmorig[$field] = '';
    }

    if(!$user->canRead($field,'','', $_REQUEST['id'], $id)){
        $out .= "<--NOREAD-->";

    }else if($fieldinputtype == 'select'){

		$out .= "<td>".$gtbl->getCHN($field).":&nbsp;</td><td> ".$gtbl->getSelectOption($field, $hmorig[$field],'',1)."</td>";
        
    }else if($fieldinputtype == 'file'){
        $isimg = isImg($hmorig[$field]);
        if($isimg){
            $out .= "<td >".$gtbl->getCHN($field).":&nbsp;</td><td> <a href=\"".$hmorig[$field]."\" target=\"_blank\" title=\"打开大图\"><img src=\"".$hmorig[$field]."\" alt=\"-x-\" style=\"width:118px\"/></a><br/>".$rtvdir."/".$hmorig[$field]." </td>";
        }else{
            
            $out .= "<td >".$gtbl->getCHN($field).":&nbsp;</td><td> <a href=\"".$hmorig[$field]."\" title=\"".$hmorig[$field]."\" target=\"_blank\">".$hmorig[$field]."</a> </td>";
        }
    
    }else if($gtbl->getExtraInput($field,$hmorig) != ''){

        $out .= "</tr><tr><td>".$gtbl->getCHN($field).":</td><td colspan=\"".$form_cols."\"><span id=\"span_".$act."_".$field."_val_add\"><input id=\"".$field."\" name=\"".$field."\" class=\"search\" value=\"".$hmorig[$field]."\" /></span> <span id=\"span_".$act."_".$field."\"><a href=\"javascript:void(0);\" onclick=\"javascript:doActionEx('".$gtbl->getExtraInput($field,$hmorig)."&act=".$act."&otbl=".$tbl."&field=".$field."&oldv=".$hmorig[$field]."&oid=".$id."','extrainput_".$act."_".$field."_inside');document.getElementById('extrainput_".$act."_".$field."').style.display='block';\">Disp</a></span> <div id=\"extrainput_".$act."_".$field."\" class=\"extrainput\"> ";
		$out .= "<table width=\"100%\"><tr><td width=\"100%\" style=\"text-align:right\"> <b> <a href=\"javascript:void(0);\" onclick=\"javascript:if('".$id."' != ''){ var linkobj=document.getElementById('".$field."'); if(linkobj != null && '".$id."'!=''){ document.getElementById('".$field."').value=document.getElementById('linktblframe').contentWindow.sendLinkInfo('','r','".$field."');} } document.getElementById('extrainput_".$act."_".$field."').style.display='none';\">X</a> </b> &nbsp; </td></tr><tr><td> <div id=\"extrainput_".$act."_".$field."_inside\"></div></td></tr></table> </div>";
        if($field != 'operatelog'){
            $out .= " <script type=\"text/javascript\"> parent.doActionEx('".$gtbl->getExtraInput($field,$hmorig)."&act=".$act."&otbl=".$tbl."&field=".$field."&oldv=".$hmorig[$field]."&oid=".$id."','extrainput_".$act."_".$field."_inside'); document.getElementById('extrainput_".$act."_".$field."').style.display='block';</script>";
        }
        $out .= "  <br/>".$gtbl->getMemo($field)." </td></tr><tr>";

    }else{
      
        $tmpval = str_replace('<', '&lt;', $hmorig[$field]);

        $fhref = $gtbl->getHref($field, $hmorig);
        if(count($fhref)>0){
						if(strpos($fhref[0],"javascript") !== false){
              $tmpval = "<a href=\"javascript:void(0);\" onclick=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">".$tmpval."</a>";    
            }else{
              $tmpval = "<a href=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">".$tmpval."</a>";   
            }
        }

        if($gtbl->getSingleRow($field) == 1){
            $out .= "</tr><tr> <td style=\"vertical-align:top\">".$gtbl->getCHN($field).":</td> ";
            $out .= "<td colspan=\"".($form_cols-1)."\"> ".$tmpval."  </td></tr><tr>";
        }else{
            $out .= "<td >".$gtbl->getCHN($field).":&nbsp;</td><td> ".$tmpval." </td>";
        }
    }

    $columni++;
    if($columni % $colsPerRow == 0){
        $out .= "</tr>";
        $closedtr = 1;
    }

    if(++$rows % 6 == 0 && $closedtr == 1){
        $out .= "<tr><td style=\"border-top: 1px dotted #cccccc; vertical-align:middle;\" colspan=\"".$form_cols."\">  </td> </tr>";
    }
}

$out .= "<tr ><td style=\"border-top: 1px dotted #cccccc; vertical-align:middle;\" colspan=\"".$form_cols."\">  </td></tr>";
$out .= "<tr><td colspan=\"".$form_cols."\" align=\"center\"><input type=\"button\" name=\"viewbtn\" id=\"viewbtn\" value=\"编辑\" onclick=\"javascript:doActionEx('".$url."&act=modify','contentarea');\"/> <input type=\"button\" name=\"printbtn\" id=\"printbtn\" value=\"打印预览\" onclick=\"javascript:window.open('".$url."&act=print&isoput=1&isheader=0','PrintWindow','scrollbars,toolbar,location=0');\"/>   <input type=\"button\" name=\"cancelbtn\" value=\"关闭\" onclick=\"javascript:parent.switchArea('contentarea_outer','off');\" /> </td></tr>";
$out .= "</table> </fieldset>  <br/>";


?>
