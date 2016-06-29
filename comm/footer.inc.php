<?php
if($isoput){
	if($isheader){
		$out .= "<br/><br/><hr/>&nbsp; &copy; <script type=\"text/javascript\">document.write((new Date()).getFullYear());</script>
			<b>Haossh</b>, 好事順. All rights reserved.";
	}
	$out .= "</body></html>";
}

$data['agentname'] = $_CONFIG['agentname'];
$data['appchnname'] = $_CONFIG['appchnname'];
$data['appname'] = $_CONFIG['appname'];
$data['front_page'] = $_CONFIG['frontpage'];
if($smttpl != ''){
	$data['url'] = $url;
	foreach($data as $k=>$v){
		$smt->assign($k, $v);
	}
	$smt->display($smttpl);
}
else{
	#error_log(__FILE__.": smttpl is empty. not display with Smarty.req:[".$_SERVER['REQUEST_URI']);
	if($out_header != ''){
		$out_header = $htmlheader . $out_header;
	}
	else if($out != ''){
		$out = $htmlheader . $out;
	}

	if($fmt == ''){
        print $out;
    }
    else if($fmt == 'json'){
        print json_encode($data['respobj']);    
    }
    else{
        debug($fmt, "unknown_fmt"); 
    }
}

#error_log(__FILE__.": out:[".$out."]");

# write log
include($appdir."/act/writelog.php");

$gtbl = null;
$user = null;
$smt = null;
$out = null;


?>
