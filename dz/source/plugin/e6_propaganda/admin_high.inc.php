<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
if (empty($_POST['step'])) {
	$profile_array = array(
		'birthyear',
		'birthmonth',
		'birthprovince',
		'birthdist',
		'birthcommunity',
		'resideprovince',
		'residedist',
		'residecommunity',
		'idcardtype'
	);
	$query = DB::query("SELECT `fieldid`,`title` FROM ".DB::table('common_member_profile_setting')." WHERE `available`='1' ORDER BY `fieldid` ASC");
	while ($rt = DB::fetch($query)) {
		if(!in_array($rt['fieldid'], $profile_array)) {
			$profile_list[$rt['fieldid']] = $rt['title'];
		}
	}
	!${$e6_name}['url_url'] && ${$e6_name}['url_url'] = $_G['siteurl'] . 'forum.php';
	E6::M()->js('j');
	E6::M()->js('admin');
	E6::M()->header();
	E6::M()->type('select', array('group_id', $e6_c['a_h_1'], $e6_c['a_h_2'] . ' (<a href="' . E6::M()->adminurl('admin_multi') . '">' . $e6_c['a_h_3'] . '</a>)', E6::M()->group_list(" WHERE `type`='special' AND `radminid`='0' "), $e6_c['a_h_4']));
	E6::M()->type_header($e6_c['a_h_5'], '<span class="pay id0">' . $e6_c['a_h_6'] . '</span><span class="pay id1" style="display:none;color:blue;">' . $e6_c['a_h_7'] . '(<a href="' . E6::M()->adminurl('admin_multi') . '">' . $e6_c['a_h_8'] . '</a>)</span><span class="pay id2" style="display:none;color:red;">' . $e6_c['a_h_9'] . ' (<a href="' . E6::M()->adminurl('admin_multi') . '">' . $e6_c['a_h_10'] . '</a>)</span>');
	echo '<span>' . $e6_c['a_h_11'] . ': </span>';
	E6::M()->select('paytype', array($e6_c['a_h_12'], $e6_c['a_h_13'], $e6_c['a_h_14']), false, 'onchange="show_type(\'pay\',this);" id="paytype" style="width:120px;"');
	echo ' <span class="pay id2" style="display:none;">' . $e6_c['a_h_15'] . ':</span>';
	E6::M()->text('pay_money2', false, 'class="pay id2" style="width:50px;display:none;"');
	E6::M()->select('pay_type2', E6::M()->money_list(), false, 'class="pay id2" style="width:120px;display:none;"');
	E6::M()->type_footer();
	E6::M()->type('radio', array('paymsg', $e6_c['a_h_16'], $e6_c['a_h_17']));
	if ($GLOBALS['_G']['setting']['version'] != 'X2') {
		E6::M()->type('radio', array('paycard', $e6_c['a_h_18'], $e6_c['a_h_19'] . '(<a href="admin.php?action=card&operation=manage">' . $e6_c['a_h_20'] . '</a>)'));
	}
	E6::M()->type('radio', array('withdrawopen', $e6_c['a_h_21'], $e6_c['a_h_22']));
	E6::M()->type_header($e6_c['a_h_23'], $e6_c['a_h_24']);
	E6::M()->text('withdraw_money', false, 'style="width:50px;"');
	E6::M()->select('withdraw_type', E6::M()->money_list());
	E6::M()->type_footer();
	E6::M()->type_header($e6_c['a_h_25'], '<span class="fee id0">' . $e6_c['a_h_26'] . '</span><span class="fee id1" style="display:none;color:blue;">' . $e6_c['a_h_27'] .  '</span><span class="fee id2" style="display:none;color:red;">' . $e6_c['a_h_28'] .  '</span>');
	E6::M()->select('feetype', array($e6_c['a_h_29'], $e6_c['a_h_30'], $e6_c['a_h_31']), false, 'style="width:120px;" onchange="show_type(\'fee\',this);" id="feetype"');
	echo ' <span class="fee id1" style="display:none;">' . $e6_c['a_h_32'] . ':</span>';
	E6::M()->text('fee_money', false, 'class="fee id1" style="width:50px;display:none;"');
	E6::M()->select('fee_type', E6::M()->money_list(), false, 'class="fee id1" style="width:100px;display:none;"');
	echo '<span class="fee id2" style="display:none;">' . $e6_c['a_h_33'] . ':</span>';
	E6::M()->text('pay_proportion', '<span class="fee id2" style="display:none;"> %</span>', 'class="fee id2" style="width:50px;display:none;"');
	E6::M()->type_footer();
	E6::M()->type('radio', array('withdrawmsg', $e6_c['a_h_34'], $e6_c['a_h_35']));
	E6::M()->type('checkbox', array('withdraw_profile', $e6_c['a_h_36'], $e6_c['a_h_37'] . '( <a href="admin.php?action=members&operation=profile">' . $e6_c['a_h_38'] . '</a> )', $profile_list));
	E6::M()->type('checkbox', array('withdrawgroup', $e6_c['a_h_39'], $e6_c['a_h_40'], E6::M()->group_list()));
	E6::M()->type_header($e6_c['a_h_41'], $e6_c['a_h_42']);
	E6::M()->textarea('withdrawann', 'id="withdrawann"');
	E6::M()->type_footer();
	E6::M()->type('checkbox', array('nav_arr', $e6_c['a_h_43'], $e6_c['a_h_44'], E6::M()->nav()));
	e6_form ::type_header($e6_c['a_h_45'], '<span class="url id1" style="color:blue;">' . $e6_c['a_h_46'] . '</span><span class="url id2" style="display:none;color:red;">' . $e6_c['a_h_47'] . '</span>');
	echo '<span>' . $e6_c['a_h_48'] . ': </span>';
	E6::M()->select('urltype', array(1=>$e6_c['a_h_49'], 2=>$e6_c['a_h_50']), false, 'style="width:130px;" onchange="show_type(\'url\',this);" id="urltype"');
	echo ' <span class="url id1">' . $e6_c['a_h_51'] . ':</span>';
	E6::M()->text('url_url', false, 'class="url id1" style="width:400px;"');
	E6::M()->type_footer();
	E6::M()->type('radio', array('cheatlog', $e6_c['a_h_52'], $e6_c['a_h_53']));
	E6::M()->footer();
} else {
	if (!$e6_propaganda['paytype'] && $_POST[$e6_name]['paytype']) {
		DB::query("UPDATE " . DB::table('e6_pro_clientorder') . " SET `date`='{$_G['timestamp']}' WHERE `uid`='0'");
	}
	if ($_POST[$e6_name]['urltype'] == 2) {
		$digest_Y = E6::M()->rand_digest();
		if (!$digest_Y) {
			$_POST[$e6_name]['urltype'] = 1;
			$msg = $e6_c['a_h_54'];
		}
	}
	if ($_POST[$e6_name]['paytype'] == 2 && !$_POST[$e6_name]['pay_money2']) {
		$_POST[$e6_name]['pay_money2'] = 1;
		$msg = $e6_c['a_h_55'];
	}
	$_POST[$e6_name]['withdrawann'] = cutstr($_POST[$e6_name]['withdrawann'], 50, NULL);
	!$_POST[$e6_name]['withdraw_profile'] && $_POST[$e6_name]['withdraw_profile'] = null;
	!$_POST[$e6_name]['withdrawgroup'] && $_POST[$e6_name]['withdrawgroup'] = null;
	!$_POST[$e6_name]['nav_arr'] && $_POST[$e6_name]['nav_arr'] = null;
	E6::M()->save();
}
?>