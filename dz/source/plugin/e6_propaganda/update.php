<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
!$fromversion && $fromversion = $_GET['fromversion'];
if ($fromversion >= 3.20) {
	$finish = true;
} elseif ($fromversion >= 3) {
	DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `register`='0'");
	$query = DB::query("SELECT `fuid1` FROM ".DB::table('e6_pro_user')." ORDER BY NULL");
	while($rt = DB::fetch($query)) {
		DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `register`=`register`+1 WHERE `uid`='{$rt['fuid1']}'");
	}
	$finish = true;
} else {
$url = preg_replace('/(.*)\/admin\.php\?/i', '', $_SERVER['REQUEST_URI']);
$n = intval($_GET['n']);
$url = preg_replace('/&n=' . $n . '/i', '', $url);
$num = 100;
$startlimit = $n * $num;
$numlimit = ($n+1) * $num;
$limit = "LIMIT {$startlimit},{$numlimit}";
if (empty($_GET['step'])) {
	$SQL = <<<SQL
RENAME TABLE  `e6_pro_user` TO  `pre_e6_pro_user` ;
RENAME TABLE  `e6_pro_credit` TO  `pre_e6_pro_credit` ;
RENAME TABLE  `e6_pro_finance` TO  `pre_e6_pro_finance` ;
RENAME TABLE  `e6_pro_clientorder` TO  `pre_e6_pro_clientorder` ;
RENAME TABLE  `e6_pro_visit` TO  `pre_e6_pro_visit` ;
CREATE TABLE IF NOT EXISTS `pre_e6_pro_user_count` (
  `uid` mediumint(8) unsigned NOT NULL,
  `withdraw` mediumint(8) unsigned NOT NULL,
  `ip` smallint(5) unsigned NOT NULL,
  `register` smallint(5) unsigned NOT NULL,
  `money` mediumint(8) unsigned NOT NULL,
  `task` smallint(4) unsigned NOT NULL,
  `paymoney` decimal(8,2) unsigned NOT NULL,
  `area` smallint(5) unsigned NOT NULL,
  `upvip` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM;
CREATE TABLE IF NOT EXISTS `pre_e6_pro_task` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `participate` smallint(5) unsigned NOT NULL,
  `complete` smallint(5) unsigned NOT NULL,
  `claim` tinyint(1) unsigned NOT NULL,
  `claim1` smallint(5) unsigned NOT NULL,
  `claim2` smallint(5) unsigned NOT NULL,
  `reward` tinyint(1) unsigned NOT NULL,
  `reward1` smallint(5) unsigned NOT NULL,
  `reward2` smallint(5) unsigned NOT NULL,
  `grouplimit` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
CREATE TABLE IF NOT EXISTS `pre_e6_pro_task_list` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL,
  `value` mediumint(8) NOT NULL,
  `taskid` smallint(5) unsigned NOT NULL,
  `ok` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`taskid`)
) ENGINE=MyISAM; 
SQL;
runquery($SQL);
	cpmsg("&#26356;&#26032;&#20013;......(&#31532;2&#27493;/&#20849;10&#27493;)", "{$url}&step=1", 'succeed');
} elseif ($_GET['step'] == 1) {
 	$query = DB::query("SELECT `uid` FROM " .DB::table('e6_pro_user')." ORDER BY `id` ASC $limit");
	while($rt = DB::fetch($query)) {
		$rt['Y'] = DB::result_first("SELECT `uid` FROM " .DB::table('e6_pro_user_count')." WHERE `uid`='{$rt['uid']}'");
		if ($rt['Y']) {
			$rt['N'] = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_user')." WHERE `uid`='{$rt['uid']}'");
			if($rt['N']>1) {
				DB::query("DELETE FROM ".DB::table('e6_pro_user_count')." WHERE `uid`='{$rt['uid']}'");
			}
		} else {
			DB::query("INSERT INTO " .DB::table('e6_pro_user_count')." SET `uid`='{$rt['uid']}'");
		}
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;2-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=1/i', '&step=2', $url);
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;3&#27493;/&#20849;10&#27493;)", $url, 'succeed');
	}
} elseif ($_GET['step'] == 2) {
 	$query = DB::query("SELECT `uid`,`money` FROM ".DB::table('e6_pro_finance')." WHERE `ok`='1' ORDER BY `id` ASC $limit");
	while($rt = DB::fetch($query)) {
		DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `withdraw`=`withdraw`+{$rt['money']} WHERE `uid`='{$rt['uid']}'");
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;3-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=2/i', '&step=3', $url);
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;4&#27493;/&#20849;10&#27493;)", $url, 'succeed');
	}
} elseif ($_GET['step'] == 3) {
 	$query = DB::query("SELECT `fuid1`,`region`,`activation1`,`activation2`,`activation3`,`activation4`,`activation5`,`activation6`,`activation7`,`activation8`,`activation9`,`activation10` FROM ".DB::table('e6_pro_user')." ORDER BY `id` DESC $limit");
	while($rt = DB::fetch($query)) {
		$set = '';
		if ($rt['region'] == 1) {
			$set = ",`area`=`area`+1";
		}
		if ($rt['activation1'] or $rt['activation2'] or $rt['activation3'] or $rt['activation4'] or $rt['activation5'] or $rt['activation6'] or $rt['activation7'] or $rt['activation8'] or $rt['activation9'] or $rt['activation10']) {
			$rt['active'] = DB::result_first("SELECT `active` FROM ".DB::table('e6_pro_user_count')." WHERE `uid`='{$rt['fuid1']}'");
			if ($rt['active']) {
				$active = unserialize($active);
			}
			for ($m = 1; $m <= 10; $m++) {
				!$active[$m] && $active[$m] = 0;
				$active[$m] = $active[$m] + $rt['activation'.$m];
			}
			$active = serialize($active);
			$set .= ",`active`='$active'";
		}
		DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `register`=`register`+1{$set} WHERE `uid`='{$rt['fuid1']}'");
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;4-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=3/i', '&step=4', $url);
		cpmsg('&#26356;&#26032;&#20013;......(&#31532;5&#27493;/&#20849;10&#27493;)', $url, 'succeed');
	}
} elseif ($_GET['step'] == 4) {
 	$query = DB::query("SELECT `uid` FROM ".DB::table('e6_pro_credit')." WHERE `logtype`=1 GROUP BY `date` ORDER BY `id` ASC $limit");
	while ($rt = DB::fetch($query)) {
		DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `ip`=`ip`+1 WHERE `uid`='{$rt['uid']}'");
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;5-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=4/i', '&step=5', $url);
		cpmsg('&#26356;&#26032;&#20013;......(&#31532;6&#27493;/&#20849;10&#27493;)', $url, 'succeed');
	}
} elseif ($_GET['step'] == 5) {
	require DISCUZ_ROOT . 'data/propaganda.config.php';
 	if ($pro['multi'] && $pro['pay_money'] && $pro['pay_type']) {
		require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
		$query = DB::query("SELECT * FROM " .DB::table('e6_pro_user')." ORDER BY `id` ASC $limit");
		while($rt = DB::fetch($query)) {
			for($m=1; $m<=10; $m++) {
				if ($rt['fuid'.$m] && ($rt['money'.$m]>1)) {
					$username = E6::M()->get_username($rt['fuid'.$m]);
					$son_username = E6::M()->get_username($rt['uid']);
					$smoney = E6::M()->get_usermoney($rt['fuid'.$m], $pro['pay_type']);
					E6::M()->get_usermoney($rt['fuid'.$m], $pro['pay_type'], $rt['money'.$m]);
					$emoney = E6::M()->get_usermoney($rt['fuid'.$m], $pro['pay_type']);
					DB::query("INSERT INTO ".DB::table(E6::M()->log_table)." SET
						`uid`		=	'".$rt['fuid'.$m]."',
						`username`	=	'{$username}',
						`type`		=	'{$pro['pay_type']}',
						`logtype`	=	'6',
						`smoney`	=	'{$smoney}',
						`emoney`	=	'{$emoney}',
						`change`	=	'".$rt['money'.$m]."',
						`date`		=	'{$_G['timestamp']}',
						`ip`		=	'{$_G['clientip']}',
						`describe`	=	'&#22240;&#31995;&#32479;&#21319;&#32423;&#44;&#33258;&#21160;&#39046;&#21462;&#19979;&#32447;: {$son_username} &#20805;&#20540;&#22870;&#21169;'
					");
				}
			}
			$Y = 1;
		}
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;6-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=5/i', '&step=6', $url);
		cpmsg('&#26356;&#26032;&#20013;......(&#31532;7&#27493;/&#20849;10&#27493;)', $url, 'succeed');
	}
} elseif ($_GET['step'] == 6) {
	$sql = <<<SQL
ALTER TABLE  `pre_e6_pro_clientorder` CHANGE  `order_no`  `orderid` CHAR( 32 ) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL;
ALTER TABLE  `pre_e6_pro_clientorder` ADD  `type` TINYINT( 1 ) UNSIGNED NOT NULL ,
ADD  `price` DECIMAL( 6, 2 ) UNSIGNED NOT NULL;
SQL;
	runquery($sql);
	DB::query("UPDATE ".DB::table('e6_pro_clientorder')." SET `type`=1 WHERE LENGTH(`orderid`) <> 32");
	$url = preg_replace('/&step=6/i', '&step=7', $url);
	cpmsg('&#26356;&#26032;&#20013;......(&#31532;8&#27493;/&#20849;10&#27493;)', $url, 'succeed');
} elseif ($_GET['step'] == 7) {
 	$query = DB::query("SELECT o.price,m.fuid1 FROM ".DB::table('e6_pro_clientorder')." p LEFT JOIN ".DB::table('forum_order')." o ON p.orderid=o.orderid LEFT JOIN ".DB::table('e6_pro_user')." m ON p.uid=m.uid ORDER BY p.id DESC $limit");
	while($rt = DB::fetch($query)) {
		if ($rt['fuid1']) {
			DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `paymoney`=`paymoney`+'{$rt['price']}' WHERE `uid`='{$rt['fuid1']}'");
		}
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;8-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=7/i', '&step=8', $url);
		cpmsg('&#26356;&#26032;&#20013;......(&#31532;9&#27493;/&#20849;10&#27493;)', $url, 'succeed');
	}
} elseif ($_GET['step'] == 8) {
	$query = DB::query("SELECT sum(`change`) as allmoney,uid FROM ".DB::table('e6_pro_credit')." WHERE `logtype`<=4 GROUP BY `uid` ORDER BY `uid` ASC $limit");
	while($rt = DB::fetch($query)) {
		DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`='{$rt['allmoney']}' WHERE `uid`='{$rt['uid']}'");
		$Y = 1;
	}
	$n++;
	if ($Y) {
		cpmsg("&#26356;&#26032;&#20013;......(&#31532;9-{$n}&#27493;/&#20849;10&#27493;)", "{$url}&n={$n}", 'succeed');
	} else {
		$url = preg_replace('/&step=8/i', '&step=9', $url);
		cpmsg('&#26356;&#26032;&#20013;......(&#31532;10&#27493;/&#20849;10&#27493;)', $url, 'succeed');
	}
} elseif ($_GET['step'] == 9) {
	@unlink(DISCUZ_ROOT . '/data/propaganda.config.php');
	@unlink(DISCUZ_ROOT . '/source/plugin/e6_propaganda/e6_function.php');
	$sql = <<<SQL
ALTER TABLE  `pre_e6_pro_user` DROP  `register` ,
DROP  `money1` ,
DROP  `money2` ,
DROP  `money3` ,
DROP  `money4` ,
DROP  `money5` ,
DROP  `money6` ,
DROP  `money7` ,
DROP  `money8` ,
DROP  `money9` ,
DROP  `money10` ;
ALTER TABLE  `pre_e6_pro_user` ADD  `vip` TINYINT( 1 ) UNSIGNED NOT NULL AFTER  `region`;
ALTER TABLE  `pre_e6_pro_user` CHANGE  `id`  `id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE  `pre_e6_pro_credit` CHANGE  `id`  `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE  `pre_e6_pro_finance` CHANGE  `id`  `id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE  `pre_e6_pro_finance` ADD  `feemoney` SMALLINT( 5 ) UNSIGNED NOT NULL AFTER  `type` ,
ADD  `feetype` TINYINT( 2 ) UNSIGNED NOT NULL AFTER  `feemoney`;
ALTER TABLE  `pre_e6_pro_clientorder` ADD INDEX (  `date` );
ALTER TABLE `pre_e6_pro_visit` DROP `url`;
ALTER TABLE  `pre_e6_pro_visit` CHANGE  `id`  `id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT;
SQL;
	runquery($sql);
	$finish = true;
}
}
?>