<?php
// +----------------------------------------------------------------------
// | Copyright:    (c) 2013-2014 http://www.adminbuy.cn All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    ABģ����
// +----------------------------------------------------------------------
// | Author:       ���� QQ:9490489
// +----------------------------------------------------------------------

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$identifier = CURMODULE;
$splugin_setting = $_G['cache']['plugin'][$identifier];
$splugin_lang = lang('plugin/'.$identifier);
include template($identifier.':faq');
?>