<?php

# global constant configurations
# remedy by wadelau@ufqi.com on 22:31 Friday, December 04, 2015

$tblpre = "gmis_";
$conf = array();

$conf['tblpre'] 	= $tblpre;
$conf['appname'] 	= '-gMIS';
$conf['appchnname'] 	= '-gMIS';
$conf['appdir']		= $appdir;

$conf['rtvdir'] 	= $rtvdir;
$conf['agentname'] 	= '-PBTT-MIS';
$conf['agentalias']	= 'gMIS-Admin';
$conf['smarty']		= $appdir.'/class/Smarty';

$conf['uploaddir']	= 'upld';
$conf['septag']		= '_J_A_Z_';

$conf['maindb']		= '';
$conf['maintbl']	= $tblpre.'customertbl';
$conf['usertbl']	= $tblpre.'info_usertbl';
$conf['welcometbl']	= $tblpre.'info_welcometbl';
$conf['operatelogtbl']	= $tblpre.'fin_operatelogtbl';

# db info
$conf['dbhost'] 	= '';
$conf['dbport'] 	= '3306';
$conf['dbuser'] 	= '';
$conf['dbpassword'] 	= '';
$conf['dbname'] 	= $conf['maindb'];
$conf['dbdriver']	= 'MYSQLIX'; # 'MYSQL', 'MYSQLIX', 'PDOX', 'SQLSERVER', 'ORACLE' in support, UPCASE only
$conf['db_enable_utf8_affirm'] = false; # append utf-8 affirm after db connection established, should be false in a all-utf-8 env.

# misc 
$conf['frontpage'] = '-PBTT';
$conf['is_debug'] = 1;
$conf['html_resp'] = '<!DOCTYPE html><html><head><title>RESP_TITLE</title></head><body>RESP_BODY</body></html>';
$conf['auto_save_interval'] = 20; # ref extra/htmleditor
$conf['auto_install'] = 'INSTALL_DONE';

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
