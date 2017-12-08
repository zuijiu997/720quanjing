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
	$pluginvarid = DB::result_first("SELECT pluginvarid FROM ".DB::table('common_pluginvar')." where pluginid=$pluginid and variable='forum_setting'");
	$pluginvars = array();
	$forumset['forum_type'] = $_POST['forum_type'];
	$forumset['content_show'] = $_POST['content_show'];
	$forumset['pic_width'] = $_POST['pic_width'];
	$forumset['pic_height'] = $_POST['pic_height'];
	$forumset['digest_len'] = $_POST['digest_len'];
	$forumset['other_set'] = $_POST['other_set'];
	$forumset['wf_pages'] = $_POST['wf_pages'];
	$forumset['pic_num'] = $_POST['pic_num'];
	$forumset['thumb_set'] = $_POST['thumb_set'];
	$pluginvars[$pluginvarid][$fid]=serialize($forumset);
	set_pluginsetting($pluginvars);
	updatecache(array('forums'));//¸üÐÂ»º´æ
	$_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting'] = $pluginvars[$pluginvarid][$fid];
	cpmsg('report_receive_succeed', 'action=plugins&operation=config&do='.$_GET['do'].'&identifier=showimg_dzx&pmod=forum_setting_cp&fid='.$_GET['fid'], 'succeed');
}




require_once libfile('function/forumlist');
$forumlist = forumselect(FALSE, 0, $fid, TRUE);
$jumpmenu = '<script type="text/javascript">function MM_jumpMenu(targ,selObj,restore){ eval(targ+".location=\''.ADMINSCRIPT.'?action=plugins&operation=config&do='.$pluginid.'&identifier=showimg_dzx&pmod=forum_setting_cp&fid="+selObj.options[selObj.selectedIndex].value+"\'");  if (restore) selObj.selectedIndex=0;}
function selecttype(selObj){
	if(selObj.selectedIndex == 2){
		save_setting.wf_pages.disabled = false;
		save_setting.pic_height.disabled = true;
	}else{
		save_setting.wf_pages.disabled = true;
		save_setting.pic_height.disabled = false;
	}
}
</script>';


showtableheader();


echo $jumpmenu.lang('plugin/showimg_dzx','bkxz').':<select name="classid" id="class" class="select" onchange="MM_jumpMenu(\'self\',this,0)">'.$forumlist.'</select>';

$forum_type = array(array(1,lang('plugin/showimg_dzx','pic1')),array(2,lang('plugin/showimg_dzx','pic2')),array(3,lang('plugin/showimg_dzx','pic3')),array(4,lang('plugin/showimg_dzx','pic4')),array(5,lang('plugin/showimg_dzx','lang017')));
$content_show = array(array(0,lang('plugin/showimg_dzx','content_show1')),array(1,lang('plugin/showimg_dzx','content_show2')),array(2,lang('plugin/showimg_dzx','content_show3')),array(4,lang('plugin/showimg_dzx','content_show4')),array(5,lang('plugin/showimg_dzx','content_show5')));
$other_set = array(array(1,lang('plugin/showimg_dzx','nopic')));
$thumb_set = array(array(1,lang('plugin/showimg_dzx', 'lang018')));
/*
$query = DB::query("SELECT * FROM ".DB::table('xj_sort_class')." where parent=0");
$sort =array();
while($item = DB::fetch($query)){
	$value = array();
	$value[] = $item['classid'];
	$value[] = $item['classname'];
	$sort[] = $value;
}
*/
//echo explode(',',$_G['cache']['forums'][$fid]['plugin']['xj_sort']['sorts']);
$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);

showformheader('plugins&operation=config&do='.$pluginid.'&identifier=showimg_dzx&pmod=forum_setting_cp&op=save&fid='.$fid,'','save_setting');
showsetting(lang('plugin/showimg_dzx','forum_type'),array('forum_type', $forum_type), $forumset['forum_type'], 'select','','','','onchange="selecttype(this)"');
showsetting(lang('plugin/showimg_dzx','content_show'), array('content_show', $content_show), $forumset['content_show'], 'mcheckbox');
showsetting(lang('plugin/showimg_dzx','pic_width'),'pic_width',$forumset['pic_width']?$forumset['pic_width']:91,'text','','',lang('plugin/showimg_dzx','lang001'));
showsetting(lang('plugin/showimg_dzx','pic_height'),'pic_height',$forumset['pic_height']?$forumset['pic_height']:68,'text','','',lang('plugin/showimg_dzx','lang002'));
showsetting(lang('plugin/showimg_dzx','digest_len'),'digest_len',$forumset['digest_len'],'text');
showsetting(lang('plugin/showimg_dzx','other_set'),array('other_set', $other_set), $forumset['other_set'], 'mcheckbox');
showsetting(lang('plugin/showimg_dzx','lang003'),'wf_pages',$forumset['wf_pages']?$forumset['wf_pages']:5,'text','','',lang('plugin/showimg_dzx','lang004'));
showsetting(lang('plugin/showimg_dzx', 'lang019'),'pic_num',$forumset['pic_num']?$forumset['pic_num']:3,'text','','',lang('plugin/showimg_dzx', 'lang020'));
showsetting(lang('plugin/showimg_dzx', 'lang021'),array('thumb_set', $thumb_set), $forumset['thumb_set'], 'mcheckbox','','',lang('plugin/showimg_dzx', 'lang022'));
showsubmit('save_setting',lang('plugin/showimg_dzx','save'));
showformfooter();



showtablefooter();

?>