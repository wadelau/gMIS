<?php
require("./comm/header.inc.php");

$out = str_replace('TITLE','欢迎', $out); 
$isgo = true;
if($tbl == ''){
    if(1){
        $tbl = $_CONFIG['welcometbl'];
        $_REQUEST['tbl'] = $tbl;
    }else{
        $out .= __FILE__.": a table name should be given. [1201231050]\n";
        $out .= "<br/><a href=\"".$_CONFIG['rtvdir']."\">=Home</a>";
        $isgo = false;
    }
}else{
    $out .= "<script type=\"text/javascript\">currenttbl='".$tbl."';\ncurrentdb='".$mydb."';\n currentlistid= {};\n userinfo={'id':'".$userid."','email':'".$user->getEmail()."','group':'".$user->getGroup()."','branch':'".$user->get('branchoffice')."'};\n </script>\n";
}

$out_header = $out;
$out = ""; # re-init it

if($isgo){

$hmconf = GTbl::xml2hash($xmlpathpre, $elementsep, $mydb, $tbl);
$gtbl = new GTbl($tbl, $hmconf[0], $elementsep);
#print __FILE__.": hmconf:".print_r($hmconf);
if($_REQUEST['tit'] == ''){
    $tit = $gtbl->getTblCHN();
}

# get detail path
$module_path = ''; $levelcode = ''; $codelist = '';
#$hm = $gtbl->execBy("select levelcode, linkname, modulename from ".$_CONFIG['tblpre']."info_menulist where modulename='".str_replace($_CONFIG['tblpre'],"",$tbl)."'", null);
$hm = $gtbl->execBy("select levelcode, linkname, modulename from ".$_CONFIG['tblpre']."info_menulist where modulename in ('".str_replace($_CONFIG['tblpre'],"",$tbl)."', '".$tbl."')", null);
#debug($hm);
if($hm[0]){
	$levelcode = $hm[1][0]['levelcode'];
	$codelist = substr($levelcode,0,2)."','".substr($levelcode,0,4)."','".substr($levelcode,0,6)."','".substr($levelcode,0,8); # max 4 levels allowed
	$hm = $gtbl->execBy("select levelcode, linkname, modulename from ".$_CONFIG['tblpre']."info_menulist where levelcode in ('".$codelist."') order by levelcode", null);
	if($hm[0]){
		$hm = $hm[1]; $lastLinkName = ''; #print_r($hm); 
		foreach($hm as $k=>$v){
			if($v['modulename'] != ''){
				$module_path .= "<a href='./".$ido."?sid=".$sid."&tbl=".$v['modulename']."'>".$v['linkname']."</a> &rarr;";	
			}
			else{
				$module_path .= "<a href='./?navidir=".$v['levelcode']."'>".$v['linkname']."</a> &rarr;";	
			}
			$lastLinkName = $v['linkname'];
		}
		$module_path = substr($module_path, 0, strlen($module_path)-6);
	}
}
$module_path = $module_path == '' ? '<a href="./?navidir=99">桌面 & 系统配置</a> &rarr; '.$tit : $module_path;
if($lastLinkName != $tit){ $module_path .= "&nbsp;|&nbsp;".$tit; }

#print __FILE__.": module_path:[$module_path] hm:[".$gtbl->toString($hm)."] tbl:[$tbl] levelcode:[$levelcode] codelist:[$codelist]\n";

$url = mkUrl("jdo.php", $_REQUEST, $gtbl); # ".($isheader?"</h3>":"")." 

$out .= "<table align=\"center\" width=\"98%\"  style=\"background:transparent\">";
$out .= "<tr><td width=\"40%\" ".($isheader?"class=\"f17px\"":"").">  <b> &Pi; <a href=\"./\">首页</a> <span class=\"f17px\">&rarr;</span> ".$module_path." </b> </td>";

$out .= "<td style=\"text-align:left\" colspan=\"18\">
    &nbsp;&nbsp; <button onclick=\"javascript:doActionEx('".$url."&act=add','contentarea');\">新增</button>";

$refArr = $gtbl->getRelatedRef($url."&act=list"); # related ref, added on Thu Apr 12 18:54:43 CST 2012
#print_r($refArr);
if(count($refArr) > 0){
    foreach($refArr as $k=>$v){
        $tmphref = $v['href'];
        $isjs = 0;
        if($tmphref == 'JS'){
            $tmphref = $v['target'];
            $isjs = 1;
        }
        if($isjs==0 && strpos($tmphref,"sid=") === false){
            if(strpos($tmphref,"?") === false){
                $tmphref .= "?sid=".$sid;
            }else{
                $tmphref .= "&sid=".$sid;
            }
        }
        if($isjs == 0){
            $out .= "&nbsp; <button onclick=\"javascript:doActionEx('".$tmphref."','".($v['target']==''?'contentarea':$v['target'])."');\">".$v['name']."</button>";
        }else{
            $out .= "&nbsp; <button onclick=\"javascript:".$tmphref."\">".$v['name']."</button>";
        }
    }
}

$out .= "&nbsp;&nbsp;<button id=\"refreshbtn\" name=\"refreshbtn\" onclick=\"javascript:window.location.reload();\" title=\"刷新\">刷新</button> &nbsp;&nbsp; &nbsp;</td></tr>";

$out .= "</table>";

$out .= "<div id=\"contentarea_outer\" style=\"display:none;border:0px dotted green; width:98%; margin-left:auto; margin-right:auto;\">";
    $out .= "<div id=\"close_span\" style=\"text-align:right;height:10px;clear:both;\"><button id=\"btn_close\" onclick=\"javascript:switchArea('contentarea_outer','off');\">X Close</button>&nbsp;&nbsp;&nbsp;</div>";
$out .= "<br/><div id=\"contentarea\" style=\"postion:absolute;\" align=\"center\"></div></div>\n";

$out .= "<span id=\"addarea\"></span> <span id=\"loadarea\"></span>\n";
$out .= "<div id=\"actarea\" align=\"center\"><br/><br/><span style=\"margin-left:38px;\"> Loading...... <a href=\"javascript:doAction('".$url."&act=list');\"> 手工加载列表 </a> </span><br/><br/> &nbsp;</div>\n";
$out .= "<div id=\"tagmenu\" style=\"position:absolute;left:-50px;\"></div>";
$out .= "<div id=\"addareaextradiv\" onmousedown=\"javascript:fDragging(this, event, true);\" class=\"div\" style=\"position:absolute;width: 350px;left:250px; top:250px;z-index:11; display:none\"><span id=\"addareaextratitle\" style=\"background:#5f8ac5;width:100%;height:20;\">\n";

$out .= "<table style=\"color:white;font-weight:bold;\" id=\"addareaextratab\"><tr><td width=\"99%\">addarea&nbsp;</td><td align=\"right\"> <button name=\"cancelbtn\" id=\"cancelbtn\" onclick=\"javascript:var a1706=document.getElementById('addareaextradiv'); if(a1706 != null){ a1706.style.display='none';}\">&nbsp;X&nbsp;</button> </td></tr></table> </span> <span id=\"addareaextra\"></span> </div>\n";

if($act == ''){
    $out .= "<script type=\"text/javascript\">doAction('".$url."&act=list');</script>\n";
}else{
    $out .= "<script type=\"text/javascript\">doActionEx('".$url."&act=".$act."','contentarea');</script>\n";
}

$out .= "<!--bottom line-->";

$out .= "<table align=\"center\" width=\"98%\"  style=\"background:transparent\"> <tr><td width=\"25%\" colspan=\"4\"> <b>  &Pi; <a href=\"./\">首页</a> <span style=\"font-size:17px\">&rarr;</span> ".$module_path." </b> &nbsp; </td>";
$out .= "<td style=\"text-align:left;margin-right:58px\" colspan=\"15\"> &nbsp;  <button onclick=\"javascript:doActionEx('".$url."&act=add','contentarea');\">新增</button>  &nbsp;&nbsp; <button id=\"refrehbtn2\" name=\"refreshbtn2\" onclick=\"javascript:window.location.reload();\" title=\"刷新\">刷新</button>  &nbsp;&nbsp;&nbsp; </td> </tr></table>\n";

$out_footer = "<hr width=\"1\"/> &nbsp;&nbsp;&nbsp;<span id=\"noticediv\" style=\"color:green;\"> </span>";

$gtbl = null;
$hmconf = null;

}

$smttpl = getSmtTpl(__FILE__,$act='');
$smt->assign('welcomemsg',$welcomemsg);

$smt->assign('isheader', $isheader);
$smt->assign('out_header', $out_header);
$smt->assign('out_footer', $out_footer);

$smt->assign('content',$out);
$smt->assign('rtvdir', $rtvdir);
$smt->assign('randi', rand(0,999999).rand(0,999999));

require("./comm/footer.inc.php");

#print $out;

?>
