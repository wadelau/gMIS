<?php
/*
 * XTree class for unlimited tree-like directory with parentid and id
 * xenxin@ufqi.com, 
 * Sat May  8 10:51:12 CST 2021
 *
 */
if(!defined('__ROOT__')){
    define('__ROOT__', dirname(dirname(__FILE__)));
}

require_once(__ROOT__.'/inc/webapp.class.php');

class XTree extends WebApp{

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
		$dirList .="";
		
		return $dirList;		
    } 

	
}
?>
