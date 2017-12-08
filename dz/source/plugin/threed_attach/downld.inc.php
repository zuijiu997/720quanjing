<?php
/**
 *	[网盘伪装成本地附件(threed_attach.{modulename})] (C)2015-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2015-5-18 12:12
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
function packaids($attach)
{
    global $_G;
    return aidencode($attach['aid'], 0, $_G['tid']);
}

global $_G;
if($_GET['formhash']!=FORMHASH)showmessage(lang('plugin/threed_attach', 'downld2'),  array(), array(), array('alert' => 'error'));
$pan_srl=$_GET['url'];
$pan_srl=base64_decode($pan_srl);
$pan_type=0;
$aid=$_GET['aid'];
if(!$_G['cache']['plugin']['threed_attach']['thd_tiao']||$_GET['mobile']==2){
    DB::query('update '.DB::table('forum_attachment').' set downloads=downloads+1 where aid='.$aid);
    header("location:{$pan_srl}");
	die();
}
if(substr($pan_srl,0,20)=='http://pan.baidu.com'){					
    $pan_type=1;
}elseif(substr($pan_srl,0,20)=='http://dl.vmall.com/'){
    $pan_type=2;
    $pan_srl=str_replace('http://dl.vmall.com/','http://dl.vmall.com/mini_Show_5_0_0.html?id=',$pan_srl);
}elseif(substr($pan_srl,0,16)=='http://yunpan.cn'){
    $pan_type=3;
}elseif(substr($pan_srl,0,17)=='https://yunpan.cn'){
    $pan_type=3;
}else {
    $pan_type=0;
}
$name_arr=explode('.',$_GET['name']);
$pan_srlname=$name_arr[0];
$pan_kofen=$_G['cache']['plugin']['threed_attach']['thd_koufen'];
$pan_user=unserialize($_G['cache']['plugin']['threed_attach']["thd_user"]);
$pan_auth=$_GET[auth];
$navtitle =$pan_srlname.lang('plugin/threed_attach', 'downld1');
$panbox_w=array(0,700,700,700,700,700,700,700);//下载框的长度
$panbox_h=array(0,390,100,400,240,400,400,400);//下载框的高度
$panbox_x=array(0,-30,40,-130,-30,-30,-20,-20);//X方向偏移距离
$panbox_y=array(0,-80,-120,-130,-40,-80,-80,-80);//Y方面偏移距离
$iframe_w=$panbox_w[$pan_type]-$panbox_x[$pan_type];
$iframe_h=$panbox_h[$pan_type]-$panbox_y[$pan_type];

if((!in_array($_G[groupid], $pan_user))&&$pan_kofen&&$pan_auth!=$_G['uid']){
	$user_creditnum=DB::result_first("select extcredits".$_G['setting']['creditstransextra'][1]." from ".DB::table('common_member_count')." where uid=".$_G['uid']);
    $kofen_info='';
	if($user_creditnum<$pan_kofen){
	showmessage($_G['cache']['plugin']['threed_attach']['thd_credit'],  array(), array(), array('alert' => 'info'));
	}
	$buy_credit = $_G['setting']['creditstransextra'][1];
	$buy_creditname = $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'];
	DB::query('update '.DB::table('common_member_count').' set extcredits'.$buy_credit.'=extcredits'.$buy_credit.'-'.$pan_kofen.' where uid='.$_G['uid']);
	$kofen_info =$buy_creditname.'-'.$pan_kofen;
	$kofen_info.=','.$_G['cache']['plugin']['threed_attach']['thd_downld'];
}else{
	$kofen_info=$_G['cache']['plugin']['threed_attach']['thd_downld'];
}
DB::query('update '.DB::table('forum_attachment').' set downloads=downloads+1 where aid='.$aid);
include template('diy:downld', 0, 'source/plugin/threed_attach/template');
//TODO - Insert your code here
?>