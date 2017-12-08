<?php
/*
 * Install Uninstall Upgrade AutoStat System Code 2013092317UUEvZUutuT
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS pre_study_freedown_log;
EOF;
runquery($sql);
$finish = TRUE;
}
?>