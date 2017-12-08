<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
$my_url = E6::M()->adminurl();
if (empty($_POST['step'])){
	$query = DB::query("SELECT p.uid FROM ".DB::table('e6_pro_user')." p LEFT JOIN ".DB::table('common_member')." m ON p.uid=m.uid WHERE m.username IS NULL" );
	while($rt = DB::fetch($query)){
		$_POST['quit'][] = $rt['uid'];
	}
	$_POST['quit'] && $_POST['step'] = 2;
	$delmsg = 1;
}
if ($_POST['step'] == 2){
	if (is_array($_POST['quit'])) {
		foreach ($_POST['quit'] as $v) {
			$quit .= ",'".intval($v)."'";
		}
		$quit = trim($quit,',');
		DB::query("DELETE FROM ".DB::table('e6_pro_clientorder')." WHERE `uid` IN ($quit)");
		DB::query("DELETE FROM ".DB::table('e6_pro_credit')." WHERE `uid` IN ($quit)");
		DB::query("DELETE FROM ".DB::table('e6_pro_finance')." WHERE `uid` IN ($quit)");
		DB::query("DELETE FROM ".DB::table('e6_pro_user')." WHERE `uid` IN ($quit)");
		DB::query("DELETE FROM ".DB::table('e6_pro_user_count')." WHERE `uid` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid1`='' WHERE `fuid1` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid2`='' WHERE `fuid2` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid3`='' WHERE `fuid3` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid4`='' WHERE `fuid4` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid5`='' WHERE `fuid5` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid6`='' WHERE `fuid6` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid7`='' WHERE `fuid7` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid8`='' WHERE `fuid8` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid9`='' WHERE `fuid9` IN ($quit)");
		DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid10`='' WHERE `fuid10` IN ($quit)");
	}
	$msg = $delmsg ? $e6_c['a_u_20'] : $e6_c['a_u_21'];
	E6::M()->cpmsg($msg);
} elseif ($_POST['step'] == 3) {
	$uid = intval($_POST['uid']);
	for ($n = 1; $n <= 10; $n++) {
		if ($_POST['username'.$n]) {
			${'uid'.$n} = E6::M()->get_uid($_POST['username'.$n]);
			if (empty(${'uid'.$n})) {
				E6::M()->cpmsg($e6_c['a_u_22'] . $_POST['username'.$n] . $e6_c['a_u_23'], "&edit={$uid}");
			}
			$alluser = E6::M()->statistics(${'uid'.$n});
			E6::M()->get_prouser(${'uid'.$n});
			DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `register`='$alluser' WHERE `uid`='" . ${'uid'.$n} . "'");
		} else {
			${'uid'.$n} = 0;
		}
	}
	$uid && DB::query("UPDATE ".DB::table('e6_pro_user')." SET `fuid1`='$uid1',`fuid2`='$uid2',`fuid3`='$uid3',`fuid4`='$uid4',`fuid5`='$uid5',`fuid6`='$uid6',`fuid7`='$uid7',`fuid8`='$uid8',`fuid9`='$uid9',`fuid10`='$uid10' WHERE `uid`='$uid'");
	E6::M()->cpmsg($e6_c['a_u_24']);
} elseif ($_GET['edit']) {
	$uid = intval($_GET['edit']);
	$username = E6::M()->get_username($uid);
	$user = E6::M()->get_prouser($uid);
	for ($n = 1; $n <= 10; $n++) {
		if ($user['fuid'.$n]) {
			$user['username'.$n] = E6::M()->get_username($user['fuid'.$n]);
		}
	}
	include template('e6_propaganda:user');
} else {
	$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
	if ($page<1) $page = 1;
	$perpage = 15;
	$start = ($page-1)*$perpage;
	$theurl = $my_url;
	$multi = '';
	$where = 'where 1=1';
	E6::M()->getgpc(array('username', 'type'));
	if ($username or $_GET['uid']) {
		if ($_GET['uid']) {
			$uid = intval($_GET['uid']);
			$username = E6::M()->get_username($uid);
			$type = 1;
		} else {
			$uid = E6::M()->get_uid($username);
		}
		if ($uid>0) {
			if ($type == 1) {
				E6::M()->get_prouser($uid);
				$where .= " AND uid='".$uid."'";
			} else {
				$where .= " AND (fuid1='$uid' or fuid2='$uid' or fuid3='$uid' ".
				"or fuid4='$uid' or fuid5='$uid' or fuid6='$uid' or ".
				"fuid7='$uid' or fuid8='$uid' or fuid9='$uid' or fuid10='$uid')";
				$type2 = 'selected';
			}
		} else {
			$where .= " AND uid='0'";
		}
		$theurl .='&username='.$username.'&type='.$type;
	}
	$count = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_user')." $where ");
	if ($count) {
		$n = ($page-1)*$perpage+1;
		$query = DB::query("SELECT * FROM ".DB::table('e6_pro_user')." $where ORDER BY `id` DESC LIMIT $start,$perpage");
		while ($rt = DB::fetch($query)) {
			$rt['n'] = $n;
			$rt['username'] = E6::M()->get_username($rt['uid']);
			for ($n = 1; $n <= 10; $n++) {
				if ($rt['fuid'.$n]) {
					$rt{'username'.$n} = E6::M()->get_username($rt['fuid'.$n]);
				}
			}
			$list[] = $rt;
			$n++;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
	@include template('e6_propaganda:user');
}
?>