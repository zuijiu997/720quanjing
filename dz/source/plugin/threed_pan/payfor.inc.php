<?php
/**
 *	[网盘虚拟附件--免跳转下载(threed_pan.{modulename})] (C)2014-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2014-12-3 21:54
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
$pan_option = $_G['cache']['plugin']['threed_pan'];	
$pan_forums = unserialize($pan_option["thd_forum"]);
$pan_buyuser=unserialize($pan_option["thd_buyuser"]);
if($_GET['formhash']!=FORMHASH)showmessage(lang('plugin/threed_pan', 'downld2'),  array(), array(), array('alert' => 'error'));
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");
$uid = $_G['uid'];
$tid = intval($_GET['tid']);
if($tid<0)$aid=0-$tid;else $aid=0;
	$pan_srljiage = intval($_GET['gg']);
	$pan_srljiage =($pan_srljiage-131)/91-3;
	if(!is_int($pan_srljiage))showmessage(lang('plugin/threed_pan', 'downld2'),  array(), array(), array('alert' => 'error'));
if($_GET['ac']=="buy"){
	if($uid==0){
		showmessage(lang('plugin/threed_pan', 'downld3'), '', array(), array('alert' => 'info'));
	}else{
		if(!in_array($_G['groupid'], $pan_buyuser)){
			showmessage($pan_option['thd_power'], '', array(), array('alert' => 'info'));
			break;
			}	
		$user_creditnum=DB::result_first("select extcredits".$_G['setting']['creditstransextra'][1]." from ".DB::table('common_member_count')." where uid=".$uid);
		$buy_creditname = $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'];
		$buy_username=DB::result_first("select username from ".DB::table('common_member')." where uid=".$uid);
		$saleid=$aid?DB::result_first("SELECT uid FROM " . DB::table('portal_article_title') .
            " WHERE aid='$aid' LIMIT 1"):DB::result_first('SELECT authorid FROM '.DB::table('forum_thread').' WHERE tid='.$tid);
		$sale_username=DB::result_first("select username from ".DB::table('common_member')." where uid=".$saleid);	
		$yuxia=$user_creditnum-$pan_srljiage;
		$sale_get=intval($pan_srljiage*(1-$_G['setting']['creditstax']));
		$pan_srlgg =($pan_srljiage+3)*91+131;
		include template('threed_pan:pay');
	}
}
if($_GET['ac']=="pay"){
	if(!in_array($_G['groupid'], $pan_buyuser)){
		showmessage($pan_option['thd_power'], '', array(), array('alert' => 'info'));
		break;
	}

	$buy_credit = $_G['setting']['creditstransextra'][1];
	$buy_creditname = $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'];
	$user_creditnum=DB::result_first("select extcredits".$_G['setting']['creditstransextra'][1]." from ".DB::table('common_member_count')." where uid=".$uid);
	$buy_username=DB::result_first("select username from ".DB::table('common_member')." where uid=".$uid);
	if($user_creditnum<$pan_srljiage){
	showmessage($pan_option['thd_credit'],  array(), array(), array('alert' => 'info'));
	}
	$buycount=DB::result_first('SELECT count(1) FROM '.DB::table('threed_pan').' WHERE buy_tid='.$tid.' and buy_uid = '.$uid);

	if($buycount==0){
		$saleid=$aid?DB::result_first("SELECT uid FROM " . DB::table('portal_article_title') .
            " WHERE aid='$aid' LIMIT 1"):DB::result_first('SELECT authorid FROM '.DB::table('forum_thread').' WHERE tid='.$tid);
		$sale_get=intval($pan_srljiage*(1-$_G['setting']['creditstax']));
        $allcount=DB::result_first('SELECT count(1) FROM '.DB::table('threed_pan').' WHERE buy_tid='.$tid);
        $allcount=$allcount*$pan_srljiage;
        if($allcount>$pan_option['thd_up']){
            $sale_get=0;
        }
		$svaebuy = array(
			'buy_uid' => $uid,
			'buy_tid' => $tid,
			'buy_info' => lang('plugin/threed_pan', 'downld7').$pan_srljiage.$buy_creditname.lang('plugin/threed_pan', 'downld8').$sale_get.$buy_creditname,
			'buy_time' => $_G['timestamp']
		);
		$id = C::t('#threed_pan#threed_pan')->insert($svaebuy, true);
		if($id){
            updatemembercount($uid,array('extcredits'.$buy_credit=>'-'.$pan_srljiage),true,'BTC',$tid);
            updatemembercount($saleid,array('extcredits'.$buy_credit=>'+'.$sale_get),true,'STC',$tid);
			showmessage(lang('plugin/threed_pan', 'downld4'), "forum.php?mod=viewthread&tid=$tid",dreferer(), array(), array('alert' => 'right', 'showdialog' => 1, 'locationtime' => false));
		}else{
			showmessage(lang('plugin/threed_pan', 'downld2'),"forum.php?mod=viewthread&tid=$tid",  array(), array(), array('alert' => 'error'));
		}
		
	}else{
		showmessage(lang('plugin/threed_pan', 'downld5'), "forum.php?mod=viewthread&tid=$tid", array(), array(), array('alert' => 'info'));
	}
}

?>