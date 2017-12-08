<?php
/**
 * 积分兑换
 * User: youka_pay
 * Date: 14-8-26
 * Time: 下午9:07
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}


loadcache('plugin');
$my_conf = $_G['cache']['plugin']['youka_pay'];
//
//echo $my_conf['credit_type'];die;
if(empty($my_conf['credit_type'])){
    showmessage('youka_pay:alert_credit_isnull', 'home.php?mod=spacecp&ac=credit');
}

$ec_ratio = $my_conf['ec_ratio'];
$ec_mincredits = $my_conf['ec_mincredits'];
$ec_maxcredits = $my_conf['ec_maxcredits'];
$parter_id = $my_conf['parter_id'];
$parter_sign = $my_conf['parter_sign'];
$api_type = unserialize($my_conf['api_type']);
$pay_bank = unserialize($my_conf['pay_bank']);
$card_types = unserialize($my_conf['card_type']);
$language = lang('youka_pay:pay_type_963');
//print_r($language);
$pay_banks = array();
foreach($pay_bank as $b){
    $data = array();
    $data['id'] = $b;
    $data['lang'] = $language['pay_type_'.$b];
    $pay_banks[] = $data;
}
$card_types_show = array();
foreach($card_types as $c){
    $data = array();
    $data['id'] = $c;
    $data['lang'] = $language['card_type_'.$c];
    $card_types_show[] = $data;
}
//print_r($card_types_show);


if(submitcheck('addfundssubmit')) {
    //网上银行
    $pay_type = intval($_POST['pay_type']);
    if($pay_type ==0)
        showmessage('memcp_credits_addfunds_msg_notype', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    $amount = intval($_GET['addfundamount']);
    if(!$amount) {
        showmessage('memcp_credits_addfunds_msg_incorrect', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }
    $language = lang('forum/misc');
    if($ec_mincredits && $amount < $ec_mincredits) {
        showmessage('youka_pay:credits_addfunds_amount_invalid_p', '', array('ec_mincredits' => $ec_mincredits), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }
    if($ec_maxcredits && $amount > $ec_maxcredits) {
        showmessage('youka_pay:credits_addfunds_amount_invalid_pp', '', array('ec_maxcredits' => $ec_maxcredits), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }

    if($_G['setting']['ec_maxcreditspermonth']) {
        if(C::t('forum_order')->sum_amount_by_uid_submitdate_status($_G['uid'], $_G['timestamp'] - 2592000, array(2, 3)) + $amount > $_G['setting']['ec_maxcreditspermonth']) {
            showmessage('credits_addfunds_toomuch', '', array('ec_maxcreditspermonth' => $_G['setting']['ec_maxcreditspermonth']), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
        }
    }

    $price = round(($amount / $ec_ratio * 100) / 100, 2);

    $args = array();
    $args['parter'] = $parter_id;
    $args['type'] = $pay_type;//暂时用支付宝
    $args['value'] = $price;//金额
    $args['orderid'] = date('Ymd').uniqid();
    $args_password = $args;
    $args['callbackurl'] = $_G['siteurl'].'source/plugin/youka_pay/callbackurl.php';

    $args['hrefbackurl'] = $_G['siteurl'].'source/plugin/youka_pay/hrefbackurl.php';
    $args['payerIp'] = $onlineip;
    $args['attach'] = 'DZ';//备注信息
    $post_time = time();

    $sign = http_build_query($args_password).'&callbackurl='.$args['callbackurl'].$parter_sign;
//echo $sign;die;
    $sign = iconv('utf-8','gb2312',$sign);
    $args['sign'] = md5($sign);


    $sql = 'insert into '.DB::table('youka_pay_log').'(uid,price,extcredits,orderid,post_time,status,description,channel,credit_type)values';
    $sql .= "({$_G['uid']},'{$args['value']}','{$amount}','{$args['orderid']}','$post_time',0,'{$args['attach']}',1,{$my_conf['credit_type']})";
    DB::query($sql);
//die;
    $pay_url = 'http://gateway.80shop.net/ChargeBank.aspx?'.http_build_query($args);
    //dheader('location: '.$pay_url);dexit();

    include template('common/header_ajax');
    echo '<form id="payform" action="'.$pay_url.'" method="post"></form>';
    echo '<script type="text/javascript" reload="1">$(\'payform\').submit();</script>';
    include template('common/footer_ajax');
    dexit();
}
//card_submit_chuli
if(submitcheck('card_form')) {
    //点卡支付
    $card_type = intval($_POST['card_type']);
    if($card_type ==0)
        showmessage('youka_pay:card_type_requestd', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    $card_value = intval($_GET['card_value']);
    if(!$card_value) {
        showmessage('youka_pay:card_value_requestd', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }
    $cardno = trim($_GET['cardno']);
    if(!$cardno) {
        showmessage('youka_pay:cardno_requestd', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }
    $cardpwd = trim($_GET['cardpwd']);
    if(!$cardpwd) {
        showmessage('youka_pay:cardpwd_requestd', '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
    }

    $price = round(($amount / $ec_ratio * 100) / 100, 2);

    $args = array();

    $args['type'] = $card_type;
    $args['parter'] = $parter_id;
    $args['cardno'] = $cardno;
    $args['cardpwd'] = $cardpwd;
    $args['value'] = $card_value;//want to chongzhi money
    $args['restrict'] = 0;
    $args['orderid'] = date('Ymd').uniqid();
    $args_password = $args;
    $args['callbackurl'] = $_G['siteurl'].'source/plugin/youka_pay/card_callbackurl.php';


    //$args['payerIp'] = $onlineip;
    $args['attach'] = 'DZ';//备注信息
    $post_time = time();

    $sign = http_build_query($args_password).'&callbackurl='.$args['callbackurl'].$parter_sign;
//echo $sign;die;
    $sign = iconv('utf-8','gb2312',$sign);
    $args['sign'] = md5($sign);




    $pay_url = 'http://gateway.80shop.net/cardreceive.ashx';
    //echo $pay_url;
    $con =  http($pay_url,$args);

    if(strpos($con,'opstate=')!==false){
        $status = str_replace('opstate=','',$con);
        $success_status = array(0,1,11);
        if(!in_array($status,$success_status)){
            showmessage('youka_pay:status_'.$status, '', array(), array('showdialog' => 1, 'showmsg' => true, 'closetime' => true));
        }else{
            $sql = 'insert into '.DB::table('youka_pay_log').'(uid,price,extcredits,orderid,post_time,status,description,channel,credit_type)values';
            $sql .= "({$_G['uid']},'{$card_value}','0','{$args['orderid']}','$post_time',0,'{$args['attach']}',2,{$my_conf['credit_type']})";
            DB::query($sql);
            dheader('location: '.$_G['siteurl'].'home.php?mod=spacecp&ac=plugin&op=credit&id=youka_pay:exchange&orderid='.$args['orderid']);
            //showmessage('youka_pay:card_payonline_succeed', 'home.php?mod=spacecp&ac=credit');
        }
    }

    dexit();
}
$get_orderid = trim($_GET['orderid']);
if($get_orderid){
    $has_c = false;
    if(class_exists('C') && method_exists('C','app')){
        $has_c = true;
    }

    if($has_c){
        $order = C::t('#youka_pay#youka_pay_log')->fetch_by_orderid($get_orderid);
    }else{
        $order = DB::fetch_first("SELECT * FROM ".DB::table('youka_pay_log')." WHERE orderid='$get_orderid'");
    }
    //print_r($order);
    $order['posttime'] = date('Y-m-d H:i:s',$order['post_time']);
    $status = $order['status']==1?$language['success']:$language['waite'];
    //print_r($order);
    //echo $order['status'];
    if($order['status']>1) $status = $language['status_'.$order['status']];

    if($order['status']==1){
        showmessage('youka_pay:status_0', 'home.php?mod=spacecp&ac=credit');
    }
}

function http($url, $params, $method = 'GET', $header = array(), $multi = false,$other_args = array()){

    $opts = array(
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER		=>$header,
    );
    //$return_header && $opts[CURLOPT_HEADER] = 1;
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? ($params) : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            die;
    }
    if($multi){
        $opts[CURLOPT_HTTPHEADER] = "Content-Type: multipart/form-data; boundary=" . $boundary;
    }

    /* 初始化并执行curl请求 */
    $ch = curl_init();
    $other_args && $opts = $opts + $other_args;
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) die($error);
    return  $data;
}
