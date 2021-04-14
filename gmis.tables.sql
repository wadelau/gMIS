
---- gmis tables, 201908; to sep in install script;

drop table if exists gmis_filedirtbl;
CREATE TABLE `gmis_filedirtbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `filename` char(128) NOT NULL DEFAULT '' COMMENT 'file or dir name',
  `parentname` char(254) NOT NULL DEFAULT '' COMMENT 'file or dir path',
  `pparentname` varchar(768) NOT NULL DEFAULT '' COMMENT 'file or dir path uplevel',
  `idesc` char(255) NOT NULL DEFAULT '',
  `itype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:file, 1:dir',
  `filetype` char(64) NOT NULL DEFAULT '' COMMENT 'mime type',
  `filesize` int(12) NOT NULL DEFAULT '0' COMMENT 'KB',
  `filepath` char(255) NOT NULL DEFAULT '' COMMENT 'file system dir',
  `ioperator` tinyint(1) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:01',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:01',
  `parentid` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`parentname`,`filename`),
  KEY `key3` (`filename`),
  KEY `key4` (`filetype`)
);

drop table if exists `gmis_fin_operatelogtbl`;
CREATE TABLE `gmis_fin_operatelogtbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `parenttype` char(32) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0',
  `actionstr` char(255) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  PRIMARY KEY (`id`)
);

drop table if exists `gmis_fin_todotbl`;
CREATE TABLE `gmis_fin_todotbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(12) NOT NULL DEFAULT '0',
  `taskname` char(128) NOT NULL DEFAULT '',
  `tasktype` tinyint(1) NOT NULL DEFAULT '0',
  `triggerbyparent` char(64) NOT NULL DEFAULT '',
  `triggerbyparentid` int(11) NOT NULL DEFAULT '0',
  `togroup` mediumint(4) NOT NULL DEFAULT '0',
  `touser` mediumint(4) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `taskmemo` varchar(2048) NOT NULL DEFAULT '',
  `taskreply` varchar(1024) NOT NULL DEFAULT '',
  `taskfile` char(255) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `k2` (`pid`),
  KEY `k3` (`touser`),
  KEY `k4` (`triggerbyparentid`)
);

drop table if exists `gmis_info_attachefiletbl`;
CREATE TABLE `gmis_info_attachefiletbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `parentid` int(11) NOT NULL DEFAULT '0',
  `parenttype` char(32) NOT NULL DEFAULT '',
  `filename` char(64) NOT NULL DEFAULT '',
  `filetype` char(16) NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `filepath` char(64) NOT NULL DEFAULT '',
  `istate` tinyint(4) NOT NULL DEFAULT '1',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
);

drop table if exists `gmis_info_grouptbl`;
CREATE TABLE `gmis_info_grouptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` char(32) NOT NULL DEFAULT '',
  `grouplevel` tinyint(1) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`groupname`),
  UNIQUE KEY `key3` (`grouplevel`)
);

drop table if exists `gmis_info_helptbl`;
CREATE TABLE `gmis_info_helptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `orderno` tinyint(1) NOT NULL DEFAULT '0',
  `click` mediumint(4) NOT NULL DEFAULT '0',
  `reply` mediumint(4) NOT NULL DEFAULT '0',
  `isfaq` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`title`)
);

drop table if exists `gmis_info_menulist`;
CREATE TABLE `gmis_info_menulist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkname` char(24) NOT NULL DEFAULT '',
  `levelcode` char(48) NOT NULL DEFAULT '',
  `modulename` char(48) NOT NULL DEFAULT '',
  `dynamicpara` char(128) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `operator` char(24) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `disptitle` char(24) NOT NULL DEFAULT '',
  `thedb` char(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `singlecode` (`levelcode`)
);

drop table if exists `gmis_info_objectfieldtbl`;
CREATE TABLE `gmis_info_objectfieldtbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `fieldname` char(32) NOT NULL DEFAULT '',
  `fieldtype` char(16) NOT NULL DEFAULT '0',
  `fieldlength` mediumint(4) NOT NULL DEFAULT '32',
  `defaultvalue` char(32) NOT NULL DEFAULT '',
  `otherset` char(32) NOT NULL DEFAULT '',
  `fieldmemo` char(255) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `chnname` char(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`parentid`,`fieldname`)
);

drop table if exists `gmis_info_objectgrouptbl`;
CREATE TABLE `gmis_info_objectgrouptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` char(32) NOT NULL DEFAULT '',
  `grouplevel` tinyint(1) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`groupname`),
  UNIQUE KEY `key3` (`grouplevel`)
);

drop table if exists `gmis_info_objectindexkeytbl`;
CREATE TABLE `gmis_info_objectindexkeytbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `indexname` char(32) NOT NULL DEFAULT '',
  `indextype` char(32) NOT NULL DEFAULT '',
  `onfield` char(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`parentid`,`indexname`)
);

drop table if exists `gmis_info_objecttbl`;
CREATE TABLE `gmis_info_objecttbl` (
  `id` mediumint(6) NOT NULL AUTO_INCREMENT,
  `objname` char(32) NOT NULL DEFAULT '',
  `tblname` char(32) NOT NULL DEFAULT '',
  `objgroup` tinyint(1) NOT NULL DEFAULT '0',
  `tblfield` char(254) NOT NULL,
  `tblindex` char(254) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `addtodesktop` tinyint(1) NOT NULL DEFAULT '0',
  `operator` char(32) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL,
  `inserttime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`tblname`)
);

drop table if exists `gmis_info_operateareatbl`;
CREATE TABLE `gmis_info_operateareatbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areacode` char(16) NOT NULL DEFAULT '',
  `areaname` char(32) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`areacode`)
);

drop table if exists `gmis_info_siteusertbl`;
CREATE TABLE `gmis_info_siteusertbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` char(32) NOT NULL DEFAULT '',
  `username` char(24) NOT NULL DEFAULT '',
  `realname` char(8) NOT NULL,
  `password` char(64) NOT NULL DEFAULT '',
  `avatar` char(8) NOT NULL,
  `company` char(200) NOT NULL,
  `gender` int(2) NOT NULL,
  `mobile` char(12) NOT NULL,
  `qq` int(12) NOT NULL,
  `money` char(8) NOT NULL,
  `score` char(8) NOT NULL,
  `zipcode` char(6) NOT NULL,
  `address` char(200) NOT NULL,
  `city_id` char(4) NOT NULL,
  `enable` int(2) NOT NULL,
  `manager` int(2) NOT NULL,
  `secret` char(16) NOT NULL,
  `recode` char(16) NOT NULL,
  `ip` char(64) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `istate` int(2) NOT NULL,
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
);

drop table if exists `gmis_info_toolsettbl`;
CREATE TABLE `gmis_info_toolsettbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iname` char(64) NOT NULL DEFAULT '',
  `iurl` char(255) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `inserttime` datetime NOT NULL DEFAULT '0001-01-01 00:00:01',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ioperator` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk1` (`iname`),
  KEY `ik1` (`istate`)
);

drop table if exists `gmis_info_usertbl`;
CREATE TABLE `gmis_info_usertbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` char(64) NOT NULL DEFAULT '',
  `realname` char(32) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL DEFAULT '',
  `usergroup` tinyint(1) NOT NULL DEFAULT '0',
  `branchoffice` char(16) NOT NULL DEFAULT '',
  `operatearea` char(255) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `operator` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniemail` (`email`)
);

drop table if exists `gmis_insitesearchtbl`;
CREATE TABLE `gmis_insitesearchtbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idb` char(24) NOT NULL DEFAULT '',
  `itbl` char(64) NOT NULL DEFAULT '',
  `ifield` char(64) NOT NULL DEFAULT '',
  `ivalue` varchar(255) NOT NULL DEFAULT '',
  `imd5` char(32) NOT NULL DEFAULT '' COMMENT 'md5(idb, itbl, ifield, ivalue)',
  `icount` mediumint(8) NOT NULL DEFAULT '1',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:01',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`imd5`),
  KEY `k3` (`ivalue`)
);

drop table if exists `gmis_issblackwhitetbl`;
CREATE TABLE `gmis_issblackwhitetbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idb` char(24) NOT NULL DEFAULT '',
  `itbl` char(64) NOT NULL DEFAULT '',
  `ifield` char(64) NOT NULL DEFAULT '',
  `isblack` tinyint(1) NOT NULL DEFAULT '0',
  `iswhite` tinyint(1) NOT NULL DEFAULT '0',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:01',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`idb`,`itbl`,`ifield`)
);

drop table if exists `gmis_mydesktoptbl`;
CREATE TABLE `gmis_mydesktoptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `useremail` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

drop table if exists `gmis_mynotetbl`;
CREATE TABLE `gmis_mynotetbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `notecode` char(24) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `istate` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `operator` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `k3` (`inserttime`)
);

drop table if exists `gmis_useraccesstbl`;
CREATE TABLE `gmis_useraccesstbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `usergroup` int(11) NOT NULL DEFAULT '0',
  `objectid` mediumint(6) NOT NULL DEFAULT '0',
  `objectfield` char(255) NOT NULL DEFAULT '',
  `objectgroup` tinyint(1) NOT NULL DEFAULT '0',
  `accesstype` tinyint(1) NOT NULL DEFAULT '0',
  `operatelog` char(64) NOT NULL,
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `inserttime` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `memo` char(15) NOT NULL,
  `operator` char(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`userid`,`usergroup`,`objectid`,`objectgroup`,`objectfield`)
);

drop table if exists `gmis_dict_infotbl`;
CREATE TABLE `gmis_dict_infotbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `ikey` char(24) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'dict key',
  `ivalue` char(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'dict value',
  PRIMARY KEY (`id`)
);

drop table if exists `gmis_dict_detailtbl`;
CREATE TABLE `gmis_dict_detailtbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `itype` char(24) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'dict key type',
  `ikey` char(128) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'item name',
  `ivalue` char(16) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'item value',
  `iorder` int(12) NOT NULL DEFAULT '0' COMMENT 'order no',
  PRIMARY KEY (`id`),
  KEY `k2` (`stype`),
  unique key k3(`itype`, `ivalue`)
);
