<?php
# directory management module 
# wadelau@ufqi.com on Sun Jan 31 10:22:15 CST 2016

#$isoput = false;
require("../comm/header.inc");

include("../comm/tblconf.php");
include_once($appdir."/class/xdirectory.class.php");

if(!isset($xdirectory)){
	$xdirectory = new XDirectory($tbl);
}

$inframe = $_REQUEST['inframe'];

if($inframe == ''){
	# re open in an iframe window
	$url = $rtvdir."/extra/xdirectory.php?inframe=1&".$_SERVER['QUERY_STRING']; 		
    $out .= "<iframe id=\"linktblframe\" name=\"linktblframe\" width=\"100%\" height=\"100%\" src=\"".$url."&isheader=0\" frameborder=\"0\"></iframe>";

}
else{

$dirLevelLength = 2;

# main actions

$out .= '
		<script type="text/javascript" src="'.$rtvdir.'/comm/jquery-1.12.1.min.js" charset="utf-8"></script>			
		<style type="text/css">
			.node ul{
			margin-left:-25px;
			}
			.node ul li{
			list-style-type:none;
			}
			.node .node{
			display:none;
			}
			.node .tree{
			height:24px;
			line-height:24px;
			}
			.ce_ceng_close{
			background:url(../img/cd_zd1.png) left center no-repeat;
			padding-left: 15px;
			}
			.ce_ceng_open{
			background:url(../img/cd_zd.png) left center no-repeat;
			}					
		</style>
		';
		
$out .= "";
$icode = $_REQUEST['icode'];
$iname = $_REQUEST['iname'];

$parentCode = $_REQUEST['parentcode'];
$expandList = array();
if(strlen($parentCode) > $dirLevelLength){
	$codeV = '';
	$codeArr = str_split(substr($parentCode,0,strlen($parentCode)-2), $dirLevelLength);
	foreach($codeArr as $k=>$v){	
		$codeV .= $v;		
		$expandList[$codeV] = $codeV;				
	}	
}

$sqlCondi = "1=1 order by $icode asc";
$hm = $xdirectory->getBy("$icode, $iname", "$sqlCondi");
if($hm[0]){
	$hm = $hm[1];
	$list = array();
	foreach($hm as $k=>$v){
		$list[$v[$icode]] = $v[$iname];	
	}
	$out .= '<style type="text/css">';
	foreach($list as $k=>$v){		
		$out .= '#nodelink'.$k.'{ width:168px; height:20px; display:none; }';
	}		
	$out .= '</style>';		
	$str = $xdirectory->getList($list, $dirLevelLength);
	$out .= $str;
}

$out .= " <script type=\"text/javascript\"> var current_link_field='".$_REQUEST['icode']."'; parent.sendLinkInfo('".$parentCode."','w', current_link_field); </script> ";

$out .= '
			<script type="text/javascript">
				$(".tree").each(function(index, element) {
					if($(this).next(".node").length>0){
						$(this).addClass("ce_ceng_close");
					}
					else{
						$(this).css("padding-left","15px");
					}
				});
		';		
		
foreach($expandList as $k=>$v){		
$out .= '
				var ull = $("#'.$v.'").next(".node");
				ull.slideDown();
				$("#'.$v.'").addClass("ce_ceng_open");
				ull.find(".ce_ceng_close").removeClass("ce_ceng_open");
		';
}				
								
$out .= '				
				$(".tree").click(function(e){
					var ul = $(this).next(".node");
					if(ul.css("display")=="none"){
						ul.slideDown();
						$(this).addClass("ce_ceng_open");
						ul.find(".ce_ceng_close").removeClass("ce_ceng_open");
					}else{
						ul.slideUp();
						$(this).removeClass("ce_ceng_open");
						ul.find(".node").slideUp();
						ul.find(".ce_ceng_close").removeClass("ce_ceng_open");
					}
				});				
		';
foreach($list as $k=>$v){
$out .='
				function xianshi'.$k.'() {
					document.getElementById("nodelink'.$k.'").style.display="inline";
				}
				function yincang'.$k.'() {
					document.getElementById("nodelink'.$k.'").style.display="none";
				}	
	   ';	
}		
$out .='</script>';
}
require("../comm/footer.inc");
?>
