<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class plugin_youka_pay{

    function global_usernav_extra2(){
        global $_G;
        $my_conf = $_G['cache']['plugin']['youka_pay'];
        if($my_conf['header_open']!=1)return '';
        $language = lang('youka_pay:pay_type_963');
        $url = 'home.php?mod=spacecp&ac=plugin&op=credit&id=youka_pay:exchange';
        return '<a href="'.$url.'"><strong style="color:red">'.$language['global_usernav_extra2_test'].'</strong></a>';
    }

}
class plugin_youka_pay_forum extends plugin_youka_pay{

    function index_nav_extra(){
        global $_G;
        $Plang = lang('youka_pay:pay_type_963');
        $my_conf = $_G['cache']['plugin']['youka_pay'];
        if($my_conf['index_mes_open']!=1)return '';
        $index_mes_html = $my_conf['index_mes_html'];

        $rs = DB::fetch_first('select * from '.DB::table('youka_pay_log').' order by id desc limit 1');
        if(empty($rs))return '';
        $user = getuserbyuid($rs['uid']);
        //print_r($user);
        $rs['username'] = $user['username'];
        $rs['credit'] = $_G['setting'][extcredits][$rs['credit_type']][title];
        $rs['show_post_time'] = date('Y-m-d H:i:s',$rs['post_time']);
        $rs['show_sys_time'] = $rs['completiontime']?date('Y-m-d H:i:s',$rs['completiontime']):'';
        $rs['channel_name'] = $rs['channel']==1?$Plang['select_bank']:$Plang['select_card'];
        if($rs['channel']==1)
            $rs['show_status'] = $rs['status']==0?$Plang['show_status_1_0']:$Plang['show_status_1_1'];
        else{
            $rs['show_status'] = $Plang['status_'.$rs['status']];
        }
        $index_mes_html = str_replace('{username}',$rs['username'],$index_mes_html);
        $index_mes_html = str_replace('{credit}',$rs['credit'],$index_mes_html);
        $index_mes_html = str_replace('{show_post_time}',$rs['show_post_time'],$index_mes_html);
        $index_mes_html = str_replace('{show_sys_time}',$rs['show_sys_time'],$index_mes_html);
        $index_mes_html = str_replace('{channel_name}',$rs['channel_name'],$index_mes_html);
        $index_mes_html = str_replace('{show_status}',$rs['show_status'],$index_mes_html);
        $index_mes_html = str_replace('{price}',$rs['price'],$index_mes_html);
        $index_mes_html = str_replace('{extcredits}',$rs['extcredits'],$index_mes_html);
        return $index_mes_html;
    }

}
