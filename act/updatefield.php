<?php

$field = $_REQUEST['field'];

$gtbl->set($field, $_REQUEST[$field]==''?$hmfield[$field."_default"]:$_REQUEST[$field]);
$gtbl->setId($id);

$hm = $gtbl->setBy("$field", "");

if($hm[0]){
    $hm = $hm[1];
    $out .= "--SUCC--";
}

$gtbl->setId(''); # clear targetId

?>
