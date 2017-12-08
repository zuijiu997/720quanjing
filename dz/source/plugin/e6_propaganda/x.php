<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
!$GLOBALS['hack_e6_propaganda'] && require_once DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
!$e6_propaganda && $e6_propaganda = $GLOBALS['e6_propaganda'];
if ($e6_propaganda['open'] == 1) {
	$e6_reg && $x = getcookie('pro_x');
	!is_numeric($x) && $x = 0;
	$x && $user = E6::M()->get_user($x, 'uid,username,groupid');
	if ($x && (!$e6_propaganda['group'] or in_array($user['groupid'], $e6_propaganda['group']))) {
		$reg_Y = DB::result_first("SELECT `uid` FROM " . DB::table('e6_pro_user') . " WHERE `uid`='{$_G['uid']}'");
		if ($e6_reg && !$reg_Y) {
			$fuid_all = E6::M()->get_prouser($x);
			DB::query("INSERT INTO " . DB::table('e6_pro_user') . " (`uid`,`fuid1`,`fuid2`,`fuid3`,`fuid4`,`fuid5`,`fuid6`,`fuid7`,`fuid8`,`fuid9`,`fuid10`) VALUES ('{$_G['uid']}','$x','{$fuid_all['fuid1']}','{$fuid_all['fuid2']}','{$fuid_all['fuid3']}','{$fuid_all['fuid4']}','{$fuid_all['fuid5']}','{$fuid_all['fuid6']}','{$fuid_all['fuid7']}','{$fuid_all['fuid8']}','{$fuid_all['fuid9']}')");
			DB::query("INSERT INTO " . DB::table('e6_pro_user_count') ." SET `uid`={$_G['uid']}");
			if ($e6_propaganda['registertype'] && array_sum($e6_propaganda['max_register'])) {
				$my_date = strtotime(dgmdate($_G['timestamp'], 'Y-m-d'));
				$query = DB::query("SELECT sum(`change`) as allmoney,`type` FROM ".DB::table('e6_pro_credit')." WHERE `uid`='$x' AND `logtype`='2' GROUP BY `type`");
				while($rt = DB::fetch($query)){
					$my_allmoney[$rt['type']] = $rt['allmoney'];
				}
				foreach($e6_propaganda['max_register'] as $key => $value) {
					if ($value && ($my_allmoney[$key] >= $value)) {
						$no_money = 1;
						$money_list = E6::M()->money_list();
						$e6_propaganda['cheatlog'] && E6::M()->money(false, '9h', $x, array($_G['username'], $money_list[$key]));
						break;
					}
				}
			}
			if (!$no_money && $e6_propaganda['registertype'] == 1) {
				$register_sum = array_sum($e6_propaganda['register_money']);
				if ($register_sum) {
					E6::M()->money($e6_propaganda['register_money'], '2a', $x, $_G['username']);
					DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+$register_sum WHERE `uid`='$x'");
				}
			} elseif (!$no_money && $e6_propaganda['registertype'] == 2){
				for($n = 1; $n <= 10; $n++) {
					if ($e6_propaganda['multi_reg_' . $n]) {
						if ($n == 1) {
							$f_uid = $x;
						} else {
							$m = $n-1;
							$f_uid = $fuid_all['fuid'.$m];
						}
						if ($f_uid) {
							$x_groupid = E6::M()->get_user($f_uid, 'groupid');
							if ($e6_propaganda['dividendl_' . $x_groupid] >= $n) {
								E6::M()->money(array($e6_propaganda['multi_regtype_'.$n]=>$e6_propaganda['multi_reg_'.$n]), '2b', $f_uid, array($_G['username'],$n));
								DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+".$e6_propaganda['multi_reg_'.$n]." WHERE `uid`='$f_uid'");
							}
						} else {
							break;
						}
					}
				}
			}
			$region_sum = array_sum($e6_propaganda['region_money']);
			if ($region_sum && $e6_propaganda['area']) {
				if($e6_propaganda['iptype'] ==1) {
					require_once libfile('function/misc');
					$file_region = convertip($_G['clientip']);
				} elseif ($e6_propaganda['iptype'] ==2) {
					$ext = stream_context_create(array('http' => array('timeout' => 3)));
					$url_region = "http://www.baidu.com/s?wd=".$_G['clientip'];
					$file_regions = @file_get_contents($url_region, false, $ext);
					if($file_regions){
						$file_regions = iconv("UTF-8", "GB2312//IGNORE", $file_regions);
						preg_match("/<p class=\"op_ip_detail\">" . e6_c('x_1') . "&nbsp;&nbsp;&nbsp;" . e6_c('x_2') . ":&nbsp;<strong>(.*)<\/strong><\/p>/i", $file_regions, $str);
						$file_region  = $str[1];
					}
					if (!$file_region) {
						require_once libfile('function/misc');
						$file_region = convertip($_G['clientip']);
					}
				}
				$arr_area = explode(',', $e6_propaganda['area']);
				foreach ($arr_area as $value) {
					if (strstr($file_region, $value)){
						$area_ok = 1;
						break;
					}
				}
				if ($area_ok == 1) {
					E6::M()->money($e6_propaganda['region_money'], '3', $x, $_G['username']);
					DB::query("UPDATE ".DB::table('e6_pro_user')." SET `region`='1' WHERE uid='$_G[uid]'");
					DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+$region_sum WHERE `uid`='$x'");
				}
			}
			if ($e6_propaganda['message'] == 1) {
				$message = e6_c('x_3') . ': <br>' . e6_c('x_4') . $_G['username'] . e6_c('x_5') . dgmdate($_G['timestamp'],'Y-m-d H:i:s') . e6_c('x_6');
				E6::M()->msg($x, e6_c('x_7'), $message);
			}
			$e6_propaganda['cookie'] != '-1' && dsetcookie('pro_x','',-3600);
			DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `register`=`register`+1 WHERE `uid`='$x'");
		}else{
			if (!$_G['uid'] && ($e6_propaganda['cookie'] == '-1' or !getcookie('pro'))) {
				if (E6::M()->get_username($x)) {
					E6::M()->get_prouser($x);
					if ($e6_propaganda['ip']) {
						$overdate = $_G['timestamp'] - ($e6_propaganda['ip'] * 3600);
						DB::query("DELETE FROM ".DB::table('e6_pro_visit')." WHERE `date`<'$overdate'");
						$ip_uid = DB::result_first("SELECT `uid` FROM " . DB::table('e6_pro_visit') . " WHERE `ip`='{$_G['clientip']}' ORDER BY NULL LIMIT 1");
						if (!$ip_uid) {
							if ($e6_propaganda['interval'] or $e6_propaganda['ipsection']) {
								$ip_y = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_visit')." WHERE `uid`='$x' ORDER BY `id` DESC LIMIT 1");
								if ($e6_propaganda['interval']) {
									if (($_G['timestamp'] - $ip_y['date']) < $e6_propaganda['interval']) {
										$e6_propaganda['cheatlog'] && E6::M()->money(false, '9e', $x, array($_G['clientip'], $e6_propaganda['interval']));
										$pro_no = 1;
									}
								}
								if (!$pro_no && $e6_propaganda['ipsection']) {
									$ip_arr1 = explode('.', $ip_y['ip']);
									$ip_arr2 = explode('.', $_G['clientip']);
									if ($ip_arr1[0] == $ip_arr2[0] && $ip_arr1[1] == $ip_arr2[1]) {
										$e6_propaganda['cheatlog'] && E6::M()->money(false, '9f', $x, array($_G['clientip'], $ip_y['ip']));
										$pro_no = 1;
									}
								}
							}
							if (!$pro_no) {
								dsetcookie('pro_x',$x ,315360000);
								DB::query("INSERT INTO " . DB::table('e6_pro_visit') . " SET `uid`='{$x}',`ip`='{$_G['clientip']}',`date`='{$_G['timestamp']}'");
								$visit_money = 1;
							}
						} else {
							if ($e6_propaganda['cheatlog']){
								$pro_username = E6::M()->get_username($ip_uid);
								E6::M()->money(false, '9d', $x, array($_G['clientip'], $pro_username));
							}
						}
					} else {
						dsetcookie('pro_x',$x ,315360000);
						$visit_money = 1;
					}
					if ($visit_money && array_sum($e6_propaganda['max_visit'])) {
						$my_date = strtotime(dgmdate($_G['timestamp'], 'Y-m-d'));
						$query = DB::query("SELECT sum(`change`) as allmoney,`type` FROM ".DB::table('e6_pro_credit')." WHERE `uid`='$x' AND `logtype`='1' AND `date`>'$my_date' GROUP BY `type`");
						while($rt = DB::fetch($query)){
							$my_allmoney[$rt['type']] = $rt['allmoney'];
						}
						foreach($e6_propaganda['max_visit'] as $key => $value) {
							if ($value && ($my_allmoney[$key] >= $value)) {
								$visit_money = NULL;
								$money_list = E6::M()->money_list();
								$e6_propaganda['cheatlog'] && E6::M()->money(false, '9g', $x, array($_G['clientip'], $money_list[$key]));
								break;
							}
						}
					}
					if ($visit_money) {
						$visit_money_sum = array_sum($e6_propaganda['visit_money']);
						if ($visit_money_sum) {
							DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'$visit_money_sum',`ip`=`ip`+1 WHERE `uid`='$x'");
							E6::M()->money($e6_propaganda['visit_money'], 1, $x, $_G['clientip']);
						}
					}
					if ($e6_propaganda['cookie']) {
						$cookie_time = $e6_propaganda['cookie'] * 86400;
						dsetcookie('pro', $x, $cookie_time);
					} else {
						dsetcookie('pro', $x, 315360000);
					}
				}
			} else {
				if ($e6_propaganda['cheatlog']) {
					if($_G['uid']) {
						E6::M()->money(false, '9b', $x, $_G['username']);
					} else {
						$pro_username = E6::M()->get_username(getcookie('pro'));
						E6::M()->money(false, '9c', $x, array($_G['clientip'], $pro_username));
					}
				}
			}
		}
	} else {
		$x && $e6_propaganda['cheatlog'] && E6::M()->money(false, '9a', $x, $_G['clientip']);
	}
}
$GLOBALS['e6_propaganda_x'] = $e6_propaganda_x = 1;
?>