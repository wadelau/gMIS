<?php

# get detail module path
# Xenxin@Ufqi, Thu, 20 Jul 2017 22:18:30 +0800

$levelcode = Wht::get($_REQUEST, 'levelcode');
if($levelcode == ''){ $levelcode = Wht::get($_REQUEST, 'navidir'); } # by Wadelau, Jan 27, 2018
$theGtbl = $gtbl; //- 12:31 2020-12-25
if(true){
	$mainDb = GConf::get('maindb');
	if($db != $mainDb){
		$hmconf[0]['db'] = $mainDb;
		$theGtbl = new GTbl($tbl, $hmconf[0], $elementsep, $tblrotate);
		//debug('comm/modulepat: gtbl re-init.');
	}
}
if($levelcode == ''){
    $hm = $theGtbl->execBy("select levelcode, linkname, modulename from ".$_CONFIG['tblpre']
            ."info_menulist where modulename in ('".str_replace($_CONFIG['tblpre'],"",$tbl)."', '".$tbl."')",
            null,
            $withCache=array('key'=>'info_menulist-select-'.$tbl));
    #debug($hm);
    if($hm[0]){
        $levelcode = $hm[1][0]['levelcode'];
    }
}
$lastLinkName = '';
if($levelcode != ''){
    $codelist = substr($levelcode,0,2)."','".substr($levelcode,0,4)."','".substr($levelcode,0,6)."','"
            .substr($levelcode,0,8).substr($levelcode,0,10).substr($levelcode,0,12)
			.substr($levelcode,0,14); # max 7 levels allowed; # max 4 levels allowed
    $hm = $theGtbl->execBy("select levelcode, linkname, modulename, thedb from "
            .$_CONFIG['tblpre']."info_menulist where levelcode in ('"
            .$codelist."') order by levelcode", null,
            $withCache=array('key'=>'info_menulist-select-level-'.$codelist));
    if($hm[0]){
        $hm = $hm[1]; #print_r($hm);
        foreach($hm as $k=>$v){
            if($v['modulename'] != ''){
                $module_path .= "<a href='".$ido."&tbl=".$v['modulename']."&db=".$v['thedb']."'>"
                        .$v['linkname']."</a> &rarr; ";
            }
            else{
                $module_path .= "<a href='".$url."&navidir=".$v['levelcode']."'>"
                        .$v['linkname']."</a> &rarr; ";
            }
            $lastLinkName = $v['linkname'];
        }
        $module_path = substr($module_path, 0, strlen($module_path)-7); # '&rarr; '
    }
}
$data['modulename'] = $lastLinkName=='' ? $lang->get('navi_desktop_setting') : $lastLinkName;
$tit = $tit=='' ? $tbl : $tit;
$module_path = $module_path == '' ? '<a href="'.$url.'&navidir=99">'.$lang->get('navi_desktop_setting').'</a> &rarr; '.$tit : $module_path;
if($lastLinkName != $tit){ $module_path .= "&nbsp;|&nbsp;".($tit==''?$lastLinkName:$tit); }
$module_path = "<b> &Pi; <a href=\"".$url."\">".$lang->get('navi_homepage')."</a> "
        ."<span class=\"f17px\">&rarr;</span> ".$module_path." ".($db==''?'':'@ '.$db)." "
	.($tblrotate=='' ? '' : $theGtbl->getTblRotateName($tblrotate))."</b> ";

?>
