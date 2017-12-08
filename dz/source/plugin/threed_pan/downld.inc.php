<?php
/**
 *	[网盘虚拟附件--免跳转下载(threed_pan.{modulename})] (C)2014-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2014-12-3 21:54
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
global $_G;
$urlinfo = $_GET['url'];
$urlinfo = base64_decode($urlinfo);
$urlinfo = explode("|", $urlinfo);
$pan_srl = $urlinfo[1];
$pan_type = $urlinfo[0];
$tid = intval($_GET['tid']);
$aid=0-$tid;
$buycount = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
    ' WHERE buy_tid=' . $tid . ' and buy_uid = ' . $_G['uid']);
$pan_srlname = $_GET['name'];
$pan_kofen = intval($_G['cache']['plugin']['threed_pan']['thd_koufen']);
$pan_user = $_G['cache']['plugin']['threed_pan']["thd_user"];
$pan_buyuser = unserialize($_G['cache']['plugin']['threed_pan']["thd_buyuser"]);
$pan_zhekou = array();
$pan_zhekougroupid = array();
$pan_zhekoudownnum = array();
$pan_zheokou_temp = explode(",", $pan_user);
foreach ($pan_zheokou_temp as $listk => $listv) {
    $listv_temp = explode("|", $listv);
    $pan_zhekou[] = $listv_temp[1];
    $pan_zhekougroupid[] = $listv_temp[0];
    $pan_zhekoudownum[] = $listv_temp[2];
}
$pan_auth = $tid > 0 ? DB::result_first("SELECT authorid FROM " . DB::table('forum_thread') .
    " WHERE tid=" . $tid) : DB::result_first("SELECT uid FROM " . DB::table('portal_article_title') .
    " WHERE aid='" . $aid . "' LIMIT 1");
$navtitle = $pan_srlname . lang('plugin/threed_pan', 'downld1');
$panbox_w = array(
    0,
    700,
    700,
    700,
    700,
    700,
    700,
    700); //下载框的长度
$panbox_h = array(
    0,
    390,
    100,
    400,
    240,
    400,
    400,
    400); //下载框的高度
$panbox_x = array(
    0,
    -30,
    40,
    -130,
    -30,
    -30,
    -20,
    -20); //X方向偏移距离
$panbox_y = array(
    0,
    -80,
    -120,
    -130,
    -40,
    -80,
    -80,
    -80); //Y方面偏移距离
$iframe_w = $panbox_w[$pan_type] - $panbox_x[$pan_type];
$iframe_h = $panbox_h[$pan_type] - $panbox_y[$pan_type];

if ($_GET['formhash'] != FORMHASH)
    showmessage(lang('plugin/threed_pan', 'downld2'), array(), array(), array('alert' =>
            'error'));
if (!in_array($_G['groupid'], $pan_buyuser))
    showmessage($_G['cache']['plugin']['threed_pan']['thd_power'], '', array(),
        array('alert' => 'info'));
foreach ($pan_zhekougroupid as $listk => $listv) {
    if ($_G[groupid] == $listv) {
        $pan_srljiage = intval($pan_zhekou[$listk] * $pan_yuanjia / 10);
        $pan_downnum = $pan_zhekoudownum[$listk];
        $pan_kofen = intval($pan_zhekou[$listk] * $pan_kofen / 10);
    }
}
$daytimenow = $_G['timestamp'];
$daytimeup = $_G['timestamp'] + 43200;
$daytimedown = $_G['timestamp'] - 43200;
$daydownnum = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
    ' WHERE buy_uid = ' . $_G['uid'] . ' and buy_time between ' . $daytimedown .
    ' and ' . $daytimeup);
if ($pan_downnum && $daydownnum >=$pan_downnum) {
    showmessage(lang('plugin/threed_pan', 'index2'). $pan_downnum, array(), array(),
        array('alert' => 'error'));
}
if ($pan_downnum)
    $kofen_info .= lang('plugin/threed_pan', 'index3').$pan_downnum.lang('plugin/threed_pan', 'index4').$daydownnum ;
else
    $kofen_info = "";
if ($pan_kofen && $buycount == 0 && $pan_auth != $_G['uid']) {
    $user_creditnum = DB::result_first("select extcredits" . $_G['setting']['creditstransextra'][1] .
        " from " . DB::table('common_member_count') . " where uid=" . $_G['uid']);
    if ($user_creditnum < $pan_kofen) {
        showmessage($_G['cache']['plugin']['threed_pan']['thd_credit'], array(), array(),
            array('alert' => 'info'));
    }
    $buy_credit = $_G['setting']['creditstransextra'][1];
    $buy_creditname = $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title'];

    $svaebuy = array(
        'buy_uid' => $_G['uid'],
        'buy_tid' => $tid,
        'buy_info' => lang('plugin/threed_pan', 'downld7') . $pan_kofen . $buy_creditname,
        'buy_time' => $_G['timestamp']);
    $id = C::t('#threed_pan#threed_pan')->insert($svaebuy, true);
    if ($id) {
        DB::query('update ' . DB::table('common_member_count') . ' set extcredits' . $buy_credit .
            '=extcredits' . $buy_credit . '-' . $pan_kofen . ' where uid=' . $_G['uid']);
        $kofen_info .= $buy_creditname . '-' . $pan_kofen;
        $kofen_info .= ',' . $_G['cache']['plugin']['threed_pan']['thd_downld'];
    } else {
        showmessage(lang('plugin/threed_pan', 'downld2'), array(), array(), array('alert' =>
                'error'));
    }
} else {
    if (!$buycount) {
        $svaebuy = array(
            'buy_uid' => $_G['uid'],
            'buy_tid' => $tid,
            'buy_info' => lang('plugin/threed_pan', 'index5'),
            'buy_time' => $_G['timestamp']);
        $id = C::t('#threed_pan#threed_pan')->insert($svaebuy, true);
    }
    $kofen_info .= $_G['cache']['plugin']['threed_pan']['thd_downld'];
}
if (!$_G['cache']['plugin']['threed_pan']['thd_tiao']) {
    //DB::query('update '.DB::table('forum_attachment').' set downloads=downloads+1 where aid='.$aid);
    header("location:$pan_srl");
    die();
} else {
    include template('diy:downld', 0, 'source/plugin/threed_pan/template');
}
//TODO - Insert your code here


?>