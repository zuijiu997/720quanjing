<?php
/*
 * Install Uninstall Upgrade AutoStat System Code
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE `pre_study_freedown_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
EOF;

runquery($sql);
$finish = TRUE;

?>