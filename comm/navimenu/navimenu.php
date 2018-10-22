<?php

$myNavi = new PageNavi();
$pnscTodo = "istate in (1,2) and pid=0 and (touser like '".$user->getId()."' or togroup like '".$user->getGroup()
."' or triggerbyparentid like '".$user->getId()."' or triggerbyparent like '".$user->getGroup()."')";
$pnsckTodo = $myNavi->signPara($pnscTodo);
$pnscTodo = base62x($pnscTodo);

$pnscDone = "istate in (-2,-1,0) and pid=0 and (touser like '".$user->getId()."' or togroup like '".$user->getGroup()
."' or triggerbyparentid like '".$user->getId()."' or triggerbyparent like '".$user->getGroup()."')";
$pnsckDone = $myNavi->signPara($pnscDone);
$pnscDone = base62x($pnscDone);

$dynamicmenu = '';
$hm = $myNavi->execBy("select levelcode,linkname,modulename,dynamicpara,disptitle,thedb from "
	.$_CONFIG['tblpre']."info_menulist where istate=1 order by levelcode", null,
	$withCache=array('key'=>'navimenu-select'));

#print_r($hm);
if($hm[0]){
    $hm = $hm[1];
    $hmkeys = array();
    $hmkeysbylen = array("2"=>array(),"4"=>array(),"6"=>array(),"8"=>array(),
            "10"=>array(), "12"=>array(), "14"=>array());
    if(is_array($hm)){
		foreach($hm as $k=>$v){
			$hmkeys[$hm[$k]['levelcode']] = $hm[$k]; # use levelcode 作为key
			$hmkeysbylen[strlen($hm[$k]['levelcode'])][] = $hm[$k]['levelcode']; # 按levelcode的长度划分menu等级
		}
    }
    #print_r($hmkeys);
    #print_r($hmkeysbylen);
    for($li = 0; $li <= 99; $li++){
        $li = "".sprintf("%02d",$li);
        if(in_array($li, $hmkeysbylen[2])){
            $linfo = $hmkeys[$li];
            $dynamicmenu .= '<li><!--'.$li.'.--><a href="'.$url.'&navidir='.$linfo['levelcode']
                .'" orighref="javascript:void(0);" class="menulink">'.$linfo['linkname'].'</a>'."\n";
            $dynamicmenu .= "<ul>\n";
            $lv3 = '';
            $lv4 = ''; # @todo, lv5, lv6, lv7
            foreach($hmkeysbylen[4] as $k1=>$v1){
                if(strpos($v1,$li) === 0){
                    $linfo = $hmkeys[$v1];
                    #$dynamicmenu .= 'level2- v1:'.$v1.", \n";
                    if($linfo['modulename'] == '' && $linfo['dynamicpara'] == ''){
                        $dynamicmenu .= '<li><a href="'.$url.'&navidir='.$linfo['levelcode'].'" class="sub">'
                                   .$linfo['linkname'].'</a>'."<ul>\n<!--LEVEL-3--></ul>\n</li>\n";
                    }
                    else if($linfo['modulename'] == '' && $linfo['dynamicpara'] != ''){
                        if($linfo['disptitle'] == ''){ $linfo['disptitle'] = $linfo['linkname'];}
                        $dynamicmenu .= '<li><a href="'.$rtvdir.'/'.$linfo['dynamicpara'].'&tbl='.$tbl.'&tit='.$linfo['disptitle']
                            .'&db='.$linfo['thedb'].'&sid='.$sid.'&isheader=1&levelcode='.$linfo['levelcode'].'">'
                                    .$linfo['linkname'].'</a></li>'."\n";
                    }
					else{
						if($linfo['disptitle'] == ''){ $linfo['disptitle'] = $linfo['linkname'];}
                        $dynamicmenu .= '<li><a href="'.$ido.'&tbl='.$linfo['modulename'].'&tit='.$linfo['disptitle']
                            .'&db='.$linfo['thedb'].'&'.$linfo['dynamicpara'].'&levelcode='.$linfo['levelcode'].'">'
							.$linfo['linkname'].'</a></li>'."\n";
                    }
                    
					$lv3 = '';
                    foreach($hmkeysbylen[6] as $k2=>$v2){
                        #$lv3 .= "\tlevel3-v2:".$v2.", v1:$v1, \n";
                        if(strpos($v2, $v1) === 0){
                            $linfo = $hmkeys[$v2];
                            #$lv3 .= "\tlevel3-v2:".$v2.", v1:$v1, \n";
                            if($linfo['modulename'] == '' && $linfo['dynamicpara'] == ''){
                                $lv3 .= '<li><a href="javascript:void(0);" class="sub">'.$linfo['linkname'].'</a>'
                                        ."<ul>\n<!--LEVEL-4--></ul>\n</li>\n";
                            }
                            else if($linfo['modulename'] == '' && $linfo['dynamicpara'] != ''){
                                if($linfo['disptitle'] == ''){ $linfo['disptitle'] = $linfo['linkname'];}
                                $lv3 .= '<li><a href="'.$rtvdir.'/'.$linfo['dynamicpara'].'&tbl='.$tbl.'&tit='.$linfo['disptitle']
                                    .'&db='.$linfo['thedb'].'&sid='.$sid.'&isheader=1&levelcode='.$linfo['levelcode'].'">'
                                            .$linfo['linkname'].'</a></li>'."\n";
                            }
							else{
								if($linfo['disptitle'] == ''){ $linfo['disptitle'] = $linfo['linkname'];}
                                $lv3 .= '<li><a href="'.$ido.'&tbl='.$linfo['modulename'].'&tit='.$linfo['disptitle']
                                    .'&db='.$linfo['thedb'].'&'.$linfo['dynamicpara'].'&levelcode='.$linfo['levelcode'].'">'
									.$linfo['linkname'].'</a></li>'."\n";
                            }

							$lv4 = '';
                            foreach($hmkeysbylen[8] as $k3=>$v3){
								if(strpos($v3, $v2) === 0){
									$linfo = $hmkeys[$v3];
									#$lv4 .= "\t\tlevel4-v3:".$v3.", v2:$v2, v1:$v1,\n";
									if($linfo['disptitle'] == ''){ $linfo['disptitle'] = $linfo['linkname'];}
										$lv4 .= '<li><a href="'.$ido.'&tbl='.$linfo['modulename'].'&tit='
										        .$linfo['disptitle'].'&db='.$linfo['thedb']
										        .'&'.$linfo['dynamicpara'].'&levelcode='.$linfo['levelcode'].'">'
										        .$linfo['linkname'].'</a></li>';

								}
							}
							if($lv3 != ''){ $lv3 = str_replace("<!--LEVEL-4-->", $lv4, $lv3);  $lv4 = ''; }
                        }
                    }
					$dynamicmenu = str_replace("<!--LEVEL-3-->", $lv3, $dynamicmenu); $lv3 = '';
                }
            }

            $dynamicmenu .= "</ul>\n</li>\n";

            $lv3 = ''; $lv4 = '';
        }
    }
}

 $menulist = '
     <ul class="menu" id="menu">
     <li>
	 
        <a href="'.$url.'" class="menulink"><img src="'.$rtvdir.'/img/my-desktop.png" alt="my desktop"  style="vertical-align:middle;height:12px" /> 我的桌面</a>
            <ul>
                <li><a href="'.$ido.'&tbl=fin_todotbl&tit=待处理事项&db=&pnsktouser='.$userid.'&pnsm=1&pnskstate=1&pnsktogroup='
                        .$user->getGroup().'&pnsc='.$pnscTodo.'&pnsck='.$pnsckTodo.'">待处理事项</a></li>
                <li><a href="'.$ido.'&tbl=fin_todotbl&tit=已处理事项&db=&pnsktouser='.$userid.'&pnsm=1&pnskstate=0&pnsktogroup='
                        .$user->getGroup().'&pnsc='.$pnscDone.'&pnsck='.$pnsckDone.'">已处理事项</a></li>
                <li><a href="'.$ido.'&tbl=mynotetbl&tit=我的笔记&db=&pnskoperator='.$userid.'">我的笔记</a></li>
                <li><a href="'.$ido.'&tbl=fin_operatelogtbl&tit=操作历史记录&db=&pnskuserid='.$userid.'">操作历史记录</a></li>
                <li><a href="'.$ido.'&tbl=info_toolsettbl&tit=常用工具">日常工具</a></li>
				<li><a href="'.$ido.'&tbl=filedirtbl&tit=文件柜&pnskparentname=/&pnsm=1">文件柜</a></li>
                <li> <a href="javascript:void(0);">桌面设置</a> </li>
            </ul>
     </li>
     
	'.$dynamicmenu.'
	    
     <li><a href="'.$url.'&navidir=99" orighref="javascript:void(0);" class="menulink">'
        .'<img src="'.$rtvdir.'/img/my-setting.png" style="vertical-align:middle;height:16px" alt="Settings" /> 系统设置</a>
     <ul>
        <li><a href="'.$ido.'&tbl=info_usertbl&tit=&db=">用户信息</a></li>
        <li><a href="'.$ido.'&tbl=info_grouptbl&tit=&db=">用户组设置</a></li>
        <li><a href="'.$ido.'&tbl=info_objecttbl&tit=&db=">单元模块</a></li>
        <li><a href="'.$ido.'&tbl=info_objectgrouptbl&tit=&db=">单元模块组</a></li>
        <li><a href="'.$ido.'&tbl=useraccesstbl&tit=&db=">系统权限</a></li>
        <li> <a href="'.$ido.'&tbl=info_menulist&tit=&db=">菜单调整</a> </li>
		<li><a href="javascript:void(0);" class="sub">帮助向导</a>
     		<ul>
        	<li><a href="'.$ido.'&tbl=info_helptbl&pnskid=2&tit=公司介绍&db=&act=view&id=16">公司介绍</a></li>
        	<li><a href="'.$ido.'&tbl=info_helptbl&pnskisfaq=1&tit=FAQ常见问题&db=">FAQ常见问题</a></li>
        	<li><a href="'.$ido.'&tbl=info_helptbl&tit=帮助主题&db=">帮助主题</a></li>
     		</ul>
     	</li>
        <li><a href="javascript:void(0);" class="sub">站内搜索</a>
     		<ul>
        	<li><a href="'.$ido.'&tbl=insitesearchtbl&tit=搜索源配置&db=">搜索源配置</a></li>
        	<li><a href="'.$ido.'&tbl=issblackwhitetbl&tit=搜索源黑白名单&db=">搜索源黑白名单</a></li>
     		</ul>
     	</li>
     </ul>
     </li>
    
    </ul>
     ';

$menulistjs = '
     <script async type="text/javascript">
		var menu = {};
		function initNaviMenu(){ //- will be exec in async mode
			menu = new parent.NaviMenu.dd("menu");
			menu.init("menu","menuhover");
		}
		if(typeof parent.NaviMenu == "undefined"){
			var menuDelayT=window.setTimeout(function(){ initNaviMenu();}, 2*1000);
		}
		else{
			initNaviMenu();
		}
     </script>
 ';

$menulist .= $menulistjs;

?>
