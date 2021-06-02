<?php
if(!defined('__ROOT__')){
    define('__ROOT__', dirname(dirname(__FILE__)));
}

require_once(__ROOT__.'/inc/webapp.class.php');

class XDirectory extends WebApp{

    private $dirLevelLength = 2; # default
	private $maxLevelDepth = 10; # code width: 10 x 2 = 20
	public $lang = null;

    function __construct($tbl = ''){
        # db
		$db = $reqdb = trim($_REQUEST['db']);
		if($reqdb != ''){
			$args = array('dbconf'=>($db==GConf::get('maindb')? '' : $db));
			if($args['dbconf'] == 'newsdb'){
				$args['dbconf'] = 'Config_Master';
			}
			# other args options
			parent::__construct($args);
		}
		else{
			$this->dba = new DBA();
		}
		# tbl
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
		# lang
	    if(true){
			#debug("mod/pagenavi: lang: not config. try global?");
			global $lang;
			$this->lang = $lang; # via global?
		}
    }

	# get dir list, expand all of directories above the target dir or its same level, "open all to target"
    function getList($targetDir, $levelLen){
    	$lastNode = '';
		$dirList .="<div class=\"cv_fcv node\">";
		$parentCode = $this->get('parentCode');
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
			$nodeContent = "<div class=\"tree\" id=\"".$k."\" onmouseover=\"xianShi('".$k."');\" onmouseout=\"yinCang('".$k."');\"".($k==$parentCode?' style="color:red;font-weight:strong;"':'').">".$nodeContent; # 
			$nodeContent .= "&nbsp;&nbsp;<span id=\"nodelink".$k."\"><a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$k."', 'w', current_link_field); parent.copyAndReturn(current_link_field); changeBgc('".$k."');\">".$this->lang->get("xdir_this_item")."</a>";
			$nodeContent .= "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$k."-".$v."', 'w', current_link_field); parent.copyAndReturn(current_link_field); changeBgc('".$k."');\">".$this->lang->get("xdir_this_item_and_value")."</a>";
			$nodeContent .= "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$i."', 'w', current_link_field); parent.copyAndReturn(current_link_field);\">+".$this->lang->get("xdir_same_level")."</a>";	
			$nodeContent .= "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"javascript:parent.sendLinkInfo('".$j."', 'w', current_link_field); parent.copyAndReturn(current_link_field);\">+".$this->lang->get("xdir_sub_level")."</a>";	
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

    //- extract all possible upside dirs from a dir
    //- Xenxin@ufqi,  Wed Apr 24 13:09:17 HKT 2019
    function extractDir($dir, $dirLevelLen=null){
        $rtnDirList = array($dir);
        $dirLen = strlen($dir);
        if($dirLevelLen == null || $dirLevelLen < 1){
            $dirLevelLen = $this->dirLevelLength;
        }
        for($ilen=$dirLevelLen; $ilen<$dirLen; $ilen+=$dirLevelLen){
            $rtnDirList[] = substr($dir, 0, $ilen);     
        }
        return $rtnDirList;

    }
	
	//- sort same layer by iname
    //- xenxin@ufqi.com, Sat May 22 21:37:49 CST 2021
    function sortDir($targetDir, $icode, $iname, $dirLevelLength=2){
    	$treeList = array();
    	$codeLen = $dirLevelLength; $theCode = '';
    	//-sort
		foreach($targetDir as $k=>$v){
   			$theCode = $v[$icode]; $codeLen = strlen($theCode);
   			$keyLenArr[$codeLen]["$theCode"] = $v[$iname];
   			#debug("k:$k $theCode len:$codeLen");
    	}
    	$keyLenArr2 = array(); 
    	foreach($keyLenArr as $k=>$v){
    		$v = $this->sortByGbk($v); // sort all items within same layer
    		$keyLenArr2[$k] = $v;
    		#debug("k:$k sort:".serialize($keyLenArr2[$k]));
    	}
    	$keyLenArr = $keyLenArr2;
		//- re-group
    	$keyLenArr2 = array(); $tmpArr = $keyLenArr; 
    	$maxDepth = $this->maxLevelDepth + $dirLevelLength;
		foreach($keyLenArr as $keyLen=>$arr){
			foreach($arr as $k2=>$v2){
				$keyLenArr2[] = array("$icode"=>$k2, "$iname"=>$v2);
				#debug("keyLen:$keyLen, k2:$k2 v2:$v2 icode:".$v2[$icode]);	
				$myLevel=$keyLen+$dirLevelLength;
				$childArr = $this->getChild($keyLenArr, $k2, $myLevel, $icode, $iname);
				foreach($childArr as $ck=>$cv){
					$keyLenArr2[] = $cv;	
				}
			}
		}
    	$keyLenArr = $keyLenArr2;
    	return $keyLenArr;
    }
    //- iterate all children looply
    //- travel all dirs with depth first
    function getChild($keyLenArr, $pcode, $myLevel, $icode, $iname){
    	$rtnArr = array();
		$tmpArr = $keyLenArr[$myLevel];
		foreach($tmpArr as $k3=>$v3){
			if(startsWith($k3, $pcode)){
				#debug("\t\tmyLevel:$myLevel pcode:$pcode k3-icode:$k3 iname:$v3");	
				$rtnArr[] = array("$icode"=>$k3, "$iname"=>$v3);
				$tmpLevel = $myLevel + $this->dirLevelLength;
				if($tmpLevel <= $this->maxLevelDepth){
					$rtnArr2 = $this->getChild($keyLenArr, $k3, $tmpLevel, $icode, $iname);
					foreach($rtnArr2 as $k4=>$v4){
						$rtnArr[] = $v4;	
					}
				}
				else{
					#debug("class/xdirectory: myLevel:$tmpLevel > ".$this->maxLevelDepth);	
				}
			}
		}
		return $rtnArr;
    }
    //- sort with gbk?
    function sortByGbk($arr){
    	$needGBK = 0; global $_CONFIG;
    	if(strtolower($_CONFIG['character_code_for_sort']) == 'gbk'){ $needGBK = 1; }
    	$tmpArr = array();
   		if($needGBK == 1){
   			foreach($arr as $k=>$v){
   				$tmpArr[$k] = iconv('UTF-8', 'GBK', $v);
   			}
		}
		else{
			$tmpArr = $arr;	
		}
		asort($tmpArr, SORT_STRING); // sort by value with string
		$arr = array();
   		if($needGBK == 1){
   			foreach($tmpArr as $k=>$v){
   				$arr[$k] = iconv('GBK', 'UTF-8', $v);
   			}
		}
		else{
			$arr = $tmpArr;	
		}
		return $arr;
    }

}
?>