<?php
# collect preset vars from request and foward to class/gtbl
# xenxin@ufqi.com, Thu May  6 11:11:48 CST 2021
if(true){
	$hmorig = array();
	foreach($_REQUEST as $k=>$v){
		if(startsWith($k,"pnsk")){
			$hmorig[substr($k,4)] = $v;
		}
		else if(startsWith($k, 'parent')){
			$k2 = $v;
			$hmorig[$k2] = $_REQUEST[$k2];
		}
	}
	# sync pre-set params
	$gtbl->set(GTbl::RESULTSET, $hmorig);
}
?>
