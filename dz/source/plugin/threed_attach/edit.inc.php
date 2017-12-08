<?php
/**
 *	[网盘伪装成本地附件(threed_attach.{modulename})] (C)2015-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2015-5-18 12:12
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
    $aid=intval($_GET['aid']);
    //echo($aid);
    $tableid=DB::result_first('SELECT tableid FROM '.DB::table('forum_attachment').' WHERE aid='.$aid);
    if($tableid==127)$tableid='unused';
    //echo $tableid;
    $edit_arr=DB::fetch(DB::query('SELECT filename,attachment FROM '.DB::table('forum_attachment_'.$tableid).' WHERE aid='.$aid));
    //print_r($edit_arr);
    $edit_arr['filename']=chop($edit_arr['filename'],'.pan');
    include template('threed_attach:edit');

//TODO - Insert your code here
?>