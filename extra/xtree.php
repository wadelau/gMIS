<?php
/*
 * tree data management module
 * wadelau@ufqi.com on  Sat May  8 10:44:26 CST 2021
 * params:
 	tbl: target table for tree-like data
  	icode: id or parentid in the table
 	iname: item name in the table
 	pnskFieldName: field name in the table as condtion
 	parentField: the field indicating parent id
 	parentcode: parentid
 	imode: read or writeback
	targetfield: field name to be writted back
 *
 * 
	<field name="belongto">
        <chnname>上级</chnname>
        <extrainput>extra/xtree.php?tbl=THIS_TBL&amp;icode=id&amp;iname=iname&amp;pnskitype=1,2&amp;oppnskitype=inlist&amp;parentcode=THIS_belongto&amp;imode=read&amp;targetfield=belongto</extrainput>
    </field>
 */

#$isoput = false;

$isheader = 0;
$_REQUEST['isheader'] = $isheader;
#$out_header = $isheader;

require("../comm/header.inc.php");

include("../comm/tblconf.php");
include_once($appdir."/class/xtree.class.php");
include_once($appdir."/class/pagenavi.class.php");

if(!isset($xTree)){
	$xTree = new XTree($tbl);
}

$inframe = Wht::get($_REQUEST, 'inframe');

if($inframe == ''){
	# re open in an iframe window
	$myurl = $rtvdir."/extra/xtree.php?inframe=1&".$_SERVER['QUERY_STRING'].'&'.SID.'='.$sid;
    $out .= "<iframe id=\"linktblframe\" name=\"linktblframe\" width=\"100%\" height=\"100%\" src=\""
            .$myurl."&isheader=0\" frameborder=\"0\"></iframe>";

}
else{

# main actions
$rootId = 1;
$parentCode = Wht::get($_REQUEST, 'parentcode');
if(inString('-', $parentCode)){ //- 0100-止疼药2级
    $tmpArr = explode('-', $parentCode);
    $parentCode = $tmpArr[0];
}
else if(inString('THIS_', $parentCode)){ //- THIS_belongto
	$parentCode = $rootId;
}
else{
	$parentCode = $parentCode=='' ? $rootId : $parentCode; //- 1 as root	
	$parentCode = $parentCode=='0' ? $rootId : $parentCode; //- 1 as root	
}
$xTree->set('parentCode', $parentCode);

$targetField = Wht::get($_REQUEST, 'targetfield');
$parentField = Wht::get($_REQUEST, 'parentfield');
#$sqlCondi = "1=1 order by $icode asc"; //- why unconditional?
if(!isset($_REQUEST['pnsm'])){
	$_REQUEST['pnsm'] = 1; //- default search mod: and
}
$myNavi = new PageNavi($args=array('lang'=>$lang));
$sqlCondi = $myNavi->getCondition($gtbl, $user);
$hmVars = $gtbl->hmf;
foreach($hmVars as $k=>$v){
	$xTree->set($k, $v); //- override?	
}
$sqlCondi .= " and ($parentField=$parentCode)";
#$sqlCondi .= " order by $icode asc"; //- why unconditional?
$xTree->set("orderby", "convert($iname using gbk), $icode asc");
$hm = $xTree->getBy("$icode, $iname", "$sqlCondi", 
	$withCache=array('key'=>"xtree-$tbl-$sqlCondi"));
if($hm[0]){
	$hm = $hm[1];
}
else{
	$hm = array(0=>array("$icode"=>$rootId, "$iname"=>'Root/根'));
}

# trace up to root.
$hmParent = array(); $tmpId = $parentCode; $lastTmpId = 0;
while($tmpId >= $rootId){
	$tmpHm = $xTree->getBy("$icode, $iname, $parentField", "$icode=$tmpId", 
			$withCache=array('key'=>"xtree-3-$tbl-$tmpId"));
	#debug("extra/xtree: tmpHm:".serialize($tmpHm));
	if($tmpHm[0]){
		$tmpHm = $tmpHm[1][0]; $hmParent[] = $tmpHm;
		$tmpId = $tmpHm[$parentField];
	}
	if($tmpId == $lastTmpId){
		$tmpId = 0;
	}
	else{
		$lastTmpId = $tmpId; //- anti dead loop.	
	}
}
$hmParent = array_reverse($hmParent);
#debug("extra/xtree: ".serialize($hm)." sqlCondi:$sqlCondi hmParent:".serialize($hmParent));

# disp
$myUrl = $thisUrl;
$myUrl = preg_replace('/&parentcode=[0-9]+/', '', $myUrl);

$out .= "<style>.selectedColor{ color:red; }</style><p>🍁"; $lastParent = $rootId;
foreach($hmParent as $k=>$v){
	$out .= "<span".(($v['id']==$parentCode)?" class=\"selectedColor\"":"").">".$v['iname']."(".$v['id'].")<a href='".$myUrl."&parentcode=".$lastParent."'><sup>X</sup></a></span> > ";	
	$lastParent = $v['id'];
}
foreach($hm as $k=>$v){
	$out .= "<span".(($v['id']==$parentCode)?" class=\"selectedColor\"":"")."><a href='".$myUrl."&parentcode=".$v['id']."'>".$v['iname']."(".$v['id'].")</a>"
		." <a href='javascript:void(0);' onclick=\"javascript:parent.sendLinkInfo('".$v['id']."', 'w', current_link_field); "
		." parent.copyAndReturn(current_link_field); this.style.backgroundColor='yellow';\" title='"
		.$lang->get('choose')."'><input name='chkbox_".$v['id']."' type='checkbox'/></a>  </span> . ";	
}
$out .= "</p><p>".$lang->get("xtree-no-data")."</p>";

$imode = Wht::get($_REQUEST, "imode");
if($imode == 'read' && $targetField != $icode){
    $icode = $targetField;
}
$out .= " <script type=\"text/javascript\"> var current_link_field='".$icode
    ."'; var tmpTimer0859=window.setTimeout(function(){parent.sendLinkInfo('".$parentCode."','w', current_link_field);}, 1*1000);</script> ";
	
# positioning to selected, 17:42 6/11/2020
if($parentCode != ''){
	$out .= '<script>if(true){ var tmpReloadTimer=window.setTimeout(function(){ var tmpObj=document.getElementById("'.$parentCode.'"); if(tmpObj){tmpObj.scrollIntoView(); parent.scrollTo(0,10);}}, 1*1000);};</script>';
}

$out .='</script>';

}

require("../comm/footer.inc.php");

?>
