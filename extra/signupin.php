<?php


require("../comm/header.inc.php");
#require("../class/gtbl.class.php");

$_REQUEST['tbl'] = $_CONFIG['tblpre'].'info_usertbl';

$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$tbl = $_REQUEST['tbl'];
$mydb = $_CONFIG['appname'].'db';
$db = $_REQUEST['db']==''?$mydb:str_replace('<', '&lt;', $_REQUEST['db']);
$field = $_REQUEST['field'];
$url = $_SERVER['PHP_SELF']."?bkl=".str_replace('<', '&lt;', $_REQUEST['bkl']);

$smttpl = getSmtTpl(__FILE__,$act);

#print_r($_SERVER);

if($act == 'signin'){
    /*
    $out .= "<fieldset><legend>用户登录</legend>
        <form name='user_signin' id='user_signin' method='post' action='".$url."&act=dosignin'>
        <br/>
        电子邮箱: <br/><input name='email' id='email' />
        <br/><br/>
        密码: <br/><input type='password' name='password' id='password' />
        <br/><br/><input type='submit' name='submitbtn' id='submitbtn' />
        </form>
        </fieldset>";
    */
    $smt->assign('action',$url.'&act=dosignin');
    $smt->assign('title','用户登录');
	$smt->assign('bkl', $_REQUEST['bkl']);

}else if($act == 'dosignin'){
    
    $issucc = false;
    $nexturl = '';
	$islan = false;
    $myip = Wht::getIp();
    if(cidr_match($myip, '10.0.0.0/8') || cidr_match($myip, '172.16.0.0/12') 
            || cidr_match($myip, '192.168.0.0/16')){
        $islan = true;
    }
    #debug(__FILE__.": myip:$myip islan:$islan");
    
    $verifycode = strtoupper(trim($_REQUEST['verifycode']));
    if($islan || ($verifycode != '' && $verifycode == $_SESSION['verifycode'])){
         
    $user->set('email',$_REQUEST['email']);
    $user->set('password',$_REQUEST['password']);
    $hm = $user->getBy("*", "email=? and state=1");
    $result = '';
    if($hm[0]){
        $hm = $hm[1][0]; # refer to /inc/dba.class.php for the return data structure
        //print_r($hm);
        if($hm['password'] == SHA1($user->get('password'))){

            $user->setId($hm['id']); 
            $_SESSION[UID] = $user->getId();
            $userid = $_SESSION[UID];
            $result .= '<br/><br/>很好! 登录成功！ 欢迎回来, '.$user->getEmail()." !";

			$bkl = Base62x::decode($_REQUEST['bkl']);
            if($bkl != ''){ 
                //- go to $thisurl
				$nexturl = $bkl;
            }else{
                //- 
                $nexturl = $rtvdir."/";
            }
            $issucc = true;

        }else{
            
            $result .= "login failed. 1201302219. <!-- orig:[".$hm['password']."] new:[".SHA1($user->get('password'))."] -->";
        }

    }else{
        $result .= "login failed. 1201302217.";
    }
    }
    else{
        $result .= "login failed [验证码错误]. 1309151658.";
    }

    if(!$issucc){
        $nexturl = $url."&act=signin";
    }
    $smt->assign('title','登录消息');
    $smt->assign('result', $result);
    $smt->assign('nexturl', $nexturl);

}else if($act == 'signout'){
    $user->setId(''); 
    $_SESSION[UID] = $user->getId();
    $userid = $_SESSION[UID];
    
    $smt->assign('result', $result = '成功退出系统, 欢迎下次再来.');
    $smt->assign('nexturl', $nexturl = $url.'&act=signin');

}else if($act == 'resetpwd'){

    if($userid == $_REQUEST['userid']){
        $issubmit = $_REQUEST['issubmit'];
        if($issubmit == 1){
            $newpwd = sha1($_REQUEST['newpwd']);
            $user->execBy("update ".$_CONFIG['tblpre']."info_usertbl set password='".$newpwd."' where id='".$userid."' limit 1", null);
            $result = "成功！ 用户 [userid:".$userid."] 的密码已经重置为:[".$_REQUEST['newpwd']."].";
            $nexturl = $rtvdir."/ido.php?tbl=".$_CONFIG['tblpre']."info_usertbl&tit=&db=";
        }else{
            $nexturl = $rtvdir."/ido.php?tbl=".$_CONFIG['tblpre']."info_usertbl&tit=&db=";
            $result = "";
            $result .= " Loading.... <script type=\"text/javascript\">var newpwd=window.prompt('请输入新密码','');if(newpwd!=''){window.top.location.href='".$rtvdir."/extra/signupin.php?act=resetpwd&userid=".$userid."&issubmit=1&newpwd='+newpwd;}else{document.location.href='".$nexturl."';}</script>";
            $result .= "失败！ 重置密码失败，请重试. 201205092158."; 
        }
    }else if($user->getGroup() == 1){ # admin group

        $newpwd = $newpwd_orig = rand(0,999).rand(0,999);
        $newpwd = SHA1($newpwd);
        $newuserid = $_REQUEST['userid'];
        if($newuserid != ''){
            $user->execBy("update ".$_CONFIG['tblpre']."info_usertbl set password='".$newpwd."' where id='".$newuserid."' limit 1", null);
            $result = "成功！ 用户 [userid:".$newuserid."] 的密码已经重置为:[".$newpwd_orig."].";
            $nexturl = $rtvdir."/ido.php?tbl=".$_CONFIG['tblpre']."info_usertbl&tit=&db=";
        }else{
            $result = "失败！ 重置密码失败，请重试. 201204291947."; 
            $nexturl = $rtvdir."/ido.php?tbl=".$_CONFIG['tblpre']."info_usertbl&tit=&db=";
        }

    }else{
        $result = "失败！ 重置密码失败，请重试. 201204292008."; 
        $nexturl = $rtvdir."/ido.php?tbl=".$_CONFIG['tblpre']."info_usertbl&tit=&db=";
    }

    $smt->assign('result', $result);
    $smt->assign('nexturl', $nexturl);
}

$smt->assign('rtvdir', $rtvdir);

# private ip identified, 20:50 07 December 2016
function cidr_match($ip, $range){
    list ($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
    return ($ip & $mask) == $subnet;
}

require("../comm/footer.inc.php");

#print $out; # disabled after Smarty since Tue Feb 14 22:52:20 CST 2012

?>
