<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
if ($page<1) $page = 1;
$perpage = 15;
$start = ($page-1)*$perpage;
$theurl = E6::M()->adminurl();
$multi = '';
$where = ' WHERE 1=1 AND g.uid>0';
E6::M()->getgpc(array('username', 'order', 'sdate', 'edate', 'type'));
if ($type != '') {
	$where .= " AND g.type='{$type}'";
	$theurl .= '&type='.$type;
}
if ($username) {
	$uid = E6::M()->get_uid($username);
	$where .= " AND g.uid='{$uid}'";
	$theurl .= '&username='.$username;	
}
if ($order) {
	$where .= " AND g.orderid='{$order}'";
	$theurl .= '&order='.$order;
}
if ($sdate) {
	$_POST['sdate'] && $sdate = strtotime($sdate);
	$where .= " AND g.date>'{$sdate}'";
	$theurl .= '&sdate='.$sdate;
}
if ($edate) {
	$_POST['edate'] && $edate = strtotime($edate);
	$where .= " AND g.date<'{$edate}'";
	$theurl .= '&edate='.$edate;
}
$pay_arr = array($e6_c['a_c_13'], '<font color="blue">' . $e6_c['a_c_14'] . '</font>');
$type_arr = array($e6_c['a_c_15'], $e6_c['a_c_16']);
$count = DB::result_first("SELECT count(*) FROM ". DB::table('e6_pro_clientorder') ." g $where ");
if ($count) {
	$n = ($page-1)*$perpage+1;
	$query = DB::query("SELECT g.*,m.username FROM ". DB::table('e6_pro_clientorder') ." g LEFT JOIN ".DB::table('common_member')." m ON g.uid=m.uid $where ORDER BY `id` DESC LIMIT $start,$perpage");
	while ($rt = DB::fetch($query)) {
		$rt['n'] = $n;
		if ($rt['type'] == 0) {
			$rt['status'] = DB::result_first("SELECT `status` FROM ".DB::table('forum_order')." WHERE `orderid`='{$rt['orderid']}'");
		}
		if ($rt['type'] == 0 && $rt['status'] == '1') {
			$rt['status'] = $e6_c['a_c_17'];
		} else {
			$rt['status'] = '<font color="blue">' . $e6_c['a_c_18'] . '</font>';
		}
		$rt['type'] = $type_arr[$rt['type']];
		$rt['pay'] = $pay_arr[$rt['pay']];
		$rt['date'] = dgmdate($rt['date'],'Y-m-d H:i:s');
		$list[] = $rt;
		$n++;
	}
	$multi = multi($count, $perpage, $page, $theurl);
}
@include template('e6_propaganda:consumption');
?>