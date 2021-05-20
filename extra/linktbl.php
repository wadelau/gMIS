<?php
$isoput = false;
require("../comm/header.inc.php");
#require("../class/gtbl.class.php");

$tbl = $field = $fieldv = $fieldargv = $filename = $act = '';
$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$tbl = $_REQUEST['tbl'];
$mydb = $_CONFIG['appname'].'db';
$db = $_REQUEST['db']==''?$mydb:$_REQUEST['db'];
$field = $_REQUEST['field'];
$url = $rtvdir."/ido.php?sid=".$sid;

$url = mkUrl($url, $_REQUEST);

$otbl = $_REQUEST['otbl'];
$oid = $_REQUEST['oid'];
$lfield = $_REQUEST['linkfield'];
$hmOrig = array();
if($_REQUEST['linkfieldval'] != '' || $oid != ''){ 
	# added on Mon Mar 19 21:09:43 CST 2012, updt Thu May  6 12:29:22 CST 2021
    $linkfv = $_REQUEST['linkfieldval'];
    $linkfv = $linkfv=='' ? '*' : $linkfv;
    $hmconf = GTbl::xml2hash($xmlpathpre, $elementsep, $db, $otbl);
    $gtbl = new GTbl($otbl, $hmconf[0], $elementsep);
    $gtbl->setId($oid);
    $hm = $gtbl->getBy($linkfv, "id=?");
    if($hm[0]){
        $hm = $hm[1][0]; $hmOrig = $hm;
        if($linkfv=='*'){
        	$id = $hm['id'];
		}
		else{
        	$id = $hm[$linkfv];
		}
    }

}else{
    $id = $oid;
}

$url = preg_replace("/linkfield=([0-9a-zA-Z]*)/", "pnsk\$1=".$id, $url);
$url = preg_replace("/&id=([0-9]*)/", "", $url);
$setPnsm = 0;
if(strpos($url,"linkfield2") > 1){
	if(preg_match("/linkfield2=([0-9a-zA-Z]*)/", $url, $matches)){
		//debug("extra/linktbl: matches:".serialize($matches));
		$tmpLinkField = $matches[0];
		$tmpLinkFieldName = $matches[1];
		$url = str_replace($tmpLinkField, "pnsk".$tmpLinkFieldName."=".$hmOrig[$tmpLinkFieldName], $url);
		if($setPnsm == 0){
			$url .= "&pnsm=1"; # page navigator search mode, see in class/pagenavi.class.php
			$setPnsm = 1;
		}
	}
}
if(strpos($url,"linkfield3") > 1){
	if(preg_match("/linkfield3=([0-9a-zA-Z]*)/", $url, $matches)){
		$tmpLinkField = $matches[0];
		$tmpLinkFieldName = $matches[1];
		$url = str_replace($tmpLinkField, "pnsk".$tmpLinkFieldName."=".$hmOrig[$tmpLinkFieldName], $url);
		if($setPnsm == 0){
			$url .= "&pnsm=1"; 
			$setPnsm = 1;
		}
	}
}
if(strpos($url,"linktbl") > 1){
    $url = preg_replace("/linktbl=([0-9a-z]*)/", "pnsk\$1=".$otbl, $url);
    if($setPnsm == 0){
    	$url .= "&pnsm=1"; $setPnsm = 1;
	}
}

$out .= "<!-- <br/> --> <table width=\"100%\" >";

$out .= "<tr><td width=\"100%\" height=\"400px\">";
if($id == '' || $id == '0'){
    $out .= " &nbsp;&nbsp;&nbsp; id為空, 請先填寫其他信息，然後保存後再添加項內容.<br/>&nbsp;<br/>&nbsp;";   
}else{
    $out .= "<iframe id=\"linktblframe\" name=\"linktblframe\" width=\"100%\" height=\"100%\" src=\"".$url."&isheader=0&needautopickup=no\" frameborder=\"0\"></iframe>";
}
$out .= "</td></tr>";

$out .= "</table>";

require("../comm/footer.inc.php");

?>
