<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
$money_list = E6::M()->money_list();
if ($_POST['step'] == 2) {
	if (is_array($_POST['pass'])) {
		foreach ($_POST['pass'] as $k=>$v) {
			$pass .= ",'".intval($v)."'";
		}
		$pass = trim($pass,',');
		$query = DB::query("SELECT `uid`,`date`,`money`,`type` FROM ".DB::table('e6_pro_finance')." WHERE `id` IN ($pass)");
		while($rt = DB::fetch($query)) {
			$message_content = $e6_c['a_w_17'] . dgmdate($rt['date'],'Y-m-d H:i:s') . $e6_c['a_w_18'] . '(<font color="blue">' . $rt['money'] . $money_list[$rt['type']] . '</font>)' . $e6_c['a_w_19'];
			$e6_propaganda['withdrawmsg'] && E6::M()->msg($rt['uid'], $e6_c['a_w_20'], $message_content);
			DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `withdraw`=`withdraw`+'$rt[money]' WHERE `uid`='$rt[uid]'");
		}
		DB::query("UPDATE ".DB::table('e6_pro_finance')." SET `ok`='1',`okdate`='$_G[timestamp]' WHERE `id` IN ($pass)");
	}
	if (is_array($_POST['quit'])) {
		foreach ($_POST['quit'] as $k=>$v) {
			$quit .= ",'".intval($v)."'";
		}
		$quit = trim($quit,',');
		$query = DB::query("SELECT * FROM " .DB::table('e6_pro_finance')." WHERE `id` IN ($quit)");
		while ($rt = DB::fetch($query)) {
			$date = dgmdate($rt['date'], "m{$e6_c['a_w_21']}d{$e6_c['a_w_22']} H:i");
			E6::M()->money(array($rt['type']=>$rt['money']), '7c', $rt['uid'], $date);
			if ($rt['feemoney']) {
				E6::M()->money(array($rt['feetype']=>$rt['feemoney']), '7d', $rt['uid'], $date);
				$rt['fee'] = '</font>' . $e6_c['a_w_23'] . '<font color="red">' . $rt['feemoney'] . $money_list[$rt['feetype']];
			}
			$message_content = $e6_c['a_w_24'] . dgmdate($rt['date'],'Y-m-d H:i:s') . $e6_c['a_w_25'] . '(<font color="blue">' . $rt['money'] . $money_list[$rt['type']] . $rt['fee'] . '</font>)' . $e6_c['a_w_26'];
			$e6_propaganda['withdrawmsg'] && E6::M()->msg($rt['uid'], '您的提现申请已被退回', $message_content);
		}
		DB::query("UPDATE ".DB::table('e6_pro_finance')." SET `ok`='2',`okdate`='$_G[timestamp]' WHERE `id` IN ($quit)");
	}
	E6::M()->cpmsg();
} else {
	$adminurl = E6::M()->adminurl();
	if (is_array($e6_propaganda['withdraw_profile'])) {
		foreach ($e6_propaganda['withdraw_profile'] as $value) {
			$user_field .= "'{$value}',";
			$field_user .= "u.{$value},";
		}
		if ($user_field) {
			$user_field = trim($user_field, ',');
			$field_user = trim($field_user, ',');
			$query = DB::query("SELECT `fieldid`,`title` FROM ".DB::table('common_member_profile_setting')." WHERE `available`='1' AND `fieldid` IN ($user_field) ORDER BY `fieldid` ASC");
			while ($rt = DB::fetch($query)) {
				$profile_list[$rt['fieldid']] = $rt['title'];
			}
		}
	}
	$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
	if ($page < 1) $page = 1;
	$perpage = 15;
	$start = ($page-1)*$perpage;
	$theurl = 'admin.php?action=plugins&operation=config&identifier=e6_propaganda&pmod=admin_withdraw';
	$multi = '';
	$where = 'WHERE 1=1';
	E6::M()->getgpc(array('username', 'ok', 'sdate', 'edate'));
	if($_GET['excel'] == 'down'){
		$ok = '0';
		$start = 0;
		$perpage = 1000;
	}
	$ok_list = array($e6_c['a_w_27'], $e6_c['a_w_28'], $e6_c['a_w_29']);
	foreach($ok_list as $key => $value){
		$ok_option .= "<option value=\"{$key}\">$value</option>";
	}
	if ($username) {
		$uid = E6::M()->get_uid($username);
		if ($uid>0) {
			$where .= " AND m.uid='{$uid}'";
		} else {
			$where .= " AND m.uid='0'";
		}
		$theurl .='&username='.$username;
	}
	if ($ok != '') {
		$where .= " AND m.ok='{$ok}'";
		$theurl .= '&ok=' . $ok;
	}
	if ($sdate) {
		$_POST['sdate'] && $sdate = strtotime($_POST['sdate']);
		$sdate = intval($sdate);
		$where .= " AND m.date>'{$sdate}'";
		$theurl .='&sdate='.$sdate;
	}
	if ($edate) {
		$_POST['edate'] && strtotime($_POST['edate']);
		$edate = intval($edate);
		$where .= " AND m.date<'{$edate}'";
		$theurl .='&edate='.$edate;	
	}
	$count = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_finance')." m $where ");
	if ($count) {
		$n = ($page - 1)*$perpage+1;
		if ($field_user) {
			$query = DB::query("SELECT m.*,$field_user FROM ".DB::table('e6_pro_finance')." m LEFT JOIN ".DB::table('common_member_profile')." u ON m.uid=u.uid $where ORDER BY m.id DESC LIMIT $start,$perpage");
		} else {
			$query = DB::query("SELECT m.* FROM ".DB::table('e6_pro_finance')." m $where ORDER BY m.id DESC LIMIT $start,$perpage");
		}
		while ($rt = DB::fetch($query)) {
			$rt['n'] = $n;
			$rt['date'] = dgmdate($rt['date'],'Y-m-d H:i:s');
			if($rt['okdate']){
				$rt['okdate'] = dgmdate($rt['okdate'],'Y-m-d H:i:s');
			}else{
				$rt['okdate'] = $e6_c['a_w_30'];
			}
			$rt['ok_text'] = $ok_list[$rt['ok']];
			$rt['type'] =  $money_list[$rt['type']];
			$rt['feetype'] =  $money_list[$rt['feetype']];
			$list[] = $rt;
			$n++;
		}
		if($_GET['excel'] == 'down'){
			$list_withdraw .= "序号,";
			$list_withdraw .= $e6_c['a_w_31'];
			$list_withdraw .= $e6_c['a_w_32'];
			if ($e6_propaganda['feetype']) {
				$list_withdraw .= $e6_c['a_w_33'];
			}
			foreach($profile_list as $value) {
				$list_withdraw .= "{$value},";
			}
		 	$list_withdraw .= $e6_c['a_w_34'] . "\n";
			foreach ($list as $value) {
				$list_withdraw .= "{$value['n']},";
				$list_withdraw .= $value['username'] . ",";
				$list_withdraw .= $value['money'] . $value['type'] . ",";
				if ($e6_propaganda['feetype']) {
					$list_withdraw .= $value['feemoney'] . $value['feetype'] . ",";
				}
				foreach ($profile_list as $k => $v) {
					$list_withdraw .= $value[$k] . ",";
				}
				$list_withdraw .= $value['date'] . ",\n";
			}
			define('FOOTERDISABLED', 1);
			ob_end_clean();
			header('Content-Encoding: none');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=withdraw.csv');
			header('Pragma: no-cache');
			header('Expires: 0');		
			if($_G['charset'] != 'gbk') {
				$list_withdraw = diconv($list_withdraw, $_G['charset'], 'GBK');
			}
			echo $list_withdraw; exit;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
	$_GET['excel'] == 'down' && exit($e6_c['a_w_35']);
	@include template('e6_propaganda:withdraw');	 
}
?>