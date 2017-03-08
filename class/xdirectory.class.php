<?php
if(!defined('__ROOT__')){
    define('__ROOT__', dirname(dirname(__FILE__)));
}

require_once(__ROOT__.'/inc/webapp.class.php');

class XDirectory extends WebApp{

    function __construct($tbl = ''){

        $this->dba = new DBA();

        if($tbl != ''){
			if($_CONFIG['language'] && $_CONFIG['language'] == "en_US"){
				//$this->setTbl(GConf::get('tblpre').'en_'.$tbl);
				$this->setTbl('en_'.$tbl);
			}
			else{
				//$this->setTbl(GConf::get('tblpre').$tbl);
				$this->setTbl($tbl);
			}
		}
    }

	# get dir list, expand all of directories above the target dir or its same level, "open all to target"
    function getList($targetDir, $levelLen){
    	$lastNode = '';
		$dirList .="<div class=\"cv_fcv node\">";
		foreach($targetDir as $k=>$v){
			$ilevel = 0;
			$codeArr = str_split($k,$levelLen);
			foreach($codeArr as $kd=>$vd){
				$ilevel++;		
			}
			$i = $this->getNextDir($targetDir, $levelLen, $ilevel, $k);
			$j = $this->getSubDir($targetDir, $levelLen, $ilevel, $k);
			#$nodeContent = $ilevel."-".$k."-".$v;
			$nodeContent = $k."-".$v;
			$nodeContent = "<div class=\"tree\" onmouseover=\"xianshi".$k."()\" onmouseout=\"yincang".$k."()\" id=\"".$k."\">".$nodeContent;
			$nodeContent .= "&nbsp;&nbsp;<span id=\"nodelink".$k."\"><a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$k."', 'w', current_link_field); parent.copyAndReturn(current_link_field);\">该项</a>";
			$nodeContent .= "&nbsp&nbsp<a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$i."', 'w', current_link_field); parent.copyAndReturn(current_link_field);\">+同级</a>";	
			$nodeContent .= "&nbsp&nbsp<a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$j."', 'w', current_link_field); parent.copyAndReturn(current_link_field);\">+下级</a>";	
			$nodeContent .= "</span></div>";			
			if($lastNode == ''){
				$dirList .= $nodeContent;								
			}
			else if(strlen($k)==$levelLen){
				if(strlen($lastNode)==$levelLen){
					$dirList .= $nodeContent;
				}else{
					$n = substr($lastNode,$levelLen);
					$codeArr = str_split($n,$levelLen);
					foreach($codeArr as $kd=>$vd){
						$dirList .= "	</li>										
								</ul>";		
					}	
					$dirList .= $nodeContent;
				}					
			}
			else{
				if(strlen($lastNode) == strlen($k)){
					$dirList .= $nodeContent;
				}else if(strlen($lastNode) < strlen($k)){
					$dirList .="<ul class=\"node\">
									<li>";
					$dirList .= $nodeContent;
				}else{
					$n = substr($lastNode,0,strlen($lastNode)-strlen($k));
					$codeArr = str_split($n,$levelLen);
					foreach($codeArr as $kd=>$vd){
						$dirList .= "	</li>										
							</ul>";		
					}	
					$dirList .= $nodeContent;
				}
			}			
			$lastNode = $k;		
		}
		$dirList .="</div>";
		return $dirList;		
    } 

	# get next dir code, 2c after 2b, 10 after 0z, in base36, i.e. 0-9, a-z
	function getNextDir($currentDir, $levelLen, $ilevel, $currentVal){	
		$max = $currentVal;
		$len = $levelLen * $ilevel;
		foreach($currentDir as $k=>$v){
			if(strlen($k)==$len && substr($k,0,strlen($k)-$levelLen)==substr($max,0,strlen($k)-$levelLen) ){  
				//条件：同级且在同一个节点下
				$max = $k;
			}   
		}
		
		$lastnumber = substr($max,strlen($max)-$levelLen,strlen($max));
		$lastnumber = base_convert($lastnumber,36,10);  //36进制转成10进制
		$lastnumber++;
		$lastnumber = base_convert($lastnumber,10,36);  //10进制转成36进制
		if(strlen($lastnumber)<$levelLen){  //开头做加0处理
			$temp = '';
			for($i=0; $i<($levelLen-strlen($lastnumber)); $i++){
				$temp .='0';
			}
			$lastnumber = $temp.$lastnumber;
		}
		return substr($max,0,strlen($max)-$levelLen).$lastnumber;
	}

	# get sub dir under currentDir, a1b200 for a1b2	
	function getSubDir($currentDir, $levelLen, $ilevel, $currentVal){				
		$nextlen = $levelLen * ($ilevel+1);
		$currentlen = $levelLen * $ilevel;
		$exist = false;
		foreach($currentDir as $k=>$v){
			if(strlen($k)==$nextlen && substr($k,0,$currentlen)==$currentVal){
				$max = $k;
				$exist = true;   //当前菜单项存在子级
			}
		}
		
		if($exist){	
			$lastnumber = substr($max,strlen($max)-$levelLen,strlen($max));
			$lastnumber = base_convert($lastnumber,36,10);   //36进制转成10进制
			$lastnumber++;
			$lastnumber = base_convert($lastnumber,10,36);   //10进制转成36进制
			if(strlen($lastnumber)<$levelLen){  //开头做加0处理
				$temp = '';
				for($i=0; $i<($levelLen-strlen($lastnumber)); $i++){
					$temp .='0';
				}
				$lastnumber = $temp.$lastnumber;
			}
			return substr($max,0,strlen($max)-$levelLen).$lastnumber;
		}
		else{   //当前菜单项不存在子级
			for($i=0; $i<$levelLen; $i++){
				$currentVal .='0';
			}
			return $currentVal;
		}
	}
}
?>
