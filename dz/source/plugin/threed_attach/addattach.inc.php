<?php
/**
 *	[网盘伪装成本地附件(threed_attach.{modulename})] (C)2015-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2015-5-18 12:12
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
define('NOROBOT', true);
global $_G;
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pramga: no-cache");
if($_GET['formhash']!=FORMHASH)exit();
$uid = $_G['uid'];
if($_GET['ac']=="add"){
    $pan_url = addslashes(trim($_GET['url']));
    $pan_name=addslashes(trim($_GET['name']));
    $pan_price=addslashes(trim($_GET['price']));
    $tid = intval($_GET['tid']);
    if (!empty($pan_name)) {
        //$table=getattachtablebytid($tid);
        $attach_setting = array('uid' => $uid, 'tableid' => 127);
        $aid = DB::insert("forum_attachment", $attach_setting, true);
        $attach_unused = array(
        'aid' => $aid,
        'uid' => $uid,
        'dateline' => time(),
        'filename' => $pan_name.".pan",
        'filesize' => '1', //默认为1000
        'attachment' => $pan_url
      );
    $unused_result = DB::insert("forum_attachment_unused", $attach_unused, true);
      $_G['attachnew'][$aid] = array(
      'description' => $pan_name,        
      'readperm' => $_GET['readaccess'],       
      'price' => $pan_price);
    }
	if(is_int($aid))echo $aid;
exit();
}
if($_GET['ac']=="update"){
    $pan_url = addslashes(trim($_GET['url']));
    $pan_name=addslashes(trim($_GET['name']));
    $aid=intval($_GET['aid']);
    if (!empty($pan_name)) {
        $tableid=DB::result_first('SELECT tableid FROM '.DB::table('forum_attachment').' WHERE aid='.$aid);
        if($tableid==127)$tableid='unused';
        $attach_unused = array(
        'filename' => $pan_name.".pan",
        'attachment' => $pan_url
      );
    $unused_result = DB::update('forum_attachment_'.$tableid, $attach_unused,array('aid'=>$aid));
    //DB::query('update '.DB::table('forum_attachment_'.$tableid).' set filename='.$pan_name.'pan attachment='.$pan_url.' where aid='.$aid);
      $_G['attachnew'][$aid] = array(
      'description' => $pan_name);
    }
	echo $aid;
exit();
}
?>