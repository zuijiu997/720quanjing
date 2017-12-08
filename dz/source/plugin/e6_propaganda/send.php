<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!$e6_propaganda['group'] or in_array($_G['groupid'], $e6_propaganda['group'])) {
	if ($e6_propaganda['active_num']) {
		$cookie_active = getcookie('pro_active');
		$cookie_active_over = $cookie_active + ($e6_propaganda['active_date'] * 3600);
		if ($cookie_active_over < $_G['timestamp']) {
			$active_field = 'uid,';
			$active_where = ' AND (';
			for ($n = 1; $n <= $e6_propaganda['active_num']; $n++) {
				$active_field .= "activation{$n},";
				$active_where .= " activation{$n}=0 OR";
			}
			$active_field = trim($active_field, ',');
			$active_where = trim($active_where, 'OR');
			$active_where .= ')';
			$query = DB::query("SELECT $active_field FROM ".DB::table('e6_pro_user')." WHERE `fuid1`='{$_G['uid']}' $active_where ORDER BY NULL");
			while($rt = DB::fetch($query)){
				$active_list[$rt['uid']] = $rt;
				$active_uid[] = $rt['uid'];
			}
			$active_uid && $active_uid_str = implode(',', $active_uid);
			if ($active_uid_str) {
				$query = DB::query("SELECT m.uid,m.groupid,m.username,c.oltime,c.posts FROM ".DB::table('common_member')." m LEFT JOIN ".DB::table('common_member_count')." c ON m.uid=c.uid WHERE m.uid IN ($active_uid_str) ORDER BY NULL");
				while($rt = DB::fetch($query)) {
					for ($n = 1; $n <= $e6_propaganda['active_num']; $n++) {
						$active_money = array_sum($e6_propaganda['active'.$n.'_money']);
						if ($active_money && !$active_list[$rt['uid']]['activation'.$n]) {
							$online = $posts = $groupid = $user_active = $user_active_array = NULL;
							$online = $e6_propaganda['active'.$n.'_condition_online'];
							!$online && $online = 0;
							$posts = $e6_propaganda['active'.$n.'_condition_posts'];
							!$posts && $posts = 0;
							$groupid = $e6_propaganda['active'.$n.'_condition_groupid'];
							!$groupid && $groupid = $rt['groupid'];
							$active = $active_list[$rt['uid']]['active'.$n];
							if (!$active && $rt['oltime'] >= $online && $rt['posts'] >= $posts && $groupid == $rt['groupid']) {
								E6::M()->money($e6_propaganda['active'.$n.'_money'], 4, $_G['uid'], array($rt['username'], $n));
								DB::query("UPDATE ".DB::table('e6_pro_user')." SET `activation{$n}`='1' WHERE `uid`='{$rt['uid']}'");
								$user_active = E6::M()->get_prouser_count($_G['uid'], 'active');
								$user_active && $user_active_array = unserialize($user_active);
								if($user_active_array[$n]) {
									$user_active_array[$n] = $user_active_array[$n] + 1;
								} else {
									$user_active_array[$n] = 1;
								}
								$user_active = serialize($user_active_array);
								DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'$active_money',`active`='$user_active' WHERE `uid`='{$_G['uid']}'");
							}
						}
					}
				}
			}
			dsetcookie('pro_active', $_G['timestamp'], 315360000);
		}
	}
	if($e6_propaganda['group_id'] && $e6_propaganda['dividendl_' . $_G['groupid']]) {
		$cookie_vip = getcookie('pro_vip');
		$cookie_vip_over = $cookie_vip + ($e6_propaganda['vip_date'] * 3600);
		if ($cookie_vip_over < $_G['timestamp']) {
			!$group_list && $group_list = E6::M()->group_list();
			!$money_list && $money_list = E6::M()->money_list();
			$vip_sql = E6::M()->statistics_sql($_G['uid'], $e6_propaganda['dividendl_' . $_G['groupid']]);
			$query = DB::query("SELECT m.username,m.groupid,p.* FROM ".DB::table('e6_pro_user')." p LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid WHERE p.vip=0 AND ($vip_sql)");
			while($rt = DB::fetch($query)) {
				if ($rt['groupid'] == $e6_propaganda['group_id']) {
					for ($n = 1; $n<=10; $n++) {
						$rt['Y'] = '';
						if ($rt['fuid'.$n] && $e6_propaganda['multi_vip_'.$n]) {
							if ($rt['fuid'.$n] != $_G['uid']) {
								$rt['fuid_groupid'] = E6::M()->get_user($rt['fuid'.$n], 'groupid');
							} else {
								$rt['fuid_groupid'] = $_G['groupid'];
							}
							if ($e6_propaganda['dividendl_'.$rt['fuid_groupid']] >= $n) {
								$rt['Y'] = 1;
							}
						}
						if ($rt['Y']) {
							E6::M()->money(array($e6_propaganda['multi_viptype_'.$n]=>$e6_propaganda['multi_vip_'.$n]), 5, $rt['fuid'.$n], array($rt['username'], $n, $group_list[$rt['groupid']]));
							if ($n==1) {
								$user_upvip = E6::M()->get_prouser_count($rt['fuid'.$n], 'upvip');
								$user_upvip && $user_upvip_array = unserialize($user_upvip);
								if($user_upvip_array[$e6_propaganda['group_id']]) {
									$user_upvip_array[$e6_propaganda['group_id']] = $user_upvip_array[$e6_propaganda['group_id']] + 1;
								} else {
									$user_upvip_array[$e6_propaganda['group_id']] = 1;
								}
								$user_upvip = serialize($user_upvip_array);
								DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'".$e6_propaganda['multi_vip_'.$n]."',`upvip`='$user_upvip' WHERE  `uid`='".$rt['fuid'.$n]."'");
							} else {
								DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'".$e6_propaganda['multi_vip_'.$n]."' WHERE  `uid`='".$rt['fuid'.$n]."'");
							}
							$e6_propaganda['paymsg'] && E6::M()->msg($rt['fuid'.$n], e6_c('send_1'), e6_c('send_2') . $n . e6_c('send_3') . $rt['username'] . e6_c('send_4') . $group_list[$rt['groupid']] . e6_c('send_5') . $n . e6_c('send_6') . $e6_propaganda['multi_vip_' . $n] . $money_list[$e6_propaganda['multi_viptype_' . $n]]);
						}
					}
					DB::query("UPDATE " . DB::table('e6_pro_user') . " SET `vip`=1 WHERE `uid`='{$rt['uid']}'");
				}
			}
			dsetcookie('pro_vip', $_G['timestamp'], 315360000);
		}
	}
	if($e6_propaganda['paytype'] && $e6_propaganda['dividendl_' . $_G['groupid']]) {
		$cookie_pay = getcookie('pro_pay');
		$cookie_pay_over = $cookie_pay + ($e6_propaganda['pay_date'] * 3600);
		if ($cookie_pay_over < $_G['timestamp']) {
			!$money_list && $money_list = E6::M()->money_list();
			$date_A = DB::result_first("SELECT `date` FROM ".DB::table('e6_pro_clientorder')." WHERE `type`=0 ORDER BY `date` DESC LIMIT 1");
			$query = DB::query("SELECT o.orderid,o.uid,o.price,o.submitdate FROM ".DB::table('forum_order')." o LEFT JOIN ".DB::table('e6_pro_user')." p ON o.uid=p.uid WHERE o.submitdate>'{$date_A}' AND p.fuid1>0");
			while($rt = DB::fetch($query)) {
				DB::query("INSERT INTO ".DB::table('e6_pro_clientorder').
				" SET `uid`='{$rt['uid']}',`orderid`='{$rt['orderid']}',`date`='{$rt['submitdate']}',`type`='0',`price`='{$rt['price']}'");
			}
			if ($e6_propaganda['paycard'] && $GLOBALS['_G']['setting']['version'] != 'X2') {
				$date_B = DB::result_first("SELECT `date` FROM ".DB::table('e6_pro_clientorder')." WHERE `type`=1 ORDER BY `date` DESC LIMIT 1");
				$query = DB::query("SELECT o.id,o.uid,o.price,o.useddateline FROM ".DB::table('common_card')." o LEFT JOIN ".DB::table('e6_pro_user')." p ON o.uid=p.uid WHERE o.useddateline>'{$date_B}' AND o.status=2 AND p.fuid1>0");
				while($rt = DB::fetch($query)) {
					DB::query("INSERT INTO ".DB::table('e6_pro_clientorder').
					" SET `uid`='{$rt['uid']}',`orderid`='{$rt['id']}',`date`='{$rt['useddateline']}',`type`='1',`price`='{$rt['price']}'");
				}
			}
			$query = DB::query("SELECT p.* FROM ".DB::table('e6_pro_clientorder')." p LEFT JOIN ".DB::table('forum_order')." o ON p.orderid=o.orderid WHERE p.pay='0' AND (p.type='1' OR (p.type='0' AND o.status>'1'))");
			while($rt = DB::fetch($query)){
				$rt['prouser'] = E6::M()->get_prouser($rt['uid']);
				for($n =1; $n <= 10; $n++) {
					if ($rt['prouser']['fuid'.$n]) {
						$pay_money = $pay_type = NULL;
						if ($e6_propaganda['paytype'] == 1) {
							$pay_money = $e6_propaganda['multi_pay_'.$n];
							$pay_type = $e6_propaganda['multi_paytype_'.$n];
						} else {
							$pay_money = $e6_propaganda['pay_money2'] * $rt['price'] * ($e6_propaganda['multi_pay_'.$n]/100);
							$pay_type = $e6_propaganda['pay_type2'];
						}
						if ($pay_money && $pay_type) {
							$rt['fuid_groupid'] = E6::M()->get_user($rt['prouser']['fuid'.$n], 'groupid');
							if ($e6_propaganda['dividendl_'.$rt['fuid_groupid']] >= $n) {
								$rt['username'] = E6::M()->get_username($rt['uid']);
								if ($rt['type'] == 0) {
									E6::M()->money(array($pay_type => $pay_money), '6a', $rt['prouser']['fuid'.$n], array($rt['username'], $n, $rt['price']));
								} else {
									E6::M()->money(array($pay_type => $pay_money), '6b', $rt['prouser']['fuid'.$n], array($rt['username'], $n, $rt['price']));
								}
								if ($n == 1) {
									DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'{$pay_money}',`paymoney`=`paymoney`+{$rt['price']} WHERE  `uid`='".$rt['prouser']['fuid'.$n]."'");
								} else {
									DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'{$pay_money}' WHERE  `uid`='".$rt['prouser']['fuid'.$n]."'");
								}
								$e6_propaganda['paymsg'] && E6::M()->msg($rt['prouser']['fuid'.$n], e6_c('send_7'), e6_c('send_8') . $n . e6_c('send_9') . $rt['username'] . e6_c('send_10') . $rt['price'] . e6_c('send_11') . $n . e6_c('send_12') . $pay_money . $money_list[$pay_type]);
							}
						}
					} else {
						break;
					}
				}
			}
			DB::query("UPDATE ".DB::table('e6_pro_clientorder')." p LEFT JOIN ".DB::table('forum_order')." o ON p.orderid=o.orderid SET p.pay='1' WHERE p.pay='0' AND (p.type='1' OR (p.type='0' AND o.status>'1'))");
			dsetcookie('pro_pay', $_G['timestamp'], 315360000);
		}
	}
}
?>