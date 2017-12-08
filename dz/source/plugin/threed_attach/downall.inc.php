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
if($_GET['formhash']!=FORMHASH)showmessage(lang('plugin/threed_attach', 'downld2'),  array(), array(), array('alert' => 'error'));
require_once libfile('function/discuzcode');
function packaids($attach)
{
    global $_G;
    return aidencode($attach['aid'], 0, $_G['tid']);
}
    $pid=dintval($_GET['pid']);
    $uid=$_G['uid'];
    $tableid = DB::result_first("SELECT tableid FROM " . DB::table('forum_attachment') .
        " WHERE pid='$pid' LIMIT 1");
    $tableid = $tableid >= 0 && $tableid < 10 ? intval($tableid) : 127;
    $table = "forum_attachment_" . $tableid;
    $attachlist=DB::fetch_all("SELECT * FROM " . DB::table($table) . " WHERE pid=" . $pid .
        " and isimage<>1 ORDER BY aid asc ");
foreach($attachlist as $kaid=>$attach){
    $filename = $attach['filename'];
    $ext_a = explode(".", $filename);
    $num = count($ext_a) - 1;
    $ext = trim($ext_a[$num]);
    $attachlist[$kaid][downloads]=DB::result_first("SELECT downloads FROM " . DB::table('forum_attachment') .
    " WHERE aid=$attach[aid]");
    $payed = DB::result_first("SELECT count(*) FROM " . DB::table('common_credit_log') .
        " WHERE relatedid='$attach[aid]' AND  uid='$uid' AND operation='BAC'");
    $aidencode = packaids($attach);
    if (!$attach['price'] || $payed || $attach[uid] == $uid) {
        if ($ext == "pan" && $_G[group][readaccess] >= $attach[readperm]) {
            if(substr($attach[attachment],0,20)=='http://pan.baidu.com'){
                $attachlist[$kaid][type]=1;
            }elseif(substr($attach[attachment],0,20)=='http://dl.vmall.com/'){
                $attachlist[$kaid][type]=2;
            }elseif(substr($attach[attachment],0,16)=='http://yunpan.cn'){
                $attachlist[$kaid][type]=3;
            }elseif(substr($attach[attachment],0,17)=='https://yunpan.cn'){
                $attachlist[$kaid][type]=3;
            }else {
                 $attachlist[$kaid][type]=0;//其它的
            }
            if ($_G['cache']['plugin']['threed_attach']['thd_tiao']) {
                $attachlist[$kaid][url] = "window.open('plugin.php?id=threed_attach:downld&aid=$attach[aid]&url=" . base64_encode($attach[attachment]) . "&name=$ext_a[0]&auth=$attach[uid]&formhash=" . FORMHASH."')";
                $attachlist[$kaid][filename] = $ext_a[0];
                } else {
                $attachlist[$kaid][url] = "window.open('$attach[attachment]')";
                $attachlist[$kaid][filename] = $ext_a[0];                                        
                    }                    
        } else {
                $attachlist[$kaid][url] = "window.open('forum.php?mod=attachment$is_archive&aid=$aidencode')";
                $attachlist[$kaid][filename] = $attach['filename'];
                $attachlist[$kaid][type]=4;//站内下载
        }
    } else {
    $attachlist[$kaid][url] = "showWindow('attachpay','forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]');";
    $attachlist[$kaid][filename] = $attach['filename'];
    $attachlist[$kaid][type]=5;//付钱的
    }
    
}
$button_info=array(lang('plugin/threed_attach', 'downall1'),lang('plugin/threed_attach', 'downall2'),lang('plugin/threed_attach', 'downall3'),lang('plugin/threed_attach', 'downall4'),lang('plugin/threed_attach', 'downall5'),lang('plugin/threed_attach', 'downall6'));
print_r($_G['cache']['usergroups']);
$navtitle = lang('plugin/threed_attach', 'downld1') . ' - '. $_G[setting][bbname];
include template('diy:downall', 0, 'source/plugin/threed_attach/template');
//TODO - Insert your code here
?>