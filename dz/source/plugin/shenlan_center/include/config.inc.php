<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('plugin');
$shenlan_center_config = $_G['cache']['plugin']['shenlan_center'];
$shenlan_center_config["siteurl"] = $_G["siteurl"];
$shenlan_center_config["root"] = $shenlan_center_config["siteurl"].'source/plugin/shenlan_center';
$shenlan_center_config['shenlan_center'] = $shenlan_center_config["siteurl"].'source/plugin/shenlan_center';
$shenlan_center_config["images"] = $shenlan_center_config["siteurl"].'source/plugin/shenlan_center/template/admin/images';
$shenlan_center_lang = lang('plugin/shenlan_center');
$shenlan_center_config['style'] = "default";
?>