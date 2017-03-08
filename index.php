<?php

$_REQUEST['tbl'] = ''; #  'fin_todotbl'; Wed Oct 22 09:10:01 CST 2014

require("./comm/header.inc.php");

$out = str_replace('TITLE','欢迎', $out);  $data['title'] = '欢迎';

$gtbl = new WebApp();

$module_list = ""; $hm_module_order = array();  $hm_module_name = array(); $hm_todo_list = array();

$hm = $gtbl->execBy($sql="select * from ".$_CONFIG['tblpre']."fin_todotbl where (togroup in (" # for multiple groups
        .$user->getGroup().") or touser=".$user->getId().") and state in (1,2) order by state desc, id desc limit 6 ", null,
		$withCache=array('key'=>'info_todo-select-'.$user->getId()));
if($hm[0]){
    $hm = $hm[1];
    foreach ($hm as $k=>$v){
        $hm_todo_list[$v['id']] = $v;
    }
}
$data['todo_state'] = array('0'=>'已完成', '1'=>'待做', '2'=>'进行中', '3'=>'擱置', '4'=>'取消');
$data['user_list'] = $user->getUserList();

$hm = $gtbl->execBy("select count(parenttype) as modulecount, parenttype from "
        .$_CONFIG['tblpre']."fin_operatelogtbl where inserttime > '"
        .date("Y-m-d", time()-(86400*60))." 00:00:00' group by parenttype order by modulecount desc limit 8", null,
	$withCache=array('key'=>'fin_operatelog-select-'.$mycachedate));
if($hm[0]){
	$hm = $hm[1];
	foreach($hm as $k=>$v){
		$module_list .= "'".$v['parenttype']."',";
		$hm_module_order[$k] = $v['parenttype']; 
	}
	$module_list = substr($module_list, 0, strlen($module_list)-1);
	$hm = $gtbl->execBY("select objname,tblname from "
	        .$_CONFIG['tblpre']."info_objecttbl where tblname in ($module_list)", null,
		$withCache=array('key'=>'info_object-select-'.$module_list));
	if($hm[0]){
		$hm = $hm[1];
		foreach($hm as $k=>$v){
			$hm_module_name[$v['tblname']] = $v['objname'];
		}
	}
}

$hm = $gtbl->execBy("select objname,tblname from "
        .$_CONFIG['tblpre']."info_objecttbl where addtodesktop > 0 order by addtodesktop", null,
	$withCache=array('key'=>'info_object-select-desktop'));
if($hm[0]){
	$hm = $hm[1];
	$data['module_list_byuser'] = $hm; #Todo add2desktop by user 
}
else{
    $hm = $gtbl->execBy("select objname,tblname from ".$_CONFIG['tblpre']."info_objecttbl order by rand() limit 4", null,
		$withCache=array('key'=>'info_object-select-desktop-rand'));
    if($hm[0]){
        $hm = $hm[1];
        $data['module_list_byuser'] = $hm;
    }
}

$hm = $gtbl->execBy("select count(*) as modulecount from ".$_CONFIG['tblpre']."info_objecttbl where state=1", null,
	$withCache=array('key'=>'info_object-select-count'));
if($hm[0]){
	$hm = $hm[1];
	$data['module_count'] = $hm[0]['modulecount'];
}

$hm = $gtbl->execBy("select count(*) as usercount from ".$_CONFIG['tblpre']."info_usertbl where state=1");
if($hm[0]){
	$hm = $hm[1];
	$data['user_count'] = $hm[0]['usercount'];
}

$hm = $gtbl->execBy("select * from ".$_CONFIG['tblpre']."fin_operatelogtbl order by ".$gtbl->getMyId()." desc limit 6", null,
	$withCache=array('key'=>'info_user-select-count'));
if($hm[0]){
	$hm = $hm[1];
	$data['log_list'] = $hm;
}

# dir list, added by wadelau@ufqi.com, Sat Mar 12 12:45:24 CST 2016
$navidir = $_REQUEST['navidir'];
if($navidir != ''){
	$hm = $gtbl->execBy("select * from ".$_CONFIG['tblpre']."info_menulist where levelcode='".$navidir."' or levelcode like '"
		.$navidir."__'  order by levelcode", null, $withCache=array('key'=>'info_menulist-select-by-level-'.$navidir));
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
$data['module_list_order'] = $hm_module_order;
$data['module_list_name'] = $hm_module_name;
$data['todo_list'] = $hm_todo_list;

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
$smt->assign('todourl','ido.php?tbl=fin_todotbl&tit=待处理任务&a1=1&pnskstate=0&pnsm=1&pnsktouser='.$userid
	.'&pnsc='.$pnsc.'&pnsck='.$navi->signPara($pnsc).'&pnsktogroup='.$user->getGroup());

$smt->assign('content',$out);
$smt->assign('rtvdir', $rtvdir);
$smt->assign('isheader', $isheader);

require("./comm/footer.inc.php");

?>
