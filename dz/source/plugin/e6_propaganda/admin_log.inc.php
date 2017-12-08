<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
$my_url = E6::M()->adminurl();
if ($_GET['deldate']) {
	$olddate = $_G['timestamp'] - $_GET['deldate'] * 86400;
	DB::query("DELETE FROM " . DB::table('e6_pro_credit') . " WHERE `date`<$olddate");
	E6::M()->cpmsg($e6_c['a_l_22']);
}
if ($_POST['step'] == 2) {
	
	DB::delete('e6_pro_credit', DB::field('id', $_POST['del']));
	
	E6::M()->cpmsg($e6_c['a_l_22']);
}
$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
if($page<1) $page = 1;
$perpage = 15;
$start = ($page-1)*$perpage;
$theurl = $my_url;
$multi = '';
$where = ' WHERE 1=1';
E6::M()->getgpc(array('username', 'sdate', 'edate'));
if ($username) {
	$where .= " AND username='{$username}'";
	$theurl .= '&username='.$username;	
}
if (($type = intval($_POST[$e6_name]['type'])) or ($type = intval($_GET['type']))) {
	$where .= " AND type='" . $type . "'";
	$theurl .= '&type=' . $type;
}
if (($logtype = intval($_POST[$e6_name]['logtype'])) or ($logtype = intval($_GET['logtype']))) {
	$where .= " AND logtype='". $logtype ."'";
	$theurl .= '&logtype=' . $logtype;
}
if ($sdate) {
	$_POST['sdate'] && $sdate = strtotime($sdate);
	$where .= " AND date>'{$sdate}'";
	$theurl .='&sdate='.$sdate;
}
if ($edate) {
	$_POST['edate'] && $edate = strtotime($edate);
	$where .= " AND date<'{$edate}'";
	$theurl .='&edate='.$edate;
}
$count = DB::result_first("SELECT COUNT(*) FROM " . DB::table('e6_pro_credit') . " $where ");
if ($count) {
	$log_type = E6::M()->log_type();
	$money_list = E6::M()->money_list();
	$n = ($page-1)*$perpage+1;
	$query = DB::query("SELECT * FROM " . DB::table('e6_pro_credit') . " $where ORDER BY `id` DESC LIMIT $start,$perpage");
	while($rt = DB::fetch($query)) {
		$rt['n'] = $n;
		$rt['logtype'] = $log_type[$rt['logtype']];
		$rt['type'] = $money_list[$rt['type']];
		$rt['dates'] = dgmdate($rt['date'],'m-d H:i:s');
		$rt['date'] = dgmdate($rt['date'],'Y-m-d H:i:s');
		$list[] = $rt;
		$n++;
	}
	$multi = multi($count, $perpage, $page, $theurl);
}
@include template('e6_propaganda:log');
?>