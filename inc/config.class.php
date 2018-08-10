<?php

# global constant configurations
# remedy by wadelau@ufqi.com on 22:31 Friday, December 04, 2015

ini_set("memory_limit","512M"); # memory limit avoding crush

if(true){
	$tblpre = "TABLE_PRE";
	$conf = array();
	$appdir = isset($appdir) ? $appdir : '';
	$rtvdir = isset($rtvdir) ? $rtvdir : '';
	
	$conf['tblpre'] 	= $tblpre;
	$conf['appname'] 	= '-gMIS';
	$conf['appchnname'] 	= '-吉密斯';
	$conf['appdir']		= $appdir;

	$conf['rtvdir'] 	= $rtvdir;
	$conf['agentname'] 	= 'AGENT_NAME';
	$conf['agentalias']	= 'gMIS-Admin';
	$conf['smarty']		= $appdir.'/class/Smarty';

	$conf['uploaddir']	= 'upld';
	$conf['septag']		= '_J_A_Z_';
	$conf['skiptag']    = '----';

	$conf['maindb']		= 'DB_NAME';
	$conf['maintbl']	= $tblpre.'customertbl';
	$conf['usertbl']	= $tblpre.'info_usertbl';
	$conf['welcometbl']	= $tblpre.'info_welcometbl';
	$conf['operatelogtbl']	= $tblpre.'fin_operatelogtbl';
	$conf['ostype'] = 0; # 0 for *nix, 1 for windows, Mar 2018

	# db info
	$conf['dbhost'] 	= 'DB_HOST'; # use 127.0.0.1 instead of localhost
	$conf['dbport'] 	= 'DB_PORT';
	$conf['dbuser'] 	= 'DB_USER';
	$conf['dbpassword'] 	= 'DB_PASSWORD';
	$conf['dbname'] 	= $conf['maindb'];
	$conf['dbdriver']	= 'MYSQLIX'; # 'MYSQL', 'MYSQLIX', 'PDOX', 'SQLSERVER', 'ORACLE' in support, UPCASE only
	$conf['db_enable_utf8_affirm'] = false; # append utf-8 affirm after db connection established, should be false in a all-utf-8 env.
	$conf['dbpersistent'] = true; # assume db connection pool per process is support

	# db slave info
	$conf['dbhost_slave'] 	= 'SLAVE_DB';
	$conf['dbport_slave'] 	= '3306';
	$conf['dbuser_slave'] 	= '';
	$conf['dbpassword_slave'] 	= '';
	$conf['dbname_slave'] 	= ''; #$conf['maindb'];
	
	# cache server
	$conf['enable_cache'] = 0; # or true for 1, false for 0
	$conf['cachehost'] = '/www/bin/memcached/memcached.sock'; # '127.0.0.1'; #  ip, domain or .sock
	$conf['cacheport'] = '11211'; # empty or '0' for linux/unix socket
	$conf['cachedriver'] = 'MEMCACHEDX'; # REDISX, XCACHEX
	$conf['cacheexpire'] = 1800; # 30 * 60;
	
	# session service
	$conf['enable_session'] = 1; # or true for 1, false for 0
	$conf['sessiondriver'] = 'SESSIONX'; # SESSIONX, REDISX
	$conf['sessionexpire'] = 1800; # 30 * 60;

	# file system
	$conf['enable_file'] = 1; # true for 1, false for 0 to init at entry stage
	$conf['filedriver'] = 'FileSystem'; # files operations, since 2016-11-05
	$conf['enable_filehandle_share'] = 1; # 17:31 10 November 2016

	# misc
	$conf['frontpage'] = 'FRONT_PAGE';  # put # before -naturedns as #-naturedns
	$conf['is_debug'] = 0;
	$conf['html_resp'] = '<!DOCTYPE html><html><head><title>RESP_TITLE</title></head><body>RESP_BODY</body></html>';
	$conf['auto_save_interval'] = 20; # ref extra/htmleditor
	$conf['auto_install'] = 'INSTALL_DONE';

	$conf['adminmail'] = 'system@local';
	$conf['start_date'] = '2016-06-08'; # first action date in fin_operatelogtbl
	$conf['sign_key'] = 'my_sign_key_at_random-----';
	$conf['watch_interval'] = 5 * 60; # seconds

	# set them all
	GConf::setConf($conf);
}

global $_CONFIG; # will be used in page scripts
$_CONFIG = GConf::getConf();

# configuration container

class GConf{

	private static $conf = array();

	public static function get($key){
		if(isset(self::$conf[$key])){
		    return self::$conf[$key];
		}
		else{
		    return '';
		}
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
