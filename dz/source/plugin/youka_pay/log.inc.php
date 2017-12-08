<?php
/**
 * 购买记录，供后台查看
 * User: wang
 * Date: 14-10-2
 * Time: 下午2:51
 */
$Plang =  $scriptlang['youka_pay'];
loadcache('plugin');
$my_conf = $_G['cache']['plugin']['youka_pay'];

showtableheader($Plang['log_first_header']);
echo '<tr><td>'.$Plang['admin_log_welcome'].'</td></tr>';
echo '<tr><td>'.$Plang['admin_log_welcome2'].'</td></tr>';
showtablefooter();
showtableheader($Plang['log_second_header']);

if(submitcheck('youkasubmit')){
    //搜索结果展示
    showsubtitle(array(
        $Plang['custom_01'],
        $Plang['custom_02'],
        $Plang['custom_03'],
        $Plang['custom_04'],
        $Plang['custom_041'],
        $Plang['custom_07'],
        $Plang['custom_08'],
        $Plang['custom_05'],
        $Plang['custom_06'],
    ));

    $status = intval($_POST['status']);
    $post_start = strtotime(addslashes($_POST['post_start']));
    $post_end = strtotime(addslashes($_POST['post_end']))+86400;
    $sys_start = strtotime(addslashes($_POST['sys_start']));
    $sys_end = strtotime(addslashes($_POST['sys_end']))+86400;
    //
    $sql = 'select * from '.DB::table('youka_pay_log').' where 1 ';
    if($status==1){
        $sql .= ' and status=0 and channel=1 ';
    }elseif($status==2){
        $sql .= ' and status=1 and channel=1 ';
    }
    if($post_start && $post_end){
        $sql .= ' and post_time between '.$post_start.' and '.$post_end;
    }
    if($sys_start && $sys_end){
        $sql .= ' and completiontime between '.$sys_start.' and '.$sys_end;
    }
    $sql .=' order by post_time desc ';
    $query = DB::query($sql);
    while($rs = DB::fetch($query)){
        $user = getuserbyuid($rs['uid']);
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
        $result[] = $rs;
    }
    foreach($result as $val){
        showtablerow('',array(),array(
            $val['id'],
            $val['username'],
            $val['price'],
            $val['extcredits'],
            $val['show_status'],
            $val['channel_name'],
            $val['credit'],
            $val['show_post_time'],
            $val['show_sys_time'],
        ));
    }
    //echo multi($count, $ppp, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=myrepeats&pmod=admincp$extra");

    showtablefooter();
    die;
}


showformheader('plugins&operation=config&do='.$pluginid.'&identifier=youka_pay&pmod=log');

echo '<script type="text/javascript" src="'.$_G['siteurl'].'static/js/calendar.js"></script>
<tr><td colspan="2" class="td27" s="1">'.$Plang['admin_log_status'].':</td></tr>
<tr class="noborder" ><td class="vtop rowform">
<select name="status">
    <option value="0" selected>'.$Plang['admin_log_status0'].'</option>
    <option value="1" >'.$Plang['admin_log_status1'].'</option>
    <option value="2">'.$Plang['admin_log_status2'].'</option>
    </select>
    </td>
    <td class="vtop tips2" s="1"></td>
    </tr>
<tr><td colspan="2" class="td27" s="1">'.$Plang['admin_log_posttime'].':</td></tr>
<tr class="noborder" ><td class="vtop rowform">
<input type="text" style="width:100px;" name="post_start" value="" onclick="showcalendar(event, this)">
- <input type="text" style="width:100px;" name="post_end" value="" onclick="showcalendar(event, this)">
</td><td class="vtop tips2" s="1"></td></tr>
<tr><td colspan="2" class="td27" s="1">'.$Plang['admin_log_systime'].':</td></tr>
<tr class="noborder" ><td class="vtop rowform">
<input type="text" style="width:100px;" name="sys_start" value="" onclick="showcalendar(event, this)">
- <input type="text" style="width:100px;" name="sys_end" value="" onclick="showcalendar(event, this)">
</td><td class="vtop tips2" s="1"></td></tr>
';


showsubmit('youkasubmit', $Plang['searchsubmit']);

showformfooter();

showtablefooter();