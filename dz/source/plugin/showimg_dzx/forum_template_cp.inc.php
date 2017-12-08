<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}



loadcache('forums');
$fid = intval($_GET['fid']);
if($fid==0){
	foreach($_G['cache']['forums'] as $key => $value){
		if($value['type']=='forum'){
			$fid=$key;
			break;
		}
	}
}

loadcache('plugin');
if($_GET['op'] == 'save') {
	$pluginvarid = DB::result_first("SELECT pluginvarid FROM ".DB::table('common_pluginvar')." where pluginid=$pluginid and variable='forum_template'");
	$pluginvars = array();
	$forumset['special1'] = $_POST['special1'];
	$forumset['special2'] = $_POST['special2'];
	$forumset['special4'] = $_POST['special4'];
	$forumset['special5'] = $_POST['special5'];
	$pluginvars[$pluginvarid][$fid]=serialize($forumset);
	set_pluginsetting($pluginvars);
	updatecache(array('forums'));//¸üÐÂ»º´æ
	$_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting'] = $pluginvars[$pluginvarid][$fid];
	cpmsg('report_receive_succeed', 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=showimg_dzx&pmod=forum_template_cp&fid='.$_GET['fid'], 'succeed');
}

$special1_default = lang('plugin/showimg_dzx', 'lang005');
$special2_default = lang('plugin/showimg_dzx', 'lang006');
$special4_default = lang('plugin/showimg_dzx', 'lang007');
$special5_default = lang('plugin/showimg_dzx', 'lang008');

require_once libfile('function/forumlist');
$forumlist = forumselect(FALSE, 0, $fid, TRUE);
$jumpmenu = '<script type="text/javascript">function MM_jumpMenu(targ,selObj,restore){ eval(targ+".location=\''.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=showimg_dzx&pmod=forum_template_cp&fid="+selObj.options[selObj.selectedIndex].value+"\'");  if (restore) selObj.selectedIndex=0;}
</script>';


showtableheader();


echo $jumpmenu.lang('plugin/showimg_dzx','bkxz').':<select name="classid" id="class" class="select" onchange="MM_jumpMenu(\'self\',this,0)">'.$forumlist.'</select>';

$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_template']);

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=showimg_dzx&pmod=forum_template_cp&op=save&fid='.$fid,'','save_setting');
showsetting(lang('plugin/showimg_dzx', 'lang009'),'special1',$forumset['special1']?$forumset['special1']:$special1_default,'textarea','','',lang('plugin/showimg_dzx', 'lang010'));
showsetting(lang('plugin/showimg_dzx', 'lang011'),'special2',$forumset['special2']?$forumset['special2']:$special2_default,'textarea','','',lang('plugin/showimg_dzx', 'lang016'));
showsetting(lang('plugin/showimg_dzx', 'lang013'),'special4',$forumset['special4']?$forumset['special4']:$special4_default,'textarea','','',lang('plugin/showimg_dzx', 'lang014'));
showsetting(lang('plugin/showimg_dzx', 'lang015'),'special5',$forumset['special5']?$forumset['special5']:$special5_default,'textarea','','',lang('plugin/showimg_dzx', 'lang016'));
showsubmit('save_setting',lang('plugin/showimg_dzx','save'));
showformfooter();



showtablefooter();

?>