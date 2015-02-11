<?php
if(1){
    $auditacts = array('list-addform','list-dodelete','updatefield');
    if(in_array($act, $auditacts)){
       	if(!$gtbl){
			$gtbl = new WebApp;	
		} 
        $gtbl->setTbl($_CONFIG['operatelogtbl']); 
        $gtbl->set('userid', $userid);
        $gtbl->set('useremail', $user->getEmail());

        $gtbl->set('parentid', $_REQUEST['id']==''?0:$_REQUEST['id']);
        $gtbl->set('parenttype', $tbl);

        $gtbl->set('actionstr', "act:[".$act."] id:[".$_REQUEST['id']."]");

        $hm = $gtbl->setBy("userid,useremail,parentid,parenttype,actionstr,inserttime",null);

        error_log(__FILE__.": log succ. act:[$act]");

    }else{

        #error_log(__FILE__.": log fail. act:[$act]");

    }
}
?>
