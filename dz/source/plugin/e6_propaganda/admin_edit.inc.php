<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
if (empty($_POST['step'])) {
	E6::M()->js('j');
	E6::M()->js('admin');
	E6::M()->header();
	E6::M()->type('radio', array('open', $e6_c['a_e_1'], '<a href="http://www.6ie6.com/hack.php?name=discuz_e6_propaganda" target="_blank" style="color:blue;">' . $e6_c['a_e_2'] . '</a>'));
	E6::M()->type('textarea', array('close', $e6_c['a_e_3'], $e6_c['a_e_4']));
	E6::M()->type('text', array('ip', $e6_c['a_e_5'], $e6_c['a_e_6'], $e6_c['a_e_7']));
	E6::M()->type('text', array('cookie', $e6_c['a_e_8'], $e6_c['a_e_9'], $e6_c['a_e_10'], $e6_c['a_e_11']));
	E6::M()->type('text', array('interval', $e6_c['a_e_12'], $e6_c['a_e_13'], $e6_c['a_e_14']));
	E6::M()->type('radio', array('ipsection', $e6_c['a_e_15'], $e6_c['a_e_16'] . '<span style="color:blue;">124.238.252.248</span>' . $e6_c['a_e_17'] . '<span style="color:blue;">124.238.***.***</span>' . $e6_c['a_e_18']));
	E6::M()->type_header($e6_c['a_e_19'], $e6_c['a_e_20']);
	echo '<span>' . $e6_c['a_e_21'] . ': </span>';E6::M()->select('iptype', array(1=>$e6_c['a_e_22'], 2=>$e6_c['a_e_23']));
	echo '<span>' . $e6_c['a_e_24'] . ': </span>';E6::M()->text('area', $e6_c['a_e_25'], 'style="width:100px;"');
	E6::M()->type_footer();
	E6::M()->type('text_arr', array('visit_money', $e6_c['a_e_26'], $e6_c['a_e_27'], E6::M()->money_list()));
	E6::M()->type_header($e6_c['a_e_28'], $e6_c['a_e_29'], $e6_c['a_e_30']);
	echo '<span>' . $e6_c['a_e_31'] . ':</span>';E6::M()->select('registertype', array($e6_c['a_e_32'], $e6_c['a_e_33'], $e6_c['a_e_34']), false, 'style="width:120px;" onchange="show_type(\'register\',this);" id="registertype"');
	echo '<span class="register id2" style="display:none;color:blue;">' . $e6_c['a_e_35'] . '(<a href="' . E6::M()->adminurl('admin_multi') . '">' . $e6_c['a_e_36'] . '</a>)</span>';
	E6::M()->type_footer();
	echo '<tr class="noborder"><td class="vtop rowform register id1" colspan="2" style="width:100%;display:none;">';
	E6::M()->text_arr('register_money', E6::M()->money_list());
	E6::M()->type_footer();
	E6::M()->type('text_arr', array('region_money', $e6_c['a_e_37'], $e6_c['a_e_38'], E6::M()->money_list()));
	E6::M()->type('radio', array('showuser', $e6_c['a_e_39'], $e6_c['a_e_40']));
	E6::M()->type('radio', array('message', $e6_c['a_e_41'], $e6_c['a_e_42']));
	E6::M()->type('radio', array('tidurl', $e6_c['a_e_43'], $e6_c['a_e_44']));
	E6::M()->type('text_arr', array('max_visit', $e6_c['a_e_45'], $e6_c['a_e_46'], E6::M()->money_list()));
	E6::M()->type('text_arr', array('max_register', $e6_c['a_e_47'], $e6_c['a_e_48'] . '<span style="color:blue;">' . $e6_c['a_e_49'] . '</span>' . $e6_c['a_e_50'], E6::M()->money_list()));
	E6::M()->type('checkbox', array('group', $e6_c['a_e_51'], $e6_c['a_e_52'], E6::M()->group_list()));
	E6::M()->footer();
} else {
	if ($_POST[$e6_name]['iptype'] == 2) {
		$url = "http://www.baidu.com/s?wd=192.168.1.1";
		$ext = stream_context_create(array('http' => array('timeout' => 3)));  
		$file_region = @file_get_contents($url, false, $ext);
		if($file_region){
			$file_region = iconv("UTF-8", "GB2312//IGNORE", $file_region);
			preg_match("/<p class=\"op_ip_detail\">{$e6_c['a_e_53']}&nbsp;&nbsp;&nbsp;{$e6_c['a_e_54']}:&nbsp;<strong>(.*)<\/strong><\/p>/i", $file_region, $str);
		}
		if(!$file_region or !$str[1]){
			$_POST[$e6_name]['iptype'] = 1;
			$msg = $e6_c['a_e_55'];
		}
	}
	!$_POST[$e6_name]['group'] && $_POST[$e6_name]['group'] = null;
	E6::M()->save();
}
?>