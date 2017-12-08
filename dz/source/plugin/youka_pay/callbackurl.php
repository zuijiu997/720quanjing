<?php
/**
 * Created by PhpStorm.
 * User: youka_pay
 * Date: 14-8-25
 * Time: ÏÂÎç8:54
 */
require '../../class/class_core.php';
require '../../function/function_forum.php';

$has_c = false;
if(class_exists('C') && method_exists('C','app')){
    $discuz = C::app();
    $discuz->init();
    $has_c = true;
}elseif(class_exists('discuz_core')){
    $discuz = & discuz_core::instance();
    $discuz->init();

}else{
    die();
}

$PHP_SELF = $_SERVER['PHP_SELF'];

$_G['siteurl'] = dhtmlspecialchars('http://'.$_SERVER['HTTP_HOST'].str_replace('source/plugin/youka_pay/hrefbackurl.php','',$PHP_SELF));

loadcache('plugin');
$my_conf = $_G['cache']['plugin']['youka_pay'];
$parter_id = $my_conf['parter_id'];
$parter_sign = $my_conf['parter_sign'];
//print_r($_GET);
$orderid = addslashes(strip_tags($_GET['orderid']));
$opstate = $_GET['opstate'];
$ovalue = $_GET['ovalue'];
$sign = $_GET['sign'];
$sysorderid = addslashes(strip_tags($_GET['sysorderid']));
$completiontime = addslashes($_GET['systime']);
$completiontime = strtotime($completiontime);
$attach = $_GET['attach'];
$msg = $_GET['msg'];
//print_r($_GET);
$md5 = "orderid=$orderid&opstate=$opstate&ovalue=$ovalue$parter_sign";

if(md5($md5) != $sign){
    die('opstate=0');
}

if($has_c){
    $order = C::t('#youka_pay#youka_pay_log')->fetch_by_orderid($orderid);
}else{
    $order = DB::fetch_first("SELECT * FROM ".DB::table('youka_pay_log')." WHERE orderid='$orderid'");
}

if($order['status']==0 && floatval($ovalue) == floatval($order['price'])){
    if($has_c)
        C::t('#youka_pay#youka_pay_log')->update_by_orderid($orderid,$sysorderid,$completiontime);
    else{
        DB::query("update ".DB::table('youka_pay_log')." set status=1,sysorderid='".$sysorderid."',completiontime='".$completiontime."' WHERE orderid='$orderid' limit 1");
    }
    updatemembercount($order['uid'], array($order['credit_type'] => $order['extcredits']), 1, 'AFD', $order['uid']);
}
die('opstate=0');
