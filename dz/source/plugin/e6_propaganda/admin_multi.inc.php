<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
if (empty($_POST['step'])) {
	E6::M()->prompt($e6_c['a_m_1'] . ': <span style="color:blue;">' . $e6_c['a_m_2'] . '</span> <span style="color:red;">' . $e6_c['a_m_3'] . '</span>');
	E6::M()->header();
	E6::M()->type('text', array('vip_date', $e6_c['a_m_4'], $e6_c['a_m_5'], $e6_c['a_m_6']));
	E6::M()->type('text', array('pay_date', $e6_c['a_m_7'], $e6_c['a_m_8'], $e6_c['a_m_6']));
	E6::M()->type_header($e6_c['a_m_9'], $e6_c['a_m_10']);
	echo '<ul class="nofloat" style="width:100%" onmouseover="altStyle(this);">';
	foreach (E6::M()->group_list() as $k=>$v) {
		echo "<li style=\"float: left; width: 25%\"><span>{$v}: </span>";E6::M()->text("dividendl_{$k}", $e6_c['a_m_11'], 'style="width:30px;"');echo "</li>";
	}
	echo '</ul>';
	E6::M()->type_footer();
	if (${$e6_name}['registertype'] == 2 or ${$e6_name}['paytype'] or ${$e6_name}['group_id']) {
		E6::M()->type_header_pure($e6_c['a_m_12'], $e6_c['a_m_13'] . '(<a href="' . E6::M()->adminurl('admin_high') . '">' . $e6_c['a_m_14'] . '</a>)');
		for ($n=1; $n<=10; $n++) {
			echo '<tr class="noborder">
				<td class="vtop rowform" colspan="2" style="width:100%">
				<ul class="nofloat" style="width:100%" onmouseover="altStyle(this);">';
			if (${$e6_name}['registertype'] == 2) {
				echo '<li style="float: left; width: 33%">';
				echo '<span style="color:blue;">' . $n . $e6_c['a_m_15'] . '</span>';E6::M()->text("multi_reg_{$n}", false, 'size="2"');
				E6::M()->select("multi_regtype_{$n}", E6::M()->money_list(), false, 'style="width:80px;"');
				echo '</li>';
			}
			if (${$e6_name}['group_id']) {
				echo '<li style="float: left; width: 33%">';
				echo '<span style="color:red;">' . $n . $e6_c['a_m_16'] . '</span>';E6::M()->text("multi_vip_{$n}", false, 'size="2"');
				E6::M()->select("multi_viptype_{$n}", E6::M()->money_list(), false, 'style="width:80px;"');
				echo '</li>';
			}
			if (${$e6_name}['paytype']) {
				echo '<li style="float: left; width: 33%">';
				echo '<span style="color:blue;">' . $n . $e6_c['a_m_17'] . '</span>';E6::M()->text("multi_pay_{$n}", false, 'size="2"');
				if (${$e6_name}['paytype'] == 2) {
					echo '<span> %</span>';
				} else {
					E6::M()->select("multi_paytype_{$n}", E6::M()->money_list(), false, 'style="width:80px;"');
				}
				echo '</li>';
			}
			echo '</ul>';
			E6::M()->type_footer();
		}
	}
	E6::M()->footer();
} else {
	foreach(E6::M()->group_list() as $key=>$value) {
		if ($_POST[$e6_name]['dividendl_'.$key] >10){
			$_POST[$e6_name]['dividendl_'.$key] = 10;
			$msg = $e6_c['a_m_18'];
		}
	}
	if (!$_POST[$e6_name]['vip_date']) {
		$_POST[$e6_name]['vip_date'] = 2;
		$msg = $e6_c['a_m_1'];
	}
	if (!$_POST[$e6_name]['pay_date']) {
		$_POST[$e6_name]['pay_date'] = 2;
		$msg = $e6_c['a_m_20'];
	}
	E6::M()->save();
}
?>