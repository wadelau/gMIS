<?php
if($isoput){
	if($isheader){
		$out .= "<br/><br/><hr/>&nbsp; &copy; <script type=\"text/javascript\">document.write((new Date()).getFullYear());</script>
			<b>Haossh</b>, 好事順. All rights reserved.";
	}
	$out .= "</body></html>";
}

if($fmt == ''){ # default html
    $data['agentname'] = $_CONFIG['agentname'];
    $data['appchnname'] = $_CONFIG['appchnname'];
    $data['appname'] = $_CONFIG['appname'];
    $data['front_page'] = $_CONFIG['frontpage'];
    $data['adminmail'] = $_CONFIG['adminmail'];
}

# content output
$isOB = 0; $enableZip = true;
if($enableZip && ob_start('ob_gzhandler')){ $isOB = 1; }
else if($enableZip && ob_start()){ $isOB = 1; }

if($smttpl != ''){
	$data['url'] = $url;
	$data['isdebug'] = $is_debug;
	$data['randi'] = $randi;
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
        if(isset($data['respobj'])){
            $out=json_encode($data['respobj']);
        }
        else{
            $out=json_encode($data);
        }
        print $out;
    }
    else{
        debug($fmt, "unknown_fmt"); 
    }
}

if($isOB){ ob_end_flush(); }

# write log
include($appdir."/act/writelog.php");

$gtbl = null;
$user = null;
$smt = null;
$out = null;


?>
