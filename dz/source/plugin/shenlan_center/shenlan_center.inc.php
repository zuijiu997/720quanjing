<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}

global $shenlan_center_config;
/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

include_once DISCUZ_ROOT.'./source/plugin/shenlan_center/include/config.inc.php';
include_once DISCUZ_ROOT.'./source/plugin/shenlan_center/include/function.class.php';

$mod_array = array('index');
$mod = in_array($_GET['mod'],$mod_array)? addslashes($_GET['mod']) : 'index';

if(defined('IN_MOBILE')){
	$style = "default";
	$mod = $mod =='index' ? 'list' : $mod;
}else{
	$style = $shenlan_center_config['style'];
}
require_once DISCUZ_ROOT.'./source/plugin/shenlan_center/module/'.$mod.'.inc.php';
