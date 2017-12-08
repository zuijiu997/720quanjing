<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
$my_url = E6::M()->adminurl();
if ($_GET['task'] == 'add' or $_GET['task'] == 'edit') {
	if ($_POST['step'] == 2) {
		E6::M()->getgpc($e6_name);
		!$e6_propaganda['name'] && $msg = $e6_c['a_t_16'];
		if(!$e6_propaganda['claim_'.$e6_propaganda['claim'].'_1'] or ($e6_propaganda['claim'] > 4 && !$e6_propaganda['claim_'.$e6_propaganda['claim'].'_2'])){
			$msg = $e6_c['a_t_17'];
		}
		if(!$e6_propaganda['reward_'.$e6_propaganda['reward'].'_1'] or ($e6_propaganda['reward'] != 3 && $e6_propaganda['reward'] != 4 && !$e6_propaganda['reward_'.$e6_propaganda['reward'].'_2'])){
			$msg = $e6_c['a_t_18'];
		}
		$operating = $_GET['task'] == 'edit' ? 'UPDATE' : 'INSERT INTO';
		$_GET['task'] == 'edit' && $where = " WHERE `id`='".intval($_GET['taskid'])."'";
		!$msg && DB::query("$operating ".DB::table('e6_pro_task')." SET "."
			`name`			=	'{$e6_propaganda['name']}',
			`icon`			=	'{$e6_propaganda['icon']}',
			`starttime`		=	'".strtotime($e6_propaganda['starttime'])."',
			`endtime`		=	'".strtotime($e6_propaganda['endtime'])."',
			`claim`			=	'{$e6_propaganda['claim']}',
			`claim1`		=	'{$e6_propaganda['claim_'.$e6_propaganda['claim'].'_1']}',
			`claim2`		=	'{$e6_propaganda['claim_'.$e6_propaganda['claim'].'_2']}',
			`reward`		=	'{$e6_propaganda['reward']}',
			`reward1`		=	'{$e6_propaganda['reward_'.$e6_propaganda['reward'].'_1']}',
			`reward2`		=	'{$e6_propaganda['reward_'.$e6_propaganda['reward'].'_2']}',
			`grouplimit`	=	'".($e6_propaganda['grouplimit'] ? serialize($e6_propaganda['grouplimit']) : '')."' $where
		");
		$msg && $url = '&task=' . $_GET['task'] . '&taskid='. $_GET['taskid'];
		!$msg && $msg = $e6_c['a_t_19'];
		E6::M()->cpmsg($msg, $url);
	} else {
		if ($_GET['task'] == 'edit' && $_GET['taskid']) {
			$e6_propaganda = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task')." WHERE `id`='".intval($_GET['taskid'])."'");
			$e6_propaganda['starttime'] = $e6_propaganda['starttime'] ? dgmdate($e6_propaganda['starttime'],'Y-m-d H:i:s') : '';
			$e6_propaganda['endtime'] = $e6_propaganda['endtime'] ? dgmdate($e6_propaganda['endtime'],'Y-m-d H:i:s') : '';
			$e6_propaganda['claim_'.$e6_propaganda['claim'].'_1'] = $e6_propaganda['claim1'];
			$e6_propaganda['claim_'.$e6_propaganda['claim'].'_2'] = $e6_propaganda['claim2'];
			$e6_propaganda['reward_'.$e6_propaganda['reward'].'_1'] = $e6_propaganda['reward1'];
			$e6_propaganda['reward_'.$e6_propaganda['reward'].'_2'] = $e6_propaganda['reward2'];
			$e6_propaganda['grouplimit'] && $e6_propaganda['grouplimit'] = unserialize($e6_propaganda['grouplimit']);
		}
		E6::M()->prompt("<a href=\"$my_url&task=add\" style=\"color:red;\">$e6_c[a_t_1]</a> | <a href=\"$my_url\">$e6_c[a_t_2]</a> | <a href=\"$my_url&task=current\">$e6_c[a_t_3]</a> | <a href=\"$my_url&task=over\">$e6_c[a_t_4]</a>");
		print '<script src="static/js/calendar.js" type="text/javascript"></script>';
		E6::M()->js('j');
		E6::M()->js('admin');
		E6::M()->header();
		E6::M()->type('text', array('name', $e6_c['a_t_20'], $e6_c['a_t_21'], false, 'style="width:250px;"'));
		E6::M()->type('text', array('icon', $e6_c['a_t_22'], $e6_c['a_t_23'] . ' source/plugin/'.$e6_name.'/task/' . $e6_c['a_t_24'], false, 'style="width:250px;"'));
		E6::M()->type('text', array('starttime', $e6_c['a_t_25'], $e6_c['a_t_26'], false, 'onclick="showcalendar(event, this, 1)" style="width:250px;"'));
		E6::M()->type('text', array('endtime', $e6_c['a_t_27'], $e6_c['a_t_28'], false, 'onclick="showcalendar(event, this, 1)" style="width:250px;"'));
		E6::M()->type_header($e6_c['a_t_29'], $e6_c['a_t_30']);
		E6::M()->select('claim', E6::M()->task_type(), false, 'onchange="show_type(\'claim\',this);" id="claimtype" style="width:120px;"');
		E6::M()->text('claim_1_1', '<span style="display:none" class="claim id1">' . $e6_c['a_t_31']. '</span>', 'class="claim id1" style="width:80px;display:none;"');
		E6::M()->text('claim_2_1', '<span style="display:none" class="claim id2">' . $e6_c['a_t_32']. '</span>', 'class="claim id2" style="width:80px;display:none;"');
		E6::M()->text('claim_3_1', '<span style="display:none" class="claim id3">' . $e6_c['a_t_31']. '</span>', 'class="claim id3" style="width:80px;display:none;"');
		E6::M()->text('claim_4_1', '<span style="display:none" class="claim id4">' . $e6_c['a_t_33']. '</span>', 'class="claim id4" style="width:80px;display:none;"');
		for($n=1; $n<=10; $n++) {
			$activeation_list[$n] = $n . $e6_c['a_t_34'];
		}
		E6::M()->select('claim_5_1', $activeation_list, false, 'class="claim id5" style="width:120px;display:none;"');
		E6::M()->text('claim_5_2', '<span style="display:none" class="claim id5">' . $e6_c['a_t_32'] . '</span>', 'class="claim id5" style="width:80px;display:none;"');
		$group_list = E6::M()->group_list(" WHERE `type`='special' AND `radminid`='0' ");
		if($group_list){
			E6::M()->select('claim_6_1', $group_list, false, 'class="claim id6" style="width:120px;display:none;"');
			E6::M()->text('claim_6_2', '<span style="display:none" class="claim id6">' . $e6_c['a_t_32'] . '</span>', 'class="claim id6" style="width:80px;display:none;"');
		} else {
			print '<span style="display:none;color:red;" class="claim id6">' . $e6_c['a_t_35'] . '(<a href="admin.php?action=usergroups" style="color:blue;">' . $e6_c['a_t_36'] . '</a>)</span>';
		}
		E6::M()->type_footer();
		E6::M()->type_header($e6_c['a_t_37'], $e6_c['a_t_38']);
		E6::M()->select('reward', E6::M()->task_reward(), false, 'onchange="show_type(\'reward\',this);" id="rewardtype" style="width:120px;"');
		E6::M()->text('reward_1_1', false, 'class="reward id1" style="width:80px;display:none;"');
		E6::M()->select('reward_1_2', E6::M()->money_list(), false, 'class="reward id1" style="width:120px;display:none;"');
		$magic_list = E6::M()->magic_list();
		if($magic_list && $_G['setting']['magicstatus']){
			E6::M()->text('reward_2_1', '<span class="reward id2"> ' . $e6_c['a_t_39'] . ' </span>', 'class="reward id2" style="width:80px;display:none;"');
			E6::M()->select('reward_2_2', $magic_list, false, 'class="reward id2" style="width:120px;display:none;"');
		} else {
			print '<span style="display:none;color:red;" class="reward id2">' . $e6_c['a_t_40'] . '(<a href="admin.php?action=magics&operation=admin" style="color:blue;">' . $e6_c['a_t_41'] . '</a>)</span>';
		}
		$medal_list = E6::M()->medal_list();
		if ($medal_list) {
			E6::M()->select('reward_3_1', $medal_list, false, 'class="reward id3" style="width:120px;display:none;"');
		} else {
			print '<span style="display:none;color:red;" class="reward id3">' . $e6_c['a_t_42'] . '(<a href="admin.php?action=medals" style="color:blue;">' . $e6_c['a_t_41'] . '</a>)</span>';
		}
		if($group_list){
			E6::M()->select('reward_4_1', $group_list, false, 'class="reward id4" style="width:120px;display:none;"');
			print '<span style="display:none" class="reward id4">' . $e6_c['a_t_43'] . ': </span>'; 
			E6::M()->text('reward_4_2', '<span style="display:none" class="reward id4">(' . $e6_c['a_t_44'] . ')</span>', 'class="reward id4" style="width:80px;display:none;"');
		} else {
			print '<span style="display:none;color:red;" class="reward id4">' . $e6_c['a_t_45'] . '(<a href="admin.php?action=usergroups" style="color:blue;">' . $e6_c['a_t_46'] . '</a>)</span>';
		}
		E6::M()->type_footer();
		E6::M()->type('checkbox', array('grouplimit', $e6_c['a_t_47'], $e6_c['a_t_48'], E6::M()->group_list()));
		E6::M()->footer();
	}
} elseif ($_GET['task'] == 'del') {
	!$_GET['taskid'] && E6::M()->cpmsg($e6_c['a_t_49']);
	DB::query("DELETE FROM ".DB::table('e6_pro_task')." WHERE `id` = '".intval($_GET['taskid'])."'");
	E6::M()->cpmsg();
} else {
	$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
	if ($page<1) $page = 1;
	$perpage = 15;
	$start = ($page-1)*$perpage;
	$theurl = $my_url;
	$multi = '';
	$where = 'where 1=1';
	$_GET['task'] == 'over' && $where .= " AND `endtime`>0 AND `endtime`<'{$_G['timestamp']}' ";
	$_GET['task'] == 'current' &&  $where .= " AND (`endtime`='0' OR `endtime`>'{$_G['timestamp']}') ";
	$count = DB::result_first("SELECT count(*) FROM ".DB::table('e6_pro_task')." $where ");
	if ($count) {
		$claim_list = E6::M()->task_type();
		$reward_list = E6::M()->task_reward();
		$n = ($page-1)*$perpage+1;
		$query = DB::query("SELECT * FROM ".DB::table('e6_pro_task')." $where ORDER BY `id` DESC LIMIT $start,$perpage");
		while ($rt = DB::fetch($query)) {
			$rt['n'] = $n;
			$rt['claim'] = $claim_list[$rt['claim']];
			$rt['reward'] = $reward_list[$rt['reward']];
			$rt['starttime'] = $rt['starttime'] ? dgmdate($rt['starttime'],'Y-m-d H:i:s') : $e6_c['a_t_50'];
			$rt['endtime'] = $rt['endtime'] ? dgmdate($rt['endtime'],'Y-m-d H:i:s') : $e6_c['a_t_51'];
			$list[] = $rt;
			$n++;
		}
		$multi = multi($count, $perpage, $page, $theurl);
	}
	@include template('e6_propaganda:task');	
}
?>