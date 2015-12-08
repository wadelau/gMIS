<?php

global $appdir,$userid, $user, $gtbl;
date_default_timezone_set("Asia/Chongqing");

$docroot = $_SERVER['DOCUMENT_ROOT'];
$rtvdir = dirname(dirname(__FILE__)); # relative dir
$rtvdir = str_replace($docroot,"", $rtvdir);
$appdir = $docroot.$rtvdir;

$dirArr = explode("/", $rtvdir);
$shortDirName = $dirArr[count($dirArr)-1]; # the name of gMIS subdir, i.e. admin, mgmt ...Sat May 23 22:43:21 CST 2015

require_once($appdir."/inc/config.class.php");
$is_debug = $_CONFIG['is_debug'];
if($is_debug){
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
	error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(-1);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	ini_set("display_errors", 1);
}

require_once($appdir."/class/user.class.php");

require_once($appdir."/comm/tools.function.php");

require($appdir."/class/gtbl.class.php");
require($appdir."/class/pagenavi.class.php");

session_start(); # in initial stage, using php built-in session manager
define('UID',$_CONFIG['agentalias'].'_user_id');

if(!isset($user)){
    $user = new User(); 
    $user->setTbl($_CONFIG['tblpre']."info_usertbl");
} 

$userid = '';
$out = ''; $htmlheader = '';
if(array_key_exists(UID,$_SESSION) && $_SESSION[UID] != '')
{
	$userid = $_SESSION[UID];
}
if($userid != ''){
    $user->setId($userid);

}else if(strpos($_SERVER['PHP_SELF'],'signupin.php') === false
	&& strpos($_SERVER['PHP_SELF'],'readtblfield.php') === false){

    header("Location: ".$rtvdir."/extra/signupin.php?act=signin&bkl=thisurl");    
	exit(0);
}

#print "userid:$userid\n";

if(!isset($isoput)){
    $isoput = true;
}else{

}

if(isset($_REQUEST['isoput'])){
    if($_REQUEST['isoput'] == 1){
        $isoput = true;
    }else{
        $isoput = false;
    }
} 

if(!isset($isheader)){
    $isheader = true;
}
if(isset($_REQUEST['isheader'])){
    if($_REQUEST['isheader'] == 1){
        $isheader = true;
    }else{
        $isheader = false;
    }
} 

if($isoput){
    if(!$isheader){ 
		# another place at view/header.html!
        $htmlheader = '<!DOCTYPE html><html>
            <head>
            <!-- other stuff in header.inc -->
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
            <title>TITLE - '.$_CONFIG['appname'].' -'.$_CONFIG['agentname'].'</title>
            <link rel="stylesheet" type="text/css" href="'.$rtvdir.'/comm/default.css" />
            <script type="text/javascript" language="javascript" src="'.$rtvdir.'/comm/GTAjax-5.3.js" charset=\"utf-8\"></script>
            <script type="text/javascript" language="javascript" src="'.$rtvdir.'/comm/ido.js?i='.rand(0,9999).'" charset=\"utf-8\"></script>
            <script type="text/javascript" language="javascript" src="'.$rtvdir.'/comm/popdiv.js" charset=\"utf-8\"></script>
            <script type="text/javascript" language="javascript" src="'.$rtvdir.'/comm/navimenu/navimenu.js" charset=\"utf-8\"></script>

            <link rel="stylesheet" type="text/css" href="'.$rtvdir.'/comm/navimenu/navimenu.css" />
            </head>
            <body> <!--  style="'.($isheader==0?"":"width:880px").'" -->';
    }

    if($isheader){
        if(array_key_exists(UID,$_SESSION) && $_SESSION[UID] != ''){
            $welcomemsg .= "Welcome, ";

            $welcomemsg .= "<a href='".$rtvdir."/ido.php?tbl=info_usertbl&id=".$userid."&act=view' class='whitelink'>";
            $welcomemsg .= $user->getEmail()."</a> !</b>&nbsp; ";
            $welcomemsg .= "<a href=\"".$rtvdir."/extra/signupin.php?act=resetpwd&userid=".$userid."\" class='whitelink'>重置密码</a> &nbsp;.&nbsp;<a href=\"".$rtvdir."/extra/signupin.php?act=signout&bkl=thisurl\"";
            $welcomemsg .= " class='whitelink'>退出</a> &nbsp;";

            $menulist = '';
            include($appdir."/comm/navimenu/navimenu.php");

            $out .= "<div style=\"width:100%;clear:both\" id=\"navimenu\">".$menulist."</div>";

            //show message number if there are new messages.
            $out .= "<div id=\"a_separator\" style=\"height:10px;margin-top:25px;clear:both\"></div><!-- height:15px;margin-top:8px;clear:both;text-align:center;z-index:99 -->";

        }

    }else{

        $out .= "<style>html{background:white;}</style>";
    } 
}

# initialize new parameters
$i = $j = $id = 0;
$tbl = $field = $fieldv = $fieldargv = $url = $act = '';
$xmlpathpre = $appdir."/xml";
$elementsep = $_CONFIG['septag'];
$db = $_REQUEST['db'];
$mydb = $_CONFIG['dbname'];
$db = $db==''?$mydb:$db;
$tit = $_REQUEST['tit'];
$tbl = $_REQUEST['tbl'];
$tblrotate = $_REQUEST['tblrotate'];
$act = $_REQUEST['act'];
$tit = $tit==''?$tbl:$tit;
$id = $_REQUEST['id'];

if(strpos($tbl,$_CONFIG['tblpre']) !== 0){
    $tbl = $_CONFIG['tblpre'].$tbl; # 兼容不是以 hss_ 开头的表名
}
if(isset($_REQUEST['parent'])){
	$tmpnewk = 'pnsk'.$_REQUEST['parent'];
	$_REQUEST[$tmpnewk] = $_REQUEST[$_REQUEST['parent']]; 	
	# print "tmpnewk:[$tmpnewk] value:[".$_REQUEST[$_REQUEST['parent']]."]";
}

# check access control
$superAccess = '';
include($appdir."/act/checkaccess.inc");

# template file info
require($_CONFIG['smarty']."/Smarty.class.php");
$smt = new Smarty();
$viewdir = $appdir.'/view';
$smt->setTemplateDir($viewdir);
$smt->setCompileDir($viewdir.'/compile');
$smt->setConfigDir($viewdir.'/config');
$smt->setCacheDir($viewdir.'/cache');
$smttpl = '';
global $data;
$data = array();
$fmt = isset($_REQUEST['fmt'])?$_REQUEST['fmt']:''; # by wadelau on Tue Nov 24 21:36:56 CST 2015
if($fmt == ''){
	header("Content-type: text/html;charset=utf-8");
}

function exception_handler($exception) {
	echo '<div class="alert alert-danger">';
	echo '<b>Fatal error</b>:  Uncaught exception \'' . get_class($exception) . '\' with message ';
	echo $exception->getMessage() . ' .<br/> <!--- please refer to server log. --> Please report this to administrators.';
	# hide sensitive information about server and script location from public.
	error_log($exception->getTraceAsString());
	error_log("thrown in [" . $exception->getFile() . "] on line:[".$exception->getLine()."].");
	echo '</div>';
}
set_exception_handler('exception_handler');

?>
