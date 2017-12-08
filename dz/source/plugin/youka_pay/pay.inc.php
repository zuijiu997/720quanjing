<?php
/**
 * Created by PhpStorm.
 * User: youka_pay
 * Date: 14-8-25
 * Time: 下午7:57
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$tablepre = 'cdb_';
//积分数
$price = $_GET['price'];
if(!preg_match('/^[\d\.]*$/',$price)){
    header('Content-Type:text/html; charset=utf-8');
    die("<script>alert('price_error');history.go(-1);</script>");
}
//支付方式
$pay_type = intval($_GET['pay_type']);


//echo $tablepre;die;
loadcache('plugin');
$my_conf = $_G['cache']['plugin']['youka_pay'];

$parter_id = $my_conf['parter_id'];
$parter_sign = $my_conf['parter_sign'];
$ec_mincredits = $my_conf['ec_mincredits'];
$exchangeamount = $price*$ec_mincredits;

$args = array();
$args['parter'] = $parter_id;
$args['type'] = $pay_type;//暂时用支付宝
$args['value'] = $price;//金额
$args['orderid'] = date('Ymd').uniqid();
$args_password = $args;
$args['callbackurl'] = $boardurl.'plugins/youka_pay/callbackurl.php';

$args['hrefbackurl'] = $boardurl.'plugins/youka_pay/hrefbackurl.php';
$args['payerIp'] = $onlineip;
$args['attach'] = 'message';//备注信息
$post_time = time();

$sign = http_build_query($args_password).'&callbackurl='.$args['callbackurl'].$parter_sign;
//echo $sign;die;
$sign = iconv('utf-8','gb2312',$sign);
$args['sign'] = md5($sign);

$pay_url = 'http://gateway.80shop.net/ChargeBank.aspx?'.http_build_query($args);

//数据库插入
$sql = 'insert into '.$tablepre.'youka_pay_log(uid,price,extcredits,orderid,post_time,status,description)values';
$sql .= "({$_G['uid']},'{$args['value']}','{$exchangeamount}','{$args['orderid']}','$post_time',0,'{$args['attach']}')";
$db->query($sql);
//跳转到youka
header('location:'.$pay_url);