<?php

$field = $_REQUEST['field'];

# remedy by wadelau Tue Jun 30 16:17:53 CST 2015
# same as act/doaddmodi.php
$fieldv = urldecode(trim($_REQUEST[$field]));
if(1){
	if(strpos($fieldv,"<") !== false){ # added by wadelau on Sun Apr 22 22:09:46 CST 2012
		if($fieldInputType == 'textarea'){	
			# allow all html tags except these below 
			$fieldv = str_replace("<script","&lt;script", $fieldv);
			$fieldv = str_replace("<iframe","&lt;iframe", $fieldv);
			$fieldv = str_replace("<embed","&lt;embed", $fieldv);
		}
		else{
			$fieldv = str_replace("<","&lt;", $fieldv);
		}
	}
	if(strpos($fieldv, "\n") !== false){
		$fieldv = str_replace("\n", "<br/>", $fieldv);
	}
}

$gtbl->set($field, $_REQUEST[$field]==''?$hmfield[$field."_default"]:$_REQUEST[$field]);
$gtbl->setId($id);

$hm = $gtbl->setBy("$field", "");

if($hm[0]){
    $hm = $hm[1];
    $out .= "--SUCC--";
}

$gtbl->setId(''); # clear targetId

?>
