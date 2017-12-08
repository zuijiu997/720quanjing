<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require DISCUZ_ROOT.'source/plugin/e6_propaganda/config.php';
$navtitle = e6_c('p_1');
if(empty($_G['uid'])) Showmessage(e6_c('p_2'), 'member.php?mod=logging&action=login');
!$e6_propaganda['open'] && Showmessage($e6_propaganda['close']);
E6::M()->getgpc(array('nav', 'step'));
!$nav && $nav = 'index';
$nav_list = E6::M()->nav();
if ($e6_propaganda['nav_arr']) {
	foreach($e6_propaganda['nav_arr'] as $value) {
		$e6_nav[$value] = $nav_list[$value];
	}
} else {
	$e6_nav = $nav_list;
}
if(!$e6_propaganda['withdrawopen']) unset($e6_nav['withdraw']);
$e6_nav_css[$nav] = 'a';
$e6_nav_name = $e6_nav[$nav];
$money_list = E6::M()->money_list();
$group_list = E6::M()->group_list();
$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
if($page<1) $page=1;
$perpage = 10;
$start = ($page-1)*$perpage;
$theurl = 'plugin.php?id=e6_propaganda&nav='.$nav;
$multi = '';
if ($nav == 'index') {
	$e6_user = E6::M()->get_prouser($_G['uid']);
	if(!$e6_propaganda['group'] or in_array($_G['groupid'], $e6_propaganda['group'])) {
		if ($e6_user['fuid1']) {
			$prompt = e6_c('p_3') . '<b>' . E6::M()->get_username($e6_user['fuid1']) . '</b>';
		}
	} else {
		$prompt = e6_c('p_4');
	}
	$e6_user_count = E6::M()->get_prouser_count($_G['uid']);
	if($e6_propaganda['urltype'] == 1) {
		$spread_url = $e6_propaganda['url_url'];
		if(strpos($spread_url, '?') === false) {
			$spread_url .= "?x={$_G['uid']}";
		} else {
			$spread_url .= "&x={$_G['uid']}";
		}
	} else {
		$spread_url = E6::M()->rand_digest();
	}
	if ($e6_propaganda['interval'] or array_sum($e6_propaganda['max_visit']) or array_sum($e6_propaganda['max_register'])) {
		$explain4 .= '(<font color="#DF0174">' . e6_c('p_5');
		$e6_propaganda['interval'] && $explain4 .= e6_c('p_6') . $e6_propaganda['interval'] . e6_c('p_7');
		$max_visit = E6::M()->reward_text('max_visit');
		$max_visit && $explain4 .= e6_c('p_8') . $max_visit . ', ';
		$max_register = E6::M()->reward_text('max_register');
		$max_register && $explain4 .= e6_c('p_9') . $max_register;
		$explain4 .= '</font>)';
	}
	$explain_all .= E6::M()->reward_indextext('visit_money', e6_c('p_10'), e6_c('p_11'));
	if ($e6_propaganda['registertype'] == 1) {
		$explain_all .= E6::M()->reward_indextext('register_money', e6_c('p_12'), e6_c('p_13'));
	} elseif ($e6_propaganda['registertype'] == 2) {
		$register_money = e6_c('p_14');
		for($n=1; $n<=$e6_propaganda['dividendl_'.$_G['groupid']]; $n++) {
			if ($e6_propaganda['multi_reg_'.$n]) {
				$register_money .= $n . e6_c('p_15') . $e6_propaganda['multi_reg_'.$n] . $money_list[$e6_propaganda['multi_regtype_'.$n]] . e6_c('p_16');
			}
		}
		$register_money = preg_replace('/' . e6_c('p_17') . '$/i','',$register_money);
		$explain_all .= E6::M()->reward_indextext(false, e6_c('p_18'), e6_c('p_19'), $register_money);
	}
	if($e6_propaganda['area']) $explain_all .= E6::M()->reward_indextext('region_money', e6_c('p_20'), e6_c('p_21') . $e6_propaganda['area']);
	if($e6_propaganda['group_id']) {
		$vip_money = e6_c('p_22');
		for($n=1; $n<=$e6_propaganda['dividendl_'.$_G['groupid']]; $n++) {
			if ($e6_propaganda['multi_vip_'.$n]) {
				$vip_money .= $n . e6_c('p_15') . $e6_propaganda['multi_vip_'.$n] . $money_list[$e6_propaganda['multi_viptype_'.$n]] . e6_c('p_16');
			}
		}
		$vip_money = preg_replace('/' . e6_c('p_17') . '$/i','',$vip_money);
		$explain_all .= E6::M()->reward_indextext(false, e6_c('p_23'), e6_c('p_24') . $group_list[$e6_propaganda['group_id']], $vip_money);
	}
	if($e6_propaganda['paytype']) {
		$pay_money = e6_c('p_25');
		if($e6_propaganda['paytype'] == 2){
			$pay_title = e6_c('p_26');
		} else {
			$pay_title = e6_c('p_27');
		}
		for($n=1; $n<=$e6_propaganda['dividendl_'.$_G['groupid']]; $n++) {
			if ($e6_propaganda['multi_pay_'.$n]) {
				if($e6_propaganda['paytype'] == 2){
					$pay_money .= $n . e6_c('p_15') . ($e6_propaganda['pay_money2'] * $e6_propaganda['multi_pay_'.$n] / 100) . $money_list[$e6_propaganda['pay_type2']] . e6_c('p_16');
				} else {
					$pay_money .= $n . e6_c('p_15') . $pay_money2 . $e6_propaganda['multi_pay_'.$n] .  $money_list[$e6_propaganda['multi_paytype_'.$n]] . e6_c('p_16');
				}
			}
		}
		$pay_money = preg_replace('/' . e6_c('p_17') . '$/i','',$pay_money);
		$explain_all .= E6::M()->reward_indextext(false, e6_c('p_28'), e6_c('p_29') . $pay_title, $pay_money);
	}
	for($n=1; $n<=$e6_propaganda['active_num']; $n++) {
		if ($e6_propaganda['active' . $n . '_condition_online']) {
			$condition[$n] .= e6_c('p_30') . $e6_propaganda['active' . $n . '_condition_online'] . e6_c('p_31');
		}
		if ($e6_propaganda['active' . $n . '_condition_posts']) {
			$condition[$n] .= e6_c('p_32') . $e6_propaganda['active' . $n . '_condition_posts'] . e6_c('p_33');
		}
		if ($e6_propaganda['active' . $n . '_condition_groupid']) {
			$condition[$n] .= e6_c('p_34') . $group_list[$e6_propaganda['active' . $n . '_condition_groupid']];
		}
		$condition[$n] = preg_replace('/' . e6_c('p_17') . '$/i','',$condition[$n]);
		$condition[$n] && $explain_all .= E6::M()->reward_indextext('active' . $n . '_money', $n . e6_c('p_35'), e6_c('p_36') . $condition[$n]);
	}
} elseif ($nav == 'task') {
	$task = $_GET['task'] ? $_GET['task'] : 'all';
	$task_url = 'plugin.php?id=e6_propaganda&nav=task';
	${'task_'.$task} = 'font-weight:bold;';
	$prompt = "<a href=\"{$task_url}&task=all\" style=\"color:#FF6600;{$task_all}\">" . e6_c('p_37') . "</a> | <a href=\"{$task_url}&task=yes\" style=\"color:#FF6600;{$task_yes}\">" . e6_c('p_38') . "</a> | <a href=\"{$task_url}&task=no\" style=\"color:#FF6600;{$task_no}\">" . e6_c('p_39') . "</a>";
	if ($_GET['type'] == 'apply') {
		$taskid = intval($_GET['taskid']);
		if ($taskid) {
			$task = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task')." WHERE `id`='$taskid'");
			if($task['endtime'] && $task['endtime']<$_G['timestamp']) {
				Showmessage(e6_c('p_40'), $task_url);
			}
			$task_my = E6::M()->task_my($task['id']);
			if ($task_my['ok']) {
				Showmessage(e6_c('p_41'), $task_url);
			}
			if($task_my){
				Showmessage(e6_c('p_42'), $task_url);
			}
			if (E6::M()->task_group($_G['groupid'], $task['grouplimit'])) {
				$value = E6::M()->task_value($task['claim'], $task['claim1']);
				DB::query("INSERT INTO ".DB::table('e6_pro_task_list')." SET `uid`='{$_G['uid']}',`taskid`='$taskid',`value`='$value'");
				DB::query("UPDATE ".DB::table('e6_pro_task')." SET `participate`=`participate`+1 WHERE `id`='$taskid'");
				Showmessage(e6_c('p_43'), $task_url . '&taskid=' . $taskid);
			} else {
				Showmessage(e6_c('p_44'), $task_url);
			}
		} else {
			Showmessage(e6_c('p_45'));
		}
	} elseif ($_GET['type'] == 'cancel') {
		$taskid = intval($_GET['taskid']);
		DB::query("DELETE FROM ".DB::table('e6_pro_task_list')." WHERE `taskid` = '{$taskid}' AND `uid`='{$_G['uid']}'");
		DB::query("UPDATE ".DB::table('e6_pro_task')." SET `participate`=`participate`-1 WHERE `id`='$taskid' AND `participate`<0");
		Showmessage(e6_c('p_46'), $task_url);
	} elseif ($_GET['type'] == 'reward') {
		$taskid = intval($_GET['taskid']);
		$task_my = E6::M()->task_my($taskid);
		if ($task_my['ok']) {
			Showmessage(e6_c('p_47'), $task_url);
		}
		E6::M()->task_send_reward($taskid);
		DB::query("UPDATE ".DB::table('e6_pro_task')." SET `complete`=`complete`+1 WHERE `id`='$taskid'");
		Showmessage(e6_c('p_48'), $task_url);
	}
	if ($_GET['taskid']) {
		$taskid = intval($_GET['taskid']);
		$task = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task')." WHERE `id`='$taskid'");
		!$task['icon'] && $task['icon'] = 'task.gif';
		$prompt = $task['name'];
		$task_date = e6_c('p_49') . ($task['starttime'] ? dgmdate($task['starttime'], 'Y-m-d H:i:s') : e6_c('p_50')) . ' &nbsp;----&nbsp; ' . e6_c('p_51') . ($task['overtime'] ? dgmdate($task['overtime'], 'Y-m-d H:i:s') : e6_c('p_50'));
		$claimtext = E6::M()->task_claim_text($task['claim'], $task['claim1'], $task['claim2']);
		$rewardtext = E6::M()->task_reward_text($task['reward'], $task['reward1'], $task['reward2']);
		if ($task['grouplimit']) {
			$group_list = E6::M()->group_list();
			$grouparr = unserialize($task['grouplimit']);
			foreach($grouparr as $value) {
				$grouplimit .= $group_list[$value] . ', ';
			}
		} else {
			$grouplimit = e6_c('p_50');
		}
		$my_task = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task_list')." WHERE `uid`='{$_G['uid']}' AND `taskid`='$taskid'");
		if (E6::M()->task_group($_G['groupid'], $task['grouplimit'])) {
			if ($my_task['taskid']) {
				if($my_task['ok']) {
					$taskimg = E6::M()->task_img($task['id'], 'ok');
					$task_ok = e6_c('p_52');
				} else {
					if (E6::M()->task_ok($my_task, $task['claim'], $task['claim1'], $task['claim2'])) {
						$taskimg = E6::M()->task_img($task['id'], 'reward');
						$task_ok = e6_c('p_52');
					} else {
						$taskimg = E6::M()->task_img($task['id'], 'cancel');
						$user_value = E6::M()->task_value($task['claim'], $task['claim1']);
						$value = $user_value - $my_task['value'];
						$task_ok_arr = array(
							1	=>	e6_c('p_53') . $value,
							2 	=>	e6_c('p_54') . $value . e6_c('p_59'),
							3	=>	e6_c('p_55') . $value . e6_c('p_59'),
							4	=>	e6_c('p_56') . $value . e6_c('p_60'),
							5	=>	e6_c('p_57') . $value . e6_c('p_59'),
							6	=>	e6_c('p_58') . $value . e6_c('p_59')
						);
						$task_ok = $task_ok_arr[$task['claim']];
					}
				}
			} else {
				$taskimg =E6::M()->task_img($task['id'], 'apply');
			}
		} else {
			$taskimg = E6::M()->task_img($task['id'], 'disallow');
		}
		@include template("e6_propaganda:index_{$nav}");
		exit;
	}
	$query = DB::query("SELECT * FROM ".DB::table('e6_pro_task')." WHERE `endtime`>0 AND `endtime`<'{$_G['timestamp']}' ORDER BY NULL");
	while($rt = DB::fetch($query)) {
		$overlist[] = $rt['id'];
	}
	$overlist && $overstr = implode(',', $overlist);
	$overstr && DB::query("DELETE FROM ".DB::table('e6_pro_task_list')." WHERE `taskid` IN ($overstr)");
	$userlist = array();
	$query = DB::query("SELECT * FROM ".DB::table('e6_pro_task_list')." WHERE `uid`='{$_G['uid']}'");
	while($rt = DB::fetch($query)) {
		$userlist[$rt['taskid']] = $rt;
	}
	$userlist && $taskid_list = array_keys($userlist);
	$taskid_list && $taskid_str = implode(',',$taskid_list);
	!$taskid_str && $taskid_str = 0;
	$where_arr = array(
		'all'	=> '',
		'yes'	=> " AND id IN ({$taskid_str}) ",
		'no'	=> " AND id NOT IN ({$taskid_str}) "
	);
	$where = $where_arr[$_GET['task']];
	$count = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_task')." WHERE (`endtime`='0' OR `endtime`>'{$_G['timestamp']}') $where");
	if ($count) {
		$n = ($page-1)*$perpage+1;
		$query = DB::query("SELECT * FROM ".DB::table('e6_pro_task')." WHERE (`endtime`='0' OR `endtime`>'{$_G['timestamp']}') $where ORDER BY `id` DESC LIMIT $start,$perpage");
		while ($rt = DB::fetch($query)) {
			$rt['n'] = $n;
			!$rt['icon'] && $rt['icon'] = 'task.gif';
			$rt['claimtext'] = E6::M()->task_claim_text($rt['claim'], $rt['claim1'], $rt['claim2']);
			$rt['rewardtext'] = E6::M()->task_reward_text($rt['reward'], $rt['reward1'], $rt['reward2']);
			$rt['Y'] = E6::M()->task_group($_G['groupid'], $rt['grouplimit']);
			if ($rt['Y']) {
				if ($userlist && array_key_exists($rt['id'], $userlist)) {
					if($userlist[$rt['id']]['ok']) {
						$rt['taskimg'] = E6::M()->task_img($rt['id'], 'ok');
					} else {
						if (E6::M()->task_ok($userlist[$rt['id']], $rt['claim'], $rt['claim1'], $rt['claim2'])) {
							$rt['taskimg'] = E6::M()->task_img($rt['id'], 'reward');
						} else {
							$rt['taskimg'] = E6::M()->task_img($rt['id'], 'cancel');
						}
					}
				} else {
					$rt['taskimg'] =E6::M()->task_img($rt['id'], 'apply');
				}
			} else {
				$rt['taskimg'] = E6::M()->task_img($rt['id'], 'disallow');
			}
			$rt['date'] = e6_c('p_49') . ($rt['starttime'] ? dgmdate($rt['starttime'], 'Y-m-d H:i:s') : e6_c('p_50')) . ' &nbsp;----&nbsp; ' . e6_c('p_51') . ($rt['overtime'] ? dgmdate($rt['overtime'], 'Y-m-d H:i:s') : e6_c('p_50'));
			$list[] = $rt;
			$n++;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
} elseif ($nav == 'son') {
	$grouplist = E6::M()->group_list('all');
	$status = array(e6_c('p_61'), e6_c('p_62'));
	if ($e6_propaganda['area']) {
		$table_title .= '<td>' . e6_c('p_63') . '</td>';
	}
	for($n = 1; $n <= $e6_propaganda['active_num']; $n++) {
		$value_a = 'active' . $n . '_money';
		$value_c = $n . e6_c('p_64');
		if ($e6_propaganda[$value_a] && array_sum($e6_propaganda[$value_a]) > '0') {
			$table_title .= '<td>' . $value_c . '</td>';
			$active_arr[$n] = $n;
		}
	}
	$count = DB::result_first("SELECT count(*) AS sum FROM " . DB::table('e6_pro_user') . " WHERE fuid1='$_G[uid]'");
	if($count) {
		$query = DB::query("SELECT p.uid,p.region,p.activation1,p.activation2,p.activation3,p.activation4,p.activation5,p.activation6,p.activation7,p.activation8,p.activation9,p.activation10,m.username,m.regdate,m.groupid,d.oltime,d.posts FROM ".DB::table('e6_pro_user')." p LEFT JOIN " . DB::table('common_member') . " m ON p.uid=m.uid LEFT JOIN ".DB::table('common_member_count')." d ON p.uid=d.uid WHERE p.fuid1='{$_G['uid']}' ORDER BY p.id DESC LIMIT $start,$perpage");
		$n = ($page-1) * $perpage + 1;
		while ($rt = DB::fetch($query)) {
			$rt['n'] = $n;
			$rt['groupid'] = $grouplist[$rt['groupid']];
			$rt['regdate'] = dgmdate($rt['regdate'], 'Y-m-d H:i:s');
			$rt['register'] = $status[$rt['register']];
			$rt['region'] = $status[$rt['region']];
			$rt['activation1'] = $status[$rt['activation1']];
			$rt['activation2'] = $status[$rt['activation2']];
			$rt['activation3'] = $status[$rt['activation3']];
			$rt['activation4'] = $status[$rt['activation4']];
			$rt['activation5'] = $status[$rt['activation5']];
			$rt['activation6'] = $status[$rt['activation6']];
			$rt['activation7'] = $status[$rt['activation7']];
			$rt['activation8'] = $status[$rt['activation8']];
			$rt['activation9'] = $status[$rt['activation9']];
			$rt['activation10'] = $status[$rt['activation10']];
			$n++;
			$list[]=$rt;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
} elseif ($nav == 'multi') {
	$multi_url = 'plugin.php?id=e6_propaganda&nav=multi';
	$mymulti = $e6_propaganda['dividendl_'.$_G['groupid']];
	if ($_GET['uid']) {
		$uid = intval($_GET['uid']);
		if ($uid) {
			$prouser = E6::M()->get_prouser($uid);
			for($n == 1; $n <= ($mymulti-1); $n++) {
				if ($prouser['fuid'.$n] == $_G['uid']) {
					$ok = $n;
					break;
				}
			}
			!$ok && exit('<font color="red">' . e6_c('p_65') . $mymulti . e6_c('p_66') . '</font>');
			$query = DB::query("SELECT m.uid,m.username,c.register FROM ".DB::table('e6_pro_user')." p LEFT JOIN ".DB::table('e6_pro_user_count')." c ON p.uid=c.uid LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid WHERE p.fuid1='{$uid}' AND p.fuid" . ($ok+1) . "='{$_G['uid']}'");
			while($rt = DB::fetch($query)) {
				$li .= "<li id=\"{$rt['uid']}\"><span class=\"text\">{$rt['username']}</span> ";
				if($rt['register'] > 0) {
					$li .= "<ul class=\"ajax\"><li id=\"{$rt['uid']}\">{url:$multi_url&uid=$rt[uid]}</li></ul>";
				}
				$li .= "</li>";
			}
			print $li;
			exit;
		} else {
			exit(e6_c('p_67'));
		}
	}
	if (empty($_GET['status'])) {
		if ($mymulti) {
			$alluser = E6::M()->statistics($_G['uid'], $mymulti);
			$allnum = e6_c('p_68') . $alluser . e6_c('p_69');
			$prompt = '<a href="' . $multi_url . '&status=1" style="color:#C0504D;font-weight:bold;font-size:15px;">' . e6_c('p_70') . '</a>';
			$query = DB::query("SELECT m.uid,m.username,c.register FROM ".DB::table('e6_pro_user')." p LEFT JOIN ".DB::table('e6_pro_user_count')." c ON p.uid=c.uid LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid WHERE p.fuid1='{$_G['uid']}'");
			while($rt = DB::fetch($query)) {
				$list[] = $rt;
			}
		}
	} else {
		$prompt = '<a href="' . $multi_url . '" style="color:#C0504D;font-weight:bold;font-size:15px;">' . e6_c('p_71') . '</a>';
		$num = intval($_GET['num']);
		if ($num) {
			$num > $mymulti && Showmessage(e6_c('p_65') . $mymulti . e6_c('p_66'));
			$alluser = E6::M()->statistics($_G['uid'], $num, TRUE);
			${'num' . $num} = '<span style="color:#FF6600"> (' . $alluser . e6_c('p_59') . ') </span>';
			$alluser_sql = " `fuid{$num}`='{$_G['uid']}' ";
		} else {
			$alluser = E6::M()->statistics($_G['uid'], $mymulti);
			$all_num = '<span style="color:#FF6600"> (' . $alluser . e6_c('p_59') . ') </span>';
			$alluser_sql = E6::M()->statistics_sql($_G['uid'], $mymulti);
		}
		$pro_header = "<a href=\"{$multi_url}&status=1\">" . e6_c('p_72') . "</a>{$all_num}&nbsp;&nbsp;&nbsp;&nbsp;";
		for ($n = 1; $n <= $mymulti; $n++) {
			$pro_header .= "<a href=\"{$multi_url}&status=1&num={$n}\">" . $n . e6_c('p_66') . "</a>" . ${'num'.$n} . "&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$count = DB::result_first("SELECT count(*) AS sum FROM ".DB::table('e6_pro_user')." WHERE $alluser_sql");
		if ($count) {
			$grouplist = E6::M()->group_list('all');
			$n = ($page-1) * $perpage + 1;
			$query = DB::query("SELECT p.uid,m.username,m.regdate,m.groupid,c.oltime,c.posts FROM ".DB::table('e6_pro_user')." p ".
				"LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ".
				"LEFT JOIN ".DB::table('common_member_count')." c ON p.uid=c.uid WHERE {$alluser_sql} ORDER BY p.id DESC LIMIT $start,$perpage");
			while($rt = DB::fetch($query)){
				$rt['n'] = $n;
				$rt['grouptitle'] = $grouplist[$rt['groupid']];
				$rt['regdate'] = dgmdate($rt['regdate'], 'Y-m-d H:i:s');
				$list[]=$rt;
				$n++;
			}
			$theurl .= '&status=1';
			$num && $theurl .= '&num=' . $num;
			$multi = multi($count, $perpage, $page, $theurl);
		}
	}
} elseif ($nav == 'withdraw') {
	$prompt = $e6_propaganda['withdrawann'];
	!$e6_propaganda['withdrawopen'] && Showmessage(e6_c('p_73'));
	if (!$e6_propaganda['withdrawgroup'] or in_array($_G['groupid'], $e6_propaganda['withdrawgroup'])) {
		$usermoney = E6::M()->get_usermoney($_G['uid'], $e6_propaganda['withdraw_type']);
		$withdraw_money = e6_c('p_74') . "<span style=\"color:#FF6600;\">{$usermoney} {$money_list[$e6_propaganda['withdraw_type']]}</span>";
	} else {
		$disabled = 'disabled';
		$withdraw_money	= '<span style="color:blue;">' . e6_c('p_75') . '</span>';
	}
	if ($e6_propaganda['withdraw_money']) {
		$small_money = "<li>" . e6_c('p_76') . "<span style=\"color:#FF6600;\">{$e6_propaganda['withdraw_money']} {$money_list[$e6_propaganda['withdraw_type']]}</span></li>";
	}
	if ($e6_propaganda['feetype']) {
		if ($e6_propaganda['feetype'] == 1) {
			$fee_content = e6_c('p_77') . $e6_propaganda['fee_money']  . $money_list[$e6_propaganda['fee_type']];
		} else {
			$fee_content = e6_c('p_78') . $e6_propaganda['pay_proportion'] . e6_c('p_79') . '</font><font color="">' . e6_c('p_80');
		}
	}
	if (is_array($e6_propaganda['withdraw_profile'])) {
		foreach ($e6_propaganda['withdraw_profile'] as $value) {
			$user_field .= "'{$value}',";
			$field_user .= "`{$value}`,";
		}
		if ($user_field) {
			$user_field = trim($user_field, ',');
			$field_user = trim($field_user, ',');
			$query = DB::query("SELECT `fieldid`,`title` FROM ".DB::table('common_member_profile_setting')." WHERE `available`='1' AND `fieldid` IN ($user_field)");
			while ($rt = DB::fetch($query)) {
				$profile_list[$rt['fieldid']] = $rt['title'];
			}
			$user_profile = DB::fetch_first("SELECT $field_user FROM ".DB::table('common_member_profile')." WHERE `uid`='{$_G['uid']}'");
			$profile_content .= '<li>' . e6_c('p_81') . '&nbsp;&nbsp;';
			foreach ($profile_list as $key => $value) {
				if ($user_profile[$key]) {
					$profile_content .= $value . ': ' .$user_profile[$key] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$profile_content .= $value . ': <a href="home.php?mod=spacecp" style="color:blue;">' . e6_c('p_82') . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$no_profile = $value;
				}
			}
			$profile_content .= '</li>';
		}
	}
	if ($step == 2) {
		$disabled && Showmessage(e6_c('p_83'));
		$money = intval($_POST['money']);
		$money > $usermoney && Showmessage(e6_c('p_84'));
		$money < $e6_propaganda['withdraw_money'] && Showmessage(e6_c('p_85') . $e6_propaganda['withdraw_money'] . $money_list[$e6_propaganda['withdraw_type']] . ' !');
		$no_profile && Showmessage(e6_c('p_86') . $no_profile . ' (<a href="home.php?mod=spacecp">' . e6_c('p_87') . '</a>)');
 		if ($e6_propaganda['feetype']) {
			if ($e6_propaganda['feetype'] == 2) {
				$feemoney = $money * ($e6_propaganda['pay_proportion']/100);
				$feemoney = ceil($feemoney);
				if (($feemoney + $money) > $usermoney) Showmessage(e6_c('p_88') . ($feemoney+$money). $money_list[$e6_propaganda['withdraw_type']] . e6_c('p_89'));
				$feetype = $e6_propaganda['withdraw_type'];
			} else {
				$feemoney = $e6_propaganda['fee_money'];
				if ($e6_propaganda['fee_type'] == $e6_propaganda['withdraw_type']) {
					if (($feemoney + $money) > $usermoney) Showmessage(e6_c('p_88') . ($feemoney+$money). $money_list[$e6_propaganda['withdraw_type']] . e6_c('p_89'));
				} else {
					$feeusermoney = E6::M()->get_usermoney($_G['uid'], $e6_propaganda['fee_type']);
					if($feemoney > $feeusermoney) Showmessage(e6_c('p_90') . $feemoney . $money_list[$e6_propaganda['fee_type']]);
				}
				$feetype = $e6_propaganda['fee_type'];
			}
			E6::M()->money(array($feetype => -$feemoney), '7b');
		}
		E6::M()->money(array($e6_propaganda['withdraw_type'] => -$money), '7a');
		DB::query("INSERT INTO ".DB::table('e6_pro_finance')." SET `uid`='{$_G['uid']}',`username`='{$_G['username']}',`money`='{$money}',".
			"`type`='{$e6_propaganda['withdraw_type']}',`feemoney`='{$feemoney}',`feetype`='{$feetype}',`date`='{$_G['timestamp']}'");
		Showmessage(e6_c('p_46'), 'plugin.php?id=e6_propaganda&nav=withdraw');
	} else {
		$ok_list = array(e6_c('p_91'), e6_c('p_92'), e6_c('p_93'));
		$count = DB::result_first("SELECT count(*) AS sum FROM ".DB::table('e6_pro_finance')." WHERE uid='{$_G['uid']}'");
		if($count) {
			$query = DB::query("SELECT * FROM ".DB::table('e6_pro_finance')." WHERE `uid`='{$_G['uid']}' ORDER BY `id` DESC LIMIT $start,$perpage");
			$n = ($page-1) * $perpage + 1;
			while($rt = DB::fetch($query)){
				$rt['n'] = $n;
				$rt['date'] = dgmdate($rt['date'],'Y-m-d H:i:s');
				if($rt['okdate']) {
					$rt['okdate'] = dgmdate($rt['okdate'],'Y-m-d H:i:s');
				} else {
					$rt['okdate'] =	e6_c('p_91');
				}
				$rt['ok'] = $ok_list[$rt['ok']];
				$rt['money'] && $rt['money'] .= $money_list[$rt['type']];
				$rt['feemoney'] = $rt['feemoney'] ? $rt['feemoney'] . $money_list[$rt['feetype']] : e6_c('p_94');
				$n++;
				$list[]=$rt;
			}
			$multi = multi($count, $perpage, $page, $theurl);
		}
	}
} elseif ($nav == 'log') {
 	$count = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_credit')." WHERE uid='$_G[uid]'");
	if ($count) {
		$query = DB::query("SELECT * FROM ".DB::table('e6_pro_credit')." WHERE `uid`='$_G[uid]' ORDER BY `date` DESC LIMIT $start,$perpage");
		while($rt = DB::fetch($query)) {
			$rt['type'] = $money_list[$rt['type']];
			$rt['date'] = dgmdate($rt['date'], 'Y-m-d H:i:s');
			$list[] = $rt;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
} elseif ($nav == 'top') {
	$n = 1;
	$query = DB::query("SELECT m.username,u.username as fuid_username,p.uid,p.fuid1 FROM " . DB::table('e6_pro_user') . " p ".
		" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid LEFT JOIN " . DB::table('common_member') . " u ON p.fuid1=u.uid ORDER BY p.id DESC LIMIT 10");
	while($rt = DB::fetch($query)){
		$rt['n'] = $n; $n++;
		!$rt['fuid_username'] && $rt['fuid_username'] = e6_c('p_94');
		$newuser[] = $rt;
	}
	$n = 1;
	$query = DB::query("SELECT m.username,p.uid,p.money FROM " . DB::table('e6_pro_user_count') . " p ".
		" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ORDER BY p.money DESC LIMIT 10");
	while($rt = DB::fetch($query)){
		$rt['n'] = $n; $n++;
		$moneylist[] = $rt;
	}
	$n = 1;
	$query = DB::query("SELECT m.username,p.uid,p.register FROM " . DB::table('e6_pro_user_count') . " p ".
		" LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid ORDER BY p.register DESC LIMIT 10");
	while($rt = DB::fetch($query)){
		$rt['n'] = $n; $n++;
		$registerlist[] = $rt;
	}
} else {
	Showmessage(e6_c('p_67'));
}
require_once DISCUZ_ROOT . 'source/plugin/e6_propaganda/send.php';
@include template("e6_propaganda:index_{$nav}");
?>