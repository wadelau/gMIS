<?php

# global constant configurations
# remedy by wadelau@ufqi.com on 22:31 Friday, December 04, 2015

$tblpre = "TABLE_PRE";
$conf = array();

$conf['tblpre'] 	= $tblpre;
$conf['appname'] 	= 'HaoSSH';
$conf['appchnname'] 	= '好事顺信管';
$conf['appdir']		= $appdir;

$conf['rtvdir'] 	= $rtvdir;
$conf['agentname'] 	= 'AGENT_NAME';
$conf['agentalias']	= 'gMIS-Admin';
$conf['smarty']		= $appdir.'/class/Smarty-3.1.7/libs';

$conf['uploaddir']	= 'upld';
$conf['septag']		= '_J_A_Z_';

$conf['maindb']		= 'DB_NAME';
$conf['maintbl']	= $tblpre.'customertbl';
$conf['usertbl']	= $tblpre.'info_usertbl';
$conf['welcometbl']	= $tblpre.'info_welcometbl';
$conf['operatelogtbl']	= $tblpre.'fin_operatelogtbl';

# db info
$conf['dbhost'] 	= 'DB_HOST';
$conf['dbport'] 	= 'DB_PORT';
$conf['dbuser'] 	= 'DB_USER';
$conf['dbpassword'] 	= 'DB_PASSWORD';
$conf['dbname'] 	= $conf['maindb'];

# misc 
$conf['frontpage'] = 'FRONT_PAGE';
$conf['is_debug'] = 1;
$conf['html_resp'] = '<!DOCTYPE html><html><head><title>RESP_TITLE</title></head><body>RESP_BODY</body></html>';
$conf['auto_save_interval'] = 20; # ref extra/htmleditor

# set them all
Gconf::setConf($conf);
global $_CONFIG; # will be used in page scripts
$_CONFIG = Gconf::getConf();


# configuration container

class Gconf{

	private static $conf = array();

	public static function get($key){
		return self::$conf[$key];
	}

	public static function set($key, $value){
		self::$conf[$key] = $value;	
	}

	public static function getConf(){
		return self::$conf;
	}

	public static function setConf($conf){
		foreach($conf as $k=>$v){
			self::set($k, $v);
		}	
	}
}


?>
