<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

//$showadmin = 1;
if($_G['adminid'] == 1){
	$showadmin = true;
}

$navtitle = $shenlan_center_config['name']." - ";
$metakeywords = $shenlan_center_config['seo_keywords'];
$metadescription=$shenlan_center_config['seo_description'];

if(defined('IN_MOBILE')){
	include template('shenlan_center:'.$style.'/index');
}else{
	if($_G['setting']['version'] >='X3'){
		include template('diy:shenlan_center/template/'.$style.'/index',null,"source/plugin/");
	}else{
		include template('diy:../../source/plugin/shenlan_center/template/'.$style.'/index');
	}
}
?>