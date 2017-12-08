<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
DB::query("DROP TABLE IF EXISTS ".DB::table('threed_pan')."");

//DEFAULT CHARSET=gbk;
$finish = TRUE;
?>