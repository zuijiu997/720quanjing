<?php

/*
更多商业插件源码请登录星期六源码xqlzm.com，星期六源码，提供商业插件源码破解，模板定制，插件定制，系统开发
 */



if(!defined('IN_DISCUZ')) {

	exit('Access Denied');

}

class plugin_qmx8_buy_usergroup {



	function global_usernav_extra3() {



		global $_G;

		if(!$_G['uid']) {

			return;

		}

		$var=$_G['cache']['plugin']['qmx8_buy_usergroup'];

		if($var['b_user_tip']!=""){

					$str= '<a target="_blank" href="plugin.php?id=qmx8_buy_usergroup:vip" style="color:#FF6633; "><strong>'.$var['b_user_tip'].'</strong></a><span class="pipe">|</span>';

			

		}	

		return $str;

	}











}



?>