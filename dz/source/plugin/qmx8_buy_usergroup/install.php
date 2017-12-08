<?php

/*
更多商业插件源码请登录星期六源码xqlzm.com，星期六源码，提供商业插件源码破解，模板定制，插件定制，系统开发
 */

if(!defined('IN_DISCUZ')) {



	exit('Access Denied');



}







$sql = <<<EOF







DROP TABLE IF EXISTS cdb_qmx8_usergroup;



CREATE TABLE IF NOT EXISTS `cdb_qmx8_usergroup` (



  `orderid` char(32) NOT NULL,



  `status` char(3) NOT NULL,



  `uid` bigint(11) unsigned NOT NULL,



  `trade_no` char(50) NOT NULL,



  `gid` mediumint(9) NOT NULL,



  `gname` varchar(256) NOT NULL ,



  `extcredits` varchar(256) NOT NULL,



  `price` float(7,2) NOT NULL,



  `validity` char(10) NOT NULL,



  `submitdate` int(10) NOT NULL,



  `confirmdate` int(10) NOT NULL,



  `ip` char(15) NOT NULL,



  `pay_type` char(15) NOT NULL,



  UNIQUE KEY `orderid` (`orderid`),



  KEY `submitdate` (`submitdate`),



  KEY `uid` (`uid`)



) ENGINE=MyISAM;







EOF;







runquery($sql);







$finish = TRUE;







?>