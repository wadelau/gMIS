<?php

$_REQUEST['tbl'] = ''; #  'fin_todotbl'; Wed Oct 22 09:10:01 CST 2014

require("./comm/header.inc.php");
$data['title'] = $_CONFIG['agentname'];
$out = str_replace('TITLE', $data['title'], $out);

$gtbl = new WebApp();

$module_list = ""; $hm_module_order = array();  $hm_module_name = array(); $hm_todo_list = array();
$hm_module_db = array();
$moduleNeedDb = '';

$hm = $gtbl->execBy($sql="select * from ".$_CONFIG['tblpre']."fin_todotbl where 1=1 and (togroup in (" # for multiple groups
        .$user->getGroup().") or touser=".$user->getId()." or triggerbyparent in (".$user->getGroup().") or triggerbyparentid="
        .$user->getId().") and istate in (1,2) and pid=0 order by istate desc, id desc limit 7 ", null,
		$withCache=array('key'=>'info_todo-select-'.$user->getId()));
if($hm[0]){
    $hm = $hm[1];
    foreach ($hm as $k=>$v){
        $hm_todo_list[$v['id']] = $v;
    }
}
$data['todo_state'] = array('0'=>'已完成', '1'=>'待做', '2'=>'进行中', '3'=>'擱置', '4'=>'取消');
$data['user_list'] = $user->getUserList();

$mycachedate=date("Y-m-d", time()-(86400*60));
$hm = $gtbl->execBy("select count(parenttype) as modulecount, parenttype from "
        .$_CONFIG['tblpre']."fin_operatelogtbl where inserttime > '"
        .$mycachedate." 00:00:00' and parenttype not in ('gmis_info_usertbl', 'gmis_fin_todotbl')"
        ." group by parenttype order by modulecount desc limit 11", null,
	$withCache=array('key'=>'fin_operatelog-select-'.$mycachedate));
if($hm[0]){
	$hm = $hm[1];
	if(is_array($hm)){
	foreach($hm as $k=>$v){
		$module_list .= "'".$v['parenttype']."',";
		$hm_module_order[$k] = $v['parenttype'];
	}
	}
	$module_list = substr($module_list, 0, strlen($module_list)-1);
	$hm = $gtbl->execBY("select objname,tblname from "
	        .$_CONFIG['tblpre']."info_objecttbl where tblname in ($module_list)", null,
		$withCache=array('key'=>'info_object-select-'.$module_list));
	if($hm[0]){
		$hm = $hm[1];
		if(is_array($hm)){
		foreach($hm as $k=>$v){
			$hm_module_name[$v['tblname']] = $v['objname'];
		}
		}
	}
	$moduleNeedDb = $module_list;
}

#
$hm = $gtbl->execBy("select objname,tblname from "
        .$_CONFIG['tblpre']."info_objecttbl where addtodesktop > 0 order by addtodesktop", null,
	$withCache=array('key'=>'info_object-select-desktop'));
if($hm[0]){
	$hm = $hm[1];
	$data['module_list_byuser'] = $hm; #Todo add2desktop by user
}
else{
    $hm = $gtbl->execBy("select objname,tblname from ".$_CONFIG['tblpre']."info_objecttbl order by rand() limit 11",
            null, $withCache=array('key'=>'info_object-select-desktop-rand'));
    if($hm[0]){
        $hm = $hm[1];
        $data['module_list_byuser'] = $hm;
    }
}

#
$module_list = '';
foreach($data['module_list_byuser'] as $k=>$v){
    $module_list .= "'".$v['parenttype']."',";
    $module_list = substr($module_list, 0, strlen($module_list)-1);
}
$moduleNeedDb .= ','.$module_list;
$hm = $gtbl->execBY("select modulename,thedb from ".$_CONFIG['tblpre']
        ."info_menulist where modulename in ($moduleNeedDb)", null,
        $withCache=array('key'=>'info_menulist-select-'.$module_list));
if($hm[0]){
    $hm = $hm[1];
    foreach($hm as $k=>$v){
        $hm_module_db[$v['modulename']] = $v['thedb'];
    }
}

#
$hm = $gtbl->execBy("select count(*) as modulecount from ".$_CONFIG['tblpre']."info_objecttbl where istate=1", null,
	$withCache=array('key'=>'info_object-select-count'));
if($hm[0]){
	$hm = $hm[1];
	$data['module_count'] = $hm[0]['modulecount'];
}

$userListOL = array();
$hm = $gtbl->execBy("select id, email from "
	.$_CONFIG['tblpre']."info_usertbl where istate=1", null, 
	$withCache=array('key'=>'info_user-select-count'));
if($hm[0]){
	$hm = $hm[1];
	$data['user_count'] = count($hm);
	foreach($hm as $k=>$v){
        $userListOL[$v['id']] = $v['email'];
    }
}

$hm = $gtbl->execBy("select * from ".$_CONFIG['tblpre']."fin_operatelogtbl order by ".$gtbl->getMyId()." desc limit 7",
        null, $withCache=array('key'=>'info_user-select-count'));
if($hm[0]){
	$hm = $hm[1];
	$data['log_list'] = $hm;
}

# dir list, added by wadelau@ufqi.com, Sat Mar 12 12:45:24 CST 2016
$navidir = $_REQUEST['navidir'];
if($navidir != ''){
	$hm = $gtbl->execBy("select * from ".$_CONFIG['tblpre']."info_menulist where levelcode='".$navidir
	        ."' or levelcode like '".$navidir."__'  order by levelcode", null,
	        $withCache=array('key'=>'info_menulist-select-by-level-'.$navidir));
	if($hm[0]){
		$hm = $hm[1];
		$data['navidir_list'] = $hm;
	}
	#debug($hm, '', 1);
}

$fp = fopen("./ido.php", "r");
if($fp){
	$fstat = fstat($fp);
	fclose($fp);
	$mtime = $fstat['mtime'];
	$data['system_lastmodify'] = date("Y-m-d", $mtime);
}
$data['start_date'] = $_CONFIG['start_date'];

# today's users count
$logged_user_count = 1;
$mycachedate=date("Y-m-d", time()-(86400*1));
$hm = $gtbl->execBy("select userid from "
        .$_CONFIG['tblpre']."fin_operatelogtbl where inserttime >= '"
        .$mycachedate." 00:00:00'" #
        ." group by userid", null,
        $withCache=array('key'=>'fin_operatelog-select-usercount-'.$user->getId().'-'.$mycachedate));
if($hm[0]){
    #debug($hm);
    $hm = $hm[1];
    $logged_user_count = count($hm);
}

# module path
$module_path = ''; $levelcode = ''; $codelist = '';
include_once($appdir."/comm/modulepath.inc.php");

$data['logged_user_count'] = $logged_user_count;
$data['module_list_order'] = $hm_module_order;
$data['module_list_name'] = $hm_module_name;
$data['module_list_db'] = $hm_module_db;
$data['todo_list'] = $hm_todo_list;
$data['module_path'] = $module_path;
$data['user_list_ol'] = $userListOL;

$smttpl = getSmtTpl(__FILE__, $act);

$smt->assign('agentname', $_CONFIG['agentname']);
$smt->assign('welcomemsg',$welcomemsg);
$smt->assign('desktopurl', $url);
$smt->assign('url', $url);
$smt->assign('ido', $ido);
$smt->assign('jdo', $jdo);
$smt->assign('today', date("Y-m-d"));
$smt->assign('historyurl', $ido.'&tbl=info_operatelogtbl&tit=操作历史记录&a1=0&pnsktogroup='
	.$user->getGroup().'&pnskuserid='.$userid);

$navi = new PageNavi();

$pnsc = "state=? and (touser like '".$user->getId()."' or togroup like '".$user->getGroup()."')";
$smt->assign('todourl','ido.php?tbl=fin_todotbl&tit=待处理任务&a1=1&pnskistate=0&pnsm=1&pnsktouser='.$userid
	.'&pnsc='.$pnsc.'&pnsck='.$navi->signPara($pnsc).'&pnsktogroup='.$user->getGroup());

$smt->assign('sid', $sid);
$smt->assign('userid', $userid);
$smt->assign('content',$out);
$smt->assign('rtvdir', $rtvdir);
$smt->assign('isheader', $isheader);
$smt->assign('watch_interval', $_CONFIG['watch_interval']);

require("./comm/footer.inc.php");

?>
