<?php

# global constant configurations
# remedy by wadelau@ufqi.com on 22:31 Friday, December 04, 2015

ini_set("memory_limit","512M"); # memory limit avoding crush

if(true){
	$tblpre = "gmis_";
	$conf = array();

	$conf['tblpre'] 	= $tblpre;
	$conf['appname'] 	= '-gMIS';
	$conf['appchnname'] 	= '-gMIS';
	$conf['appdir']		= $appdir;

	$conf['rtvdir'] 	= $rtvdir;
	$conf['agentname'] 	= '-XXXX-MIS';
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

	# db slave info
	$conf['dbhost_slave'] 	= 'SLAVE_DB'; #  -hadstatsdb -uadstats -padstatsaccess adstats
	$conf['dbport_slave'] 	= '3306';
	$conf['dbuser_slave'] 	= '';
	$conf['dbpassword_slave'] 	= '';
	$conf['dbname_slave'] 	= ''; #$conf['maindb'];

	# misc 
	$conf['frontpage'] = '#-XXXX';  # put # before -naturedns as #-naturedns
	$conf['is_debug'] = 1;
	$conf['html_resp'] = '<!DOCTYPE html><html><head><title>RESP_TITLE</title></head><body>RESP_BODY</body></html>';
	$conf['auto_save_interval'] = 20; # ref extra/htmleditor
	$conf['auto_install'] = 'INSTALL_DONE';

	$conf['adminmail'] = 'system@local';

	# set them all
	GConf::setConf($conf);
}

global $_CONFIG; # will be used in page scripts
$_CONFIG = GConf::getConf();

# configuration container

class GConf{

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
