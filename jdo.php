<?php
# 
# Mon Jul 28 15:38:57 CST 2014

$isoput = false;
require("./comm/header.inc");

# read table config, IMPORTANT
require("./comm/tblconf.php");

# check tbl action
require("./act/tblcheck.php");

$url = mkUrl("jdo.php",$_REQUEST);
$list_disp_limit = 28;
#print "url:[$url]\n";
# act handler
if(startsWith($act,'add') || startsWith($act, "modify")){
    include("./act/addmodi.php");

}else if(startsWith($act, "list")){

    if(startsWith($act, "list-addform")){
       include("./act/doaddmodi.php"); 
    }

    if(startsWith($act, "list-dodelete")){
       include("./act/dodelete.php"); 
	   $url = str_replace('&id=', '&xoid=', $url); 
    }

    $navi = new PageNavi();
    $orderfield = $navi->getOrder();
    if($orderfield == ''){
        $orderfield = $gtbl->getOrderBy();
        $navi->set('isasc', $orderfield=='id'?1:0);
    }
    $gtbl->set("pagesize", $navi->get('pnps'));
    $gtbl->set("pagenum", $navi->get('pnpn'));
    $gtbl->set("orderby",$orderfield." ".($navi->getAsc()==0?"asc":"desc"));
    if($_REQUEST['pntc'] == '' || $_REQUEST['pntc'] == '0' || $navi->get('neednewpntc') == 1){
		$pagenum = $gtbl->get('pagenum');
		$gtbl->set('pagenum', 1);
        $hm = $gtbl->getBy("count(*) as totalcount", $navi->getCondition($gtbl, $user));
		#print "get pntc:";
		#print_r($hm);
        if($hm[0]){
            $hm = $hm[1][0];
            $navi->set('totalcount',$hm['totalcount']);
        }
		$gtbl->set('pagenum', $pagenum);
    }
    # list start
    $listid = array();
    $out .= "<table align=\"center\" width=\"98%\" cellspacing=\"0\" cellpadding=\"0\" style=\"\" class=\"mainlist\"><tr height=\"35px\"><td colspan=\"".($hmsize+2)."\">";
    $out .= "<button name=\"selectallbtn\" type=\"button\" onclick=\"checkAll();\" value=\"\">全选</button> &nbsp;";
    $out .= "<button name=\"reversebtn\" type=\"button\" onclick=\"uncheckAll();\" value=\"\">反选</button>";
    $out .= "&nbsp; ".$navi->getNavi()." &nbsp;<button name=\"searchor\" onclick=\"javascript:searchBy('".$url."&act=list&pnsm=or');\" title=\"满足其中一个条件即可\">或搜</button>&nbsp;<button name=\"searchand\" href=\"javascript:searchBy('".$url."&act=list&pnsm=and');\" title=\"同时满足所有检索条件\">与搜</button> </td></tr>";
    ## list-sort start
    $out .= "<tr align=\"center\" style=\"font-weight:bold;\" height=\"28px\">";
    if($hasid){
        $out .= "<td valign=\"middle\" nowrap>&nbsp;<a href=\"javascript:void(0);\" title=\"Sort by ID\" onclick=\"javascript:doAction('".str_replace("&pnob","&xxpnob",$url)."&act=list&pnobid=".($navi->getAsc('id')==0?1:0)."'); \">序/编号</a></td>";
    }else{
        $out .= "<td valign=\"middle\">Nbr.</td>";
    }
    for($hmi=$dispi=$min_idx; $hmi<=$max_idx; $hmi++){
        $field = $gtbl->getField($hmi);
        if($gtbl->filterHiddenField($field,$opfield,$timefield) 
                || $gtbl->getListView($field) == 0 || $dispi > $max_disp_cols){
            continue;
        }
        $dispi++;
        $out .= "<td valign=\"middle\"><a href=\"javascript:void(0);\" title=\"Sort by ".$gtbl->getCHN($field)."\" onclick=\"doAction('".str_replace("&pnob","&xxpnob",$url)."&act=list&pnob".$field."=".($navi->getAsc($field)==0?1:0)."')\">".$gtbl->getCHN($field)."</a></td>";
    }
    $out .= "<!-- <td valign=\"middle\"> 操作 </td> --> </tr>";
    ## list-sort end
    ## list-search start
    $untouched = '~~~';
    $out .= "<tr align=\"center\" style=\"font-weight:bold;\">";
    $out .= "<td valign=\"middle\"><input type=\"hidden\" name=\"fieldlist\" id=\"fieldlist\" value=\"".implode(",",array_keys($hmfield))."\" /> <input type=\"hidden\" name=\"fieldlisttype\" id=\"fieldlisttype\" value=\"".$gtbl->getFieldType()."\"/>";
    $out .= "<div style=\"display:none\" id=\"pnsk_id_op_div\"><select style=\"width:60px\" name=\"oppnsk_id\" id=\"oppnsk_id\">".$gtbl->getLogicOp('id')."</select></div>";
    $out .= "<input value=\"".($id==''?$_REQUEST['pnskid']:$id)."\" style=\"width:50px;".($id==''?"color:white;":"")."\" id=\"pnsk_id\" name=\"pnsk_id\" ";
    $out .= "style=\"COLOR:#777;\" title=\"Search By ...\" onclick=\"this.select();this.style.color='black';\" onfocus=\"document.getElementById('pnsk_id_op_div').style.display='block';\" onkeydown=\"javascript:if(event.keyCode == 13){ searchBy('".$url."&act=list&pnsm=and');}\" /></td>";
    for($hmi=$dispi=$min_idx; $hmi<=$max_idx; $hmi++){
        $field = $gtbl->getField($hmi);
        if($gtbl->filterHiddenField($field,$opfield,$timefield) 
                || $gtbl->getListView($field) == 0 || $dispi > $max_disp_cols ){
            continue;
        }
        $dispi++;
        $out .= "<td>"; 
        if($gtbl->getInputType($field) == 'select'){
			if($gtbl->getInput2Select($field)==1){
				if(!isset($tmpfieldv)){ $tmpfieldv = $untouched; }
				$out .= "<div style=\"display:none\" id=\"pnsk_{$field}_op_div\"><select name=\"oppnsk_{$field}\" id=\"oppnsk_{$field}\" style=\"width:60px\">".$gtbl->getLogicOp($field)."</select></div>";
				$out .= "<input value=\"".$_REQUEST["input2sele_$field"]."\" id=\"input2sele_".$field."\" name=\"input2sele_".$field."\" style=\"COLOR:#777;width:50px;".($tmpfieldv==$untouched?"color:white;":"")."\" title=\"Search By ...\" onclick=\"this.select();this.style.color='black';\" onfocus=\"document.getElementById('pnsk_".$field."_op_div').style.display='block';document.getElementById('pnsk_".$field."_sele_div').style.display='block';\" onkeydown=\"javascript:if(event.keyCode == 13){ searchBy('".$url."&act=list&pnsm=and');}\"";
				$out .= " onkeyup=\"javascript: input2Search(this,'$field');\" />";
				$out .= "<div style=\"display:none;position:absolute;background:#fff;border:#777 solid 1px;margin:-1px 0 0;padding: 5px;font-size:12px; overflow:auto;z-index:38;\" id=\"pnsk_{$field}_sele_div\"></div>";
				# load select options
				$out .= $gtbl->getSelectOption($field, (isset($_REQUEST['pnsk'.$field])?$_REQUEST['pnsk'.$field]:null),"pnsk_",0,0);
				$out .= "<script type=\"text/javascript\">var hidesele_$field=document.getElementById('pnsk_".$field."'); hidesele_$field.style.display='none';</script>";
			}
			else{
				$out .= $gtbl->getSelectOption($field, (isset($_REQUEST['pnsk'.$field])?$_REQUEST['pnsk'.$field]:null),"pnsk_",0,0);
			}
        }else{
            $tmpfieldv = $_REQUEST['pnsk'.$field];
            if(!isset($tmpfieldv)){ $tmpfieldv = $untouched; }
            $out .= "<div style=\"display:none\" id=\"pnsk_{$field}_op_div\"><select name=\"oppnsk_{$field}\" id=\"oppnsk_{$field}\" style=\"width:60px\">".$gtbl->getLogicOp($field)."</select></div>";
            $out .= "<input value=\"".$tmpfieldv."\" id=\"pnsk_".$field."\" name=\"pnsk_".$field."\" style=\"COLOR:#777;width:50px;".($tmpfieldv==$untouched?"color:white;":"")."\" title=\"Search By ...\" onclick=\"this.select();this.style.color='black';\" onfocus=\"document.getElementById('pnsk_".$field."_op_div').style.display='block';\" onkeydown=\"javascript:if(event.keyCode == 13){ searchBy('".$url."&act=list&pnsm=and');}\" />";
        }
        $out .= "</td>";
    }
    $out .= "<!-- <td><a href=\"javascript:searchBy('".$url."&act=list&pnsm=or');\" title=\"满足其中一个条件即可\">或搜</a><br/><a href=\"javascript:searchBy('".$url."&act=list&pnsm=and');\" title=\"同时满足所有检索条件\">与搜</a></td> --> </tr>";
    ## list-search end
    ## main data loop
    $hm = $gtbl->getBy("*", $navi->getCondition($gtbl, $user));
    if($hm[0]){
        $hm = $hm[1]; $i = 0; $fstfields = ''; $hmsum = array();
        # record start
        foreach($hm as $k=>$rec){ 
           $bgcolor = "#DCDEDE";
           if($i%2 == 0){
                $bgcolor = "";
           }
           $out .= "<tr height=\"35px\" align=\"center\" valign=\"middle\" onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\" bgcolor=\"".$bgcolor."\">";
           if($hasid){
               $id = $rec['id']; $listid[] = $id;
               $out .= "<td nowrap> <input name=\"checkboxid\" type=\"checkbox\" value=\"".$id."\"> &nbsp; <a onmouseover=\"javascript:showActList('".$id."', 1, '".str_replace("&id=","&oid=", $url)."&id=".$id."');\" onmouseout=\"javascript:showActList('".$id."', 0, '".str_replace("&id=","&oid=", $url)."&id=".$id."');\" href='javscript:void(0);' onclick=\"javascript:doActionEx('".$url."&act=view&id=".$id."','contentarea');;\" title=\"详细信息\">".(++$i + (intval($navi->get('pnpn'))-1) * (intval($navi->get('pnps'))))." / ".$id." &#x25BE;</a> <div id=\"divActList_$id\" style=\"display:none; position: absolute; margin-left:50px; margin-top:-11px; z-index:99; background-color:silver;\">actliat-$id</div> </td>";

           }else{
               $out .= "<td > &nbsp; Error! No Id!</td>";
           }
           for($hmi=$dispi=$min_idx; $hmi<=$max_idx; $hmi++){
               $field = $gtbl->getField($hmi);
               if($gtbl->filterHiddenField($field,$opfield,$timefield) 
                       || $gtbl->getListView($field) == 0 || $dispi > $max_disp_cols){
                   continue;
               }
               $dispi++;
               $inputtype = $gtbl->getInputType($field);

               if(!$user->canRead($field,'','', $_REQUEST['id'],$id)){
                    $out .= "<td> * </td>";

               }else if($inputtype == 'select'){
				
					   $fhref = $gtbl->getHref($field, $rec);
					   if(count($fhref) == 0){
							$fhref = "";
						}
						else{
							if(strpos($fhref[0],"javascript") !== false){
							   $fhref_tmp = "<a href=\"javascript:void(0);\" onclick=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">";
							}else{
							   $fhref_tmp = "<a href=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">";
							}			
							$fhref = $fhref_tmp;
						}
						$fhref_end = ''; if($fhref != ''){ $href_end = "</a>"; }

				   $myinputtype = $inputtype;
                   $readonly = $gtbl->getReadOnly($field);
                   if($gtbl->getJsAction($field) != ''){ $readonly = 'readonly'; }
				   if($gtbl->getInput2Select($field)==1){ $myinputtype = "input2select";  }
                   $tmpv_orig = $tmpv=$gtbl->getSelectOption($field, $rec[$field],'',1, $gtbl->getSelectMultiple($field));
                   $tmpv = shortenStr($tmpv, $list_disp_limit);
                   $out .= "<td ondblclick=\"javascript:switchEditable('othercont_div_".$id."_".$field."','".$field."','".$myinputtype."','".$rec[$field]."','".$url."&act=updatefield&field=".$field."&id=".$id."','".$readonly."');\" ".$gtbl->getCss($field, $rec[$field])." title=\"".$tmpv_orig."\"><div id=\"othercont_div_".$id."_".$field."\">".$fhref.$tmpv.$fhref_end."</div>";
                   $out .= "</td>";

                   $listid[$dispi] = $tmpv_orig;

               }else if($inputtype == 'file'){
					   $fhref = $gtbl->getHref($field, $rec);
					   if(strpos($rec[$field], "$shortDirName/") !== false){ $rec[$field] = str_replace("$shortDirName/", "", $rec[$field]); }
					   if(count($fhref) == 0){
							$fhref = "<a href=\"javascript:void(0);\" onclick=\"window.open('".$rec[$field]."');\" title=\"点击大图或者下载 ".$rec[$field]."\">"; 	   
						}
						else{
							if(strpos($fhref[0],"javascript") !== false){
							   $fhref_tmp = "<a href=\"javascript:void(0);\" onclick=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">";
							}else{
							   $fhref_tmp = "<a href=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">";
							}			
							$fhref = $fhref_tmp;
						}
                   $out .= "<td> ".$fhref;
				   
				   $isimg = isImg($rec[$field]);
                   if($isimg){
                       $out .= "<img src=\"".$rec[$field]."\" style=\"max-width:99%; max-height:99%\" onload=\"javascript: var baseSize=118; if(this.width > baseSize){ this.style.width = baseSize+'px';}else if(this.height > baseSize){ this.style.height=baseSize+'px'; } \" id=\"img_".$rec[$field]."\" />";

                   }else{
                        $out .= "".shortenStr($rec[$field], $list_disp_limit)."";
                   }
                   $out .= "</a>"; # <br/>".$rec[$field]."</td>";

               }else if($gtbl->getExtraInput($field) != ''){

                   $out .= "<td ondblclick=\"javascript:show('span_disp_".$field."','".$gtbl->getExtraInput($field)."&act=".$act."&field=".$field."&otbl=".$tbl."&oldv=".$rec[$field]."&oid=".$id."',true,true);\" title=\"".addslashes($rec[$field])."\">".shortenStr($rec[$field], $list_disp_limit)." <span id=\"span_disp_".$field."\"> </span> <div id=\"extrainput_".$act."_".$field."\" class=\"extrainput\">  </div> </td>";

                   $listid[$dispi] = $rec[$field];

               }else{
                   $fv = str_replace('<', '&lt;', $rec[$field]);
                   $fv_short = $fv_orig = $fv;
                   $fv_short = shortenStr($fv, $list_disp_limit);
                   $fhref = $gtbl->getHref($field, $rec);
                   if(count($fhref)>0){
                       if(strpos($fhref[0],"javascript") !== false){
                           $fv_short = "<a href=\"javascript:void(0);\" onclick=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">".$fv_short."</a>";
                       }else{
                           $fv_short = "<a href=\"".$fhref[0]."\" title=\"".$fhref[1]."\" target=\"".$fhref[2]."\">".$fv_short."</a>";
                       }
                   }
                   $out .= "<td ondblclick=\"javascript:switchEditable('othercont_div_".$id."_".$field."','".$field."','".$inputtype."','','".$url."&act=updatefield&field=".$field."&id=".$id."','".$gtbl->getReadOnly($field)."');\" title=\"".str_replace("\"","", $fv_orig)."\" ".$gtbl->getCss($field)."><div id=\"othercont_div_".$id."_".$field."\">".$fv_short."</div></td>";
                   $listid[$dispi] = $rec[$field];
               }
               # hmsum, sum or count each item
               if($gtbl->getInputType($field) != 'select' 
                       && $gtbl->isNumeric($hmfield[$field])
                       && strpos($hmfield[$field], "date") === false){

                   $hmsum[$field] += $rec[$field]; 

               }else{
                   if($rec[$field] != ''){
                        if(!isset($hmsumuniq[$field][$rec[$field]])){
                            $hmsum[$field]++;
                            $hmsumuniq[$field][$rec[$field]] = 1;
                        }
                   }else{
                        if(!isset($hmsum[$field])){
                            $hmsum[$field] = 1;
                        }
                   }
               }
           }
           if(0){ # wrap as pop div in id field, wadelau, Sat Jul 25 17:05:57 CST 2015
           if($hasid){

               $out .= "<td > <select id=\"actsel_$i\" name=\"actsel_$i\" class=\"selectsmall\" onchange=\"javascript:doActSelect('actsel_".$i."','".str_replace("&id=","&oid=", $url)."&id=".$id."', ".$id.");\">";
               $out .= "<option value=\"\">-做-</option>";
               $out .= "<option value=\"view\" title=\"查看详细信息\">查看</option>";
               $out .= "<option value=\"modify\">修改</option>";
			   $out .= "<option value=\"print\">打印</option>";
               $out .= "<option value=\"list-dodelete\">删除</option>";
               $out .= "</select> </td>";

           }else{
               $fieldargv = "";
               for($hmi=$dispj=$min_idx; $hmi<=$max_idx; $hmi++){
                   $field = $gtbl->getField($hmi);
                   if($gtbl->filterHiddenField($field,$opfield,$timefield) 
                           || $gtbl->getListView($field) == 0 || $dispj > $max_disp_cols){
                       continue;
                   } 
                   $dispj++;
                   $fieldargv .= "&".$field."=".$rec[$field];
               }
               $out .= "<td > <a href=\"javascript:void(0);\" onclick=\"javascript:doActionEx('".$url."&act=modify".$fieldargv."','contentarea')\" >[modify]</a> <br/> <a href=\"javascript:void(0);\" onclick=\"javascript:if(confirm('confirm delete [".$gtbl->getField(1).":".$rec[$gtbl->getField(1)]."]?')){doAction('".$url."&act=list-dodelete".$fieldargv."');}\" >[delete]</a> &nbsp; </td>";
           }
			}
           $out .= "</tr>\n"; 
           if(!isset($_REQUEST['linkfieldcopy'])){ $fstfields .= $listid[1].","; }else{ $fstfields .= $listid[$_REQUEST['linkfieldcopy']].","; }
        } 
        # record end
        # sum bgn
        $out .= "<tr height=\"35px\" align=\"center\" valign=\"middle\" onmouseover=\"javascript:this.style.backgroundColor='".$hlcolor."';\" onmouseout=\"javascript:this.style.backgroundColor='';\" bgcolor=\"".$bgcolor."\"><td>&nbsp;</td>";
        foreach($hmsum as $k=>$v){
            if($gtbl->filterHiddenField($k,$opfield,$timefield)){ # || $gtbl->getInputType($k) == 'select'
                $out .= "<td> - </td>";
            }else{ 
                $tmpsum = $hmsum[$k];
                if($gtbl->getStat($k) == 'average'){
                    $tmpsum = sprintf("%.2f",$tmpsum/$i);
                }
                $out .= "<td>".$tmpsum."</td>";
            }
        }
        $out .= "<td></td></tr>\n";
        # sum end
        $out .= "<tr height=\"35px\"><td style=\"border-bottom:0px\" colspan=\"".($hmsize+2)."\">";
        $out .= "<button name=\"selectallbtn\" type=\"button\" onclick=\"checkAll();\" value=\"\">全选</button> &nbsp;";
        $out .= "<button name=\"reversebtn\" type=\"button\" onclick=\"uncheckAll();\" value=\"\">反选</button>";
        $out .= $navi->getNavi();
        //$out .= " <script> parent.sendLinkInfo('".implode(",",$listid)."','w',''); </script> ";
        $out .= " <script type=\"text/javascript\"> parent.sendLinkInfo('".urlencode(substr($fstfields, 0, strlen($fstfields)-1))."','w','".$_REQUEST['field']."'); </script> ";
        $out .= "</td></tr>";
    }
    $out .= "</table>";
    # list end
    ## list-toexcel
    if(startsWith($act, "list-toexcel")){
       include("./act/toexcel.php"); 
    }

}else if(startsWith($act,"view")){ 

    include("./act/view.php");

}else if($act == 'print'){

    $smttpl = getSmtTpl(__FILE__, $act);
    include("./act/print.php");

}else if($act == 'updatefield'){

    include("./act/updatefield.php");

}else{

    $out .= "Ooops! No such action:[$act].<br/>&nbsp;\n";
}

require("./comm/footer.inc");

print $out;

?>
