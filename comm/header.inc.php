<?php
//- embedded in app entry

global $appdir, $userid, $user, $gtbl, $out, $data;
date_default_timezone_set("Asia/Chongqing");

$docroot = $_SERVER['DOCUMENT_ROOT'];
$rtvdir = dirname(dirname(__FILE__)); # relative dir
$rtvdir = str_replace($docroot,"", $rtvdir);
$appdir = $docroot.$rtvdir;
if($rtvdir == ''){
	$tmpDirArr = explode("/", $_SERVER['PHP_SELF']);
	$rtvdir = '/'.$tmpDirArr[1];
	$tmpDirArr = null;
}
#print "docroot:[$docroot] rtvdir:[$rtvdir] appdir:[$appdir].";

$dirArr = explode("/", $rtvdir);
$shortDirName = $dirArr[count($dirArr)-1];
# the name of gMIS subdir, i.e. admin, mgmt ...Sat May 23 22:43:21 CST 2015

require_once($appdir."/inc/config.class.php");
$is_debug = $_CONFIG['is_debug'];
if($is_debug){
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	error_reporting(-1);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	ini_set("display_errors", 1);
}
else{
    header("Cache-Control: max-age=604800"); # a week?
    error_reporting(E_ERROR | E_PARSE);
    ini_set('error_reporting', E_ERROR | E_PARSE);
    ini_set("display_errors", 0);
}

require_once($appdir."/class/user.class.php");
require_once($appdir."/comm/tools.function.php");
require($appdir."/class/gtbl.class.php");
require($appdir."/class/pagenavi.class.php");
require_once($appdir."/class/base62x.class.php");

#session_start();
# in initial stage, using php built-in session manager
# implemented with no storage session by Xenxin@ufqi.com, Tue, 7 Mar 2017 22:54:31 +0800
define(UID, $_CONFIG['agentalias'].'_user_id');
define(SID, 'sid');

if(!isset($user)){
    $user = new User();
    $user->setTbl($_CONFIG['tblpre']."info_usertbl");
}

$userid = ''; $out = ''; $htmlheader = ''; $data = array();
$reqUri = $_SERVER['REQUEST_URI'];
$reqUri = startsWith($reqUri, '/') ? $reqUri : '/'.$reqUri;
$reqUri = str_replace('jdo.php', 'ido.php', $reqUri);
$thisUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$reqUri}";

$sid = Wht::get($_REQUEST, SID);
$userid = $user->getUserBySession($_REQUEST);
if($userid != ''){
    $user->setId($userid);
}
else if(strpos($_SERVER['PHP_SELF'],'signupin.php') === false
	&& strpos($_SERVER['PHP_SELF'],'readtblfield.php') === false){// ?
    header("Location: ".$rtvdir."/extra/signupin.php?act=signin&bkl=".Base62x::encode($thisUrl));
	exit(0);
}

$ido = $rtvdir.'/ido.php?'.SID.'='.$sid;
$jdo = $rtvdir.'/jdo.php?'.SID.'='.$sid;
$url = $rtvdir.'/?'.SID.'='.$sid;

if(!isset($isoput)){
    $isoput = true;
}
# convert user input data to variables, tag#userdatatovar
foreach($_REQUEST as $k=>$v){
    $k = trim($k);
    if($k != ''){
        if(preg_match("/([0-9a-z_]+)/i",$k,$matcharr)){
            $k_orig = $k = $matcharr[1];
			if(is_string($v)){
				$v = trim($v);
				if(stripos($v, "<") > -1){
				    # <script , <embed, <img, <iframe, etc.  Mon Feb  1 14:48:32 CST 2016
					$v = str_ireplace("<", "&lt;", $v);
					$_REQUEST[$k] = $v;
				}
			}
            $data[$k] = $v;
            if(preg_match('/[^\x20-\x7e]/', $k)){
                eval("\${$k} = \"$v\";");
            }
        }
		else{
        }
  	}
}
if(isset($_REQUEST['isoput'])){
    if($_REQUEST['isoput'] == 1){
        $isoput = true;
    }
    else{
        $isoput = false;
    }
}
if(!isset($isheader)){
    $isheader = true;
}
if(isset($_REQUEST['isheader'])){
    if($_REQUEST['isheader'] == 1){
        $isheader = true;
    }
    else{
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
            <script type="text/javascript" src="'.$rtvdir.'/comm/GTAjax-5.5.js" charset=\"utf-8\" async></script>
            <script type="text/javascript" src="'.$rtvdir.'/comm/ido.js?i='
                    .($is_debug==1?rand(0,9999):'').'" charset=\"utf-8\" async></script>
            <script type="text/javascript" src="'.$rtvdir.'/comm/ido_proj.js?i='
                    .($is_debug==1?rand(0,9999):'').'" charset=\"utf-8\" async></script>
            <script type="text/javascript" src="'.$rtvdir.'/comm/popdiv.js" charset=\"utf-8\" async></script>
            <script type="text/javascript" src="'.$rtvdir.'/comm/navimenu/navimenu.js" charset=\"utf-8\" async></script>
			<script type="text/javascript" src="'.$rtvdir.'/comm/Base62x.class.js" charset=\"utf-8\" async></script>
            <link rel="stylesheet" type="text/css" href="'.$rtvdir.'/comm/navimenu/navimenu.css" />
            </head>
            <body> <!--  style="'.($isheader==0?"":"width:880px").'" -->';
    }

    if($isheader){
        if($userid != ''){
            $welcomemsg .= "Welcome, ";
            $welcomemsg .= "<a href='".$rtvdir."/ido.php?tbl=info_usertbl&id=".$userid
                ."&act=view' class='whitelink'>";
            $welcomemsg .= $user->getEmail()."</a> !</b>&nbsp; ";
            $welcomemsg .= "<a href=\"".$rtvdir."/extra/signupin.php?act=resetpwd&userid="
                    .$userid."\" class='whitelink'>重置密码</a> &nbsp;.&nbsp;<a href=\""
                    .$rtvdir."/extra/signupin.php?act=signout&bkl=".Base62x::encode($thisUrl)."\"";
            $welcomemsg .= " class='whitelink'>退出</a> &nbsp;";

            $menulist = '';
            include($appdir."/comm/navimenu/navimenu.php");

            $out .= "<div style=\"width:100%;clear:both\" id=\"navimenu\">".$menulist."</div>";

            //show message number if there are new messages.
            $out .= "<div id=\"a_separator\" style=\"height:10px;margin-top:25px;clear:both\"></div>"
                    ."<!-- height:15px;margin-top:8px;clear:both;text-align:center;z-index:99 -->";

        }
    }
    else if(!startsWith($act, "modify") && !inString('-addform', $act)){
        $out .= "<style>html{background:white;}</style>";
    }
}

# initialize new parameters
$i = $j = $id = 0; $randi =0;
$tbl = $field = $fieldv = $fieldargv = $act = '';
$xmlpathpre = $appdir."/xml";
$elementsep = $_CONFIG['septag'];
$db = $_REQUEST['db']; # data db which may differs from $mydb, see ido.php and comm/tblconf.php
$mydb = $_CONFIG['dbname']; # main db on which the app relies
$db = $db=='' ? $mydb : $db;
$tit = $_REQUEST['tit'];
$tbl = $_REQUEST['tbl'];
$tblrotate = $_REQUEST['tblrotate'];
$act = $_REQUEST['act'];
$tit = $tit==''?$tbl:$tit;
$id = isset($_REQUEST['pnskid']) ? $_REQUEST['pnskid'] : $_REQUEST['id'];
$fmt = isset($_REQUEST['fmt'])?$_REQUEST['fmt']:''; # by wadelau on Tue Nov 24 21:36:56 CST 2015
if($fmt == ''){
    header("Content-type: text/html;charset=utf-8");
}
else if($fmt == 'json'){
	header("Content-type: application/json;charset=utf-8");
}
$randi = rand(100000, 999999);

if(strpos($tbl,$_CONFIG['tblpre']) !== 0){
    $tbl = $_CONFIG['tblpre'].$tbl; //- default is appending tbl prefix
}
# tbl test, see inc/webapp.class::setTbl

if(true){ # used in mix mode to cover all kinds of table with or without tbl prefix
	$oldtbl = $tbl;
	#$tbl = (new GTbl($tbl, null, ''))->setTbl($tbl);
	$tmpgtbl = new GTbl($tbl, null, '');
	$tbl = $tmpgtbl->getTbl();
	if($tbl != $oldtbl){
		$_REQUEST['tbl'] = $tbl;
	}
	$tmpgtbl = null;
}

if(isset($_REQUEST['parent'])){
	$tmpnewk = 'pnsk'.$_REQUEST['parent'];
	$_REQUEST[$tmpnewk] = $_REQUEST[$_REQUEST['parent']];
	# print "tmpnewk:[$tmpnewk] value:[".$_REQUEST[$_REQUEST['parent']]."]";
}

# check access control
$superAccess = '';
include($appdir."/act/checkaccess.inc.php");

# template file info
require($_CONFIG['smarty']."/Smarty.class.php");
$smt = new Smarty();
$viewdir = $appdir.'/view';
$smt->setTemplateDir($viewdir);
$smt->setCompileDir($viewdir.'/compile');
$smt->setConfigDir($viewdir.'/config');
$smt->setCacheDir($viewdir.'/cache');
$smttpl = '';

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
