<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
if (empty($_POST['step'])) {
	E6::M()->prompt($e6_c['a_a_1']);
	E6::M()->header();
	E6::M()->type('text', array('active_num', $e6_c['a_a_2'], $e6_c['a_a_3'], $e6_c['a_a_4']));
	E6::M()->type('text', array('active_date', $e6_c['a_a_5'], $e6_c['a_a_6'], $e6_c['a_a_7']));
	for ($n=1; $n<=${$e6_name}['active_num']; $n++) {
		E6::M()->type_header($n . $e6_c['a_a_8'], $e6_c['a_a_9']);
		echo '<ul class="nofloat" style="width:100%">';
		echo '<li style="float: left; width: 33%">';E6::M()->text("active{$n}_condition_online", $e6_c['a_a_10']);echo '</li>';
		echo '<li style="float: left; width: 33%">';E6::M()->text("active{$n}_condition_posts", $e6_c['a_a_11']);echo '</li>';
		echo '<li style="float: left; width: 33%"><span>' . $e6_c['a_a_17'] . ': </span>';
		E6::M()->select("active{$n}_condition_groupid", E6::M()->group_list(), $e6_c['a_a_12']);
		echo '</li></ul>';
		E6::M()->type_footer();
		E6::M()->type_header($n . $e6_c['a_a_13'], $e6_c['a_a_14']);
		E6::M()->text_arr("active{$n}_money", E6::M()->money_list());
		E6::M()->type_footer();
	}
	E6::M()->footer();
} else {
	if ($_POST[$e6_name]['active_num']>10) {
		$_POST[$e6_name]['active_num'] = 10;
		$msg = $e6_c['a_a_15'];
	}
	for($n = $_POST[$e6_name]['active_num']+1; $n<=10; $n++) {
		unset($_POST[$e6_name]['active'.$n.'_money'], $_POST[$e6_name]['active'.$n.'_condition_posts'], $_POST[$e6_name]['active'.$n.'_condition_groupid'], $_POST[$e6_name]['active'.$n.'_condition_online']);
		unset(${$e6_name}['active'.$n.'_money'], ${$e6_name}['active'.$n.'_condition_posts'], ${$e6_name}['active'.$n.'_condition_groupid'], ${$e6_name}['active'.$n.'_condition_online']);
	}
	if ($_POST[$e6_name]['active_num'] && !$_POST[$e6_name]['active_date']) {
		$_POST[$e6_name]['active_date'] = 2;
		$msg = $e6_c['a_a_16'];
	}
	E6::M()->save();
}
?>