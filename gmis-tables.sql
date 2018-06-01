-- MySQL dump 10.13  Distrib 5.5.25a, for Linux (i686)
--
-- Host: localhost    Database: gmisdb
-- ------------------------------------------------------
-- Server version	5.5.25a-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gmis_fin_operatelogtbl`
--

DROP TABLE IF EXISTS `gmis_fin_operatelogtbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_fin_operatelogtbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `parenttype` char(32) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0',
  `useremail` char(32) NOT NULL DEFAULT '',
  `actionstr` char(255) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_fin_todotbl`
--

DROP TABLE IF EXISTS `gmis_fin_todotbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_fin_todotbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskname` char(128) NOT NULL DEFAULT '',
  `tasktype` tinyint(1) NOT NULL DEFAULT '0',
  `triggerbyparent` char(64) NOT NULL DEFAULT '',
  `triggerbyparentid` int(11) NOT NULL DEFAULT '0',
  `togroup` char(32) NOT NULL DEFAULT '',
  `touser` char(32) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `taskmemo` varchar(2048) NOT NULL DEFAULT '',
  `taskfile` char(255) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_attachefiletbl`
--

DROP TABLE IF EXISTS `gmis_info_attachefiletbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_grouptbl`
--

DROP TABLE IF EXISTS `gmis_info_grouptbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_grouptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` char(32) NOT NULL DEFAULT '',
  `grouplevel` tinyint(1) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`groupname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_helptbl`
--

DROP TABLE IF EXISTS `gmis_info_helptbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_helptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `orderno` tinyint(1) NOT NULL DEFAULT '0',
  `click` mediumint(4) NOT NULL DEFAULT '0',
  `reply` mediumint(4) NOT NULL DEFAULT '0',
  `isfaq` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_menulist`
--

DROP TABLE IF EXISTS `gmis_info_menulist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_menulist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkname` char(24) NOT NULL DEFAULT '',
  `levelcode` char(12) NOT NULL DEFAULT '',
  `modulename` char(48) NOT NULL DEFAULT '',
  `dynamicpara` char(128) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `operator` char(24) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `disptitle` char(24) NOT NULL DEFAULT '',
  `thedb` char(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `singlecode` (`levelcode`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_objectfieldtbl`
--

DROP TABLE IF EXISTS `gmis_info_objectfieldtbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_objectfieldtbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `fieldname` char(32) NOT NULL DEFAULT '',
  `fieldtype` char(16) NOT NULL DEFAULT '0',
  `fieldlength` mediumint(4) NOT NULL DEFAULT '32',
  `defaultvalue` char(32) NOT NULL DEFAULT '',
  `otherset` char(32) NOT NULL DEFAULT '',
  `fieldmemo` char(255) NOT NULL DEFAULT '',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `chnname` char(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`parentid`,`fieldname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_objectgrouptbl`
--

DROP TABLE IF EXISTS `gmis_info_objectgrouptbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_objectgrouptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` char(32) NOT NULL DEFAULT '',
  `grouplevel` tinyint(1) NOT NULL DEFAULT '0',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`groupname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_objectindexkeytbl`
--

DROP TABLE IF EXISTS `gmis_info_objectindexkeytbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_objectindexkeytbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `indexname` char(32) NOT NULL DEFAULT '',
  `indextype` char(32) NOT NULL DEFAULT '',
  `onfield` char(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`parentid`,`indexname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_objecttbl`
--

DROP TABLE IF EXISTS `gmis_info_objecttbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_operateareatbl`
--

DROP TABLE IF EXISTS `gmis_info_operateareatbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_operateareatbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areacode` char(16) NOT NULL DEFAULT '',
  `areaname` char(32) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` char(32) NOT NULL DEFAULT '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`areacode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_siteusertbl`
--

DROP TABLE IF EXISTS `gmis_info_siteusertbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `istate` int(2) NOT NULL,
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_info_usertbl`
--

DROP TABLE IF EXISTS `gmis_info_usertbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_usertbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` char(64) NOT NULL DEFAULT '',
  `realname` char(32) NOT NULL DEFAULT '',
  `email` char(32) NOT NULL DEFAULT '',
  `usergroup` tinyint(1) NOT NULL DEFAULT '0',
  `branchoffice` char(16) NOT NULL default '',
  `operatearea` char(255) NOT NULL DEFAULT '',
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `operator` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniemail` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_mydesktoptbl`
--

DROP TABLE IF EXISTS `gmis_mydesktoptbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_mydesktoptbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `useremail` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gmis_mynotetbl`
--

DROP TABLE IF EXISTS `gmis_mynotetbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_mynotetbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `starttime` datetime NOT NULL,
  `neirong` char(64) NOT NULL,
  `istate` char(10) NOT NULL,
  `people` char(10) NOT NULL,
  `operator` varchar(10) NOT NULL,
  `datatime` datetime NOT NULL,
  `jieshutime` datetime NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gmis_info_toolsettbl`
--

DROP TABLE IF EXISTS `gmis_info_toolsettbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_info_toolsettbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iname` char(64) NOT NULL default '',
  `iurl` char(255) NOT NULL default '',
  `istate` tinyint(1) NOT NULL DEFAULT '1',
  `inserttime` datetime not NULL default '0001-01-01 00:00:01',
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ioperator` char(32) NOT NULL default '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk1` (`iname`),
  KEY `ik1` (`istate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gmis_useraccesstbl`
--

DROP TABLE IF EXISTS `gmis_useraccesstbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `inserttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `memo` char(15) NOT NULL,
  `operator` char(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`userid`,`usergroup`,`objectid`,`objectgroup`,`objectfield`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-12  8:21:05

-- added by @Xenxin, May 29, 2018
DROP TABLE IF EXISTS `gmis_insitesearchtbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gmis_insitesearchtbl` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `idb` char(24) NOT NULL DEFAULT '',
  `itbl` char(64) NOT NULL DEFAULT '',
  `ifield` char(64) NOT NULL DEFAULT '',
  `ivalue` varchar(255) NOT NULL DEFAULT '',
  `imd5` char(32) NOT NULL DEFAULT '' comment 'md5(idb, itbl, ifield, ivalue)',
  `icount` mediumint(8) NOT NULL DEFAULT '1',
  `updatetime` datetime NOT NULL DEFAULT '1001-01-01 00:00:01',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key2` (`imd5`),
  index `k3` (`ivalue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
