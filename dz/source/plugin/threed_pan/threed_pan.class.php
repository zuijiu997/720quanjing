<?php
/**
 *	[网盘虚拟附件--免跳转下载(threed_pan.{modulename})] (C)2014-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2014-12-3 21:54
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class plugin_threed_pan
{
    //TODO - Insert your code here
}

class plugin_threed_pan_portal extends plugin_threed_pan
{
    function view_article_content()
    {
        //echo "我执行了1";
        global $_G;
        
        $pan_option = $_G['cache']['plugin']['threed_pan'];
        $pan_portal = $pan_option["thd_portal"];
        if(!$pan_portal){
            return;
        }
        $pan_user = $pan_option["thd_user"];
        $pan_other = $pan_option["thd_other"];
        $pan_name = $pan_option['thd_name'];
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
        $aid=intval($_GET['aid']);
        $portal = DB::fetch_first("SELECT fromurl,author,uid FROM " . DB::table('portal_article_title') .
            " WHERE aid='$aid' LIMIT 1");
            //print_r($portal);
        $pan_srltemp = explode("|", $portal['fromurl']);
        $pan_srljiage=$pan_yuanjia  = $pan_srltemp[1] ? intval($pan_srltemp[1]) : 0;
        $pan_srl = $pan_srltemp[0];
        
        if(!$pan_srl)return;
        $pan_srlname =$portal['author'];
        $pan_type = 0;
        if (substr($pan_srl, 0, 20) == 'http://pan.baidu.com') {
            $pan_type = 1;
        } elseif (substr($pan_srl, 0, 23) == 'http://share.weiyun.com') {
            $pan_type = 2;
        } elseif (substr($pan_srl, 0, 16) == 'http://yunpan.cn') {
            $pan_type = 3;
        } elseif (substr($pan_srl, 0, 16) == 'https://yunpan.cn') {
            $pan_type = 3;
        
        } elseif (substr($pan_srl, 0, 24) == 'doc=http://pan.baidu.com') {
            $pan_type = 4;
            $pan_srl = substr($pan_srl, 4);
        } elseif (substr($pan_srl, 0, 18) == 'http://qiannao.com') {
            $pan_type = 5;
        } elseif (substr($pan_srl, 0, 22) == 'http://kuai.xunlei.com') {
            $pan_type = 6;
        } else {
            $pan_type = 0;
        }
        $tid=0-$aid;
        $buycount = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
            ' WHERE buy_tid=' . $tid . ' and buy_uid =' . $_G['uid']);
        $allcount = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
            ' WHERE buy_tid=' . $tid);
        
        foreach ($pan_zhekougroupid as $listk => $listv) {
            if ($_G[groupid] == $listv) {
                $pan_srljiage = intval($pan_zhekou[$listk] * $pan_yuanjia / 10);
                $pan_downnum = $pan_zhekoudownum[$listk];
            }
        }

        if ( $portal['uid'] == $_G['uid'] || $buycount >0 || !$pan_srljiage) {
            $pan_url = $pan_type . '|' . $pan_srl;
            $pan_url = base64_encode($pan_url);
            $pan_url = 'plugin.php?id=threed_pan:downld&url=' . $pan_url . '&tid=' . $tid .
                '&name=' . $pan_srlname . '&formhash=' . FORMHASH;
            $ifbuy = 1;

        } else {

            $pan_srlgg = ($pan_srljiage + 3) * 91 + 131; //简单加密
            $pan_url = 'plugin.php?id=threed_pan:payfor&ac=buy&tid=' .$tid . '&gg=' .
                $pan_srlgg . '&formhash=' . FORMHASH;
            $ifbuy = 0;

        }
        include template('threed_pan:attach');
        $replace = show_pan_attach($ifbuy, $pan_url, $pan_srlname, $pan_srljiage, $allcount,
            $pan_type, $pan_srl,$pan_yuanjia);
            //echo "我执行了4";
            return $replace;
    }
    
    function portalcp_extend(){
        global $_G;
       $pan_portal= $_G['cache']['plugin']['threed_pan']['thd_portal'];
        if($pan_portal){
            return '<div class="sadd z"  style="font-size:14px;"><font color="#f00">'.lang('plugin/threed_pan', 'index1').'</font></div>';
        }else{
        return;
    }
    }

}


class plugin_threed_pan_forum extends plugin_threed_pan
{
    function post_editorctrl_left()
    {
        global $_G;
        $pan_fauser = unserialize($_G['cache']['plugin']['threed_pan']["thd_fauser"]);
        if (!$_G['cache']['plugin']['threed_pan']['thd_tabopen'])
            return;
        $pan_doc = $_G['cache']['plugin']['threed_pan']["thd_doc"];
        if (!in_array($_G[groupid], $pan_fauser))
            return;
        $load_url = 'plugin.php?id=threed_pan:load';
        $str = '<a id="a_mg_vdisk" style="background:url(source/plugin/threed_pan/template/ico.png) no-repeat scroll 0% 0% transparent;" title="' .
            lang('plugin/threed_pan', 'downld9') .
            '" href="javascript:;" onClick="showWindow(\'loadbox\', \'' . $load_url . '\')">' .
            lang('plugin/threed_pan', 'downld9') . '</a>';
        if ($pan_doc)
            $str = $str . '<a id="a_mg_doc" style="background:url(source/plugin/threed_pan/template/doc.png) no-repeat scroll 0% 0% transparent;" title="' .
                lang('plugin/threed_pan', 'downld11') .
                '" href="javascript:;" onClick="showWindow(\'loadbox\', \'' .
                'plugin.php?id=threed_pan:loaddoc' . '\')">' . lang('plugin/threed_pan',
                'downld11') . '</a>';
        return $str;
    }
    function post_top()
    {
        global $_G;
        $pan_forums = unserialize($_G['cache']['plugin']['threed_pan']["thd_forum"]);
        if (in_array($_G['fid'], $pan_forums))
            return $_G['cache']['plugin']['threed_pan']['pan_editinfo'];
    }

    function viewthread_posttop_output()
    {
        global $_G, $postlist, $post;
        $pan_option = $_G['cache']['plugin']['threed_pan'];
        $pan_forums = unserialize($pan_option["thd_forum"]);
        $pan_user = $pan_option["thd_user"];
        $pan_other = $pan_option["thd_other"];
        $pan_name = $pan_option['thd_name'];
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


        foreach ($postlist as $id => $post) {
            //print_r($post['attachments']);
            if ((!in_array($_G['fid'], $pan_forums)) || !$post['first']) {
                break;
            }
            $pan_message = $post['message'];
            $pan_tab1 = '<a href="';
            $pan_tab2 = '" target="_blank">';
            $pan_tab3 = '</a>';
            if ($pan_option["thd_tabopen"]) {
                $pan_message = $post['message'];
                $pan_tab1 = "[pan=";
                $pan_tab2 = "]";
                $pan_tab3 = "[/pan]";
            }


            $trmp1_arr = explode($pan_tab1, $pan_message);

            if (count($trmp1_arr) > 1) {

                $n = 1;
                include template('threed_pan:attach');
                foreach ($trmp1_arr as $key => $trmp1_arrstr) {

                    if ($n == 1) {
                        $pan_message = $trmp1_arrstr;
                        $n++;

                        continue;
                    } else {
                        $tmpmessage .= $pan_tab1 . $trmp1_arrstr;

                    }
                    $n = $n + 1;
                    $trmp2_arr = explode($pan_tab3, $trmp1_arrstr);

                    if (count($trmp2_arr) > 1) {
                        $trmp3_arr = explode($pan_tab2, $trmp2_arr[0]);
                        $pan_srl = $trmp3_arr[0];
                        $pan_srltemp = explode("|", $trmp3_arr[1]);
                        $pan_yuanjia = 0;
                        if (count($pan_srltemp) > 1)
                            $pan_srljiage=$pan_yuanjia = intval($pan_srltemp[1]);
                        $pan_srlname = $pan_srltemp[0];
                        $pan_type = 0;
                        if (substr($pan_srl, 0, 20) == 'http://pan.baidu.com') {
                            $pan_type = 1;
                        } elseif (substr($pan_srl, 0, 23) == 'http://share.weiyun.com') {
                            $pan_type = 2;
                        } elseif (substr($pan_srl, 0, 16) == 'http://yunpan.cn') {
                            $pan_type = 3;
                        } elseif (substr($pan_srl, 0, 24) == 'doc=http://pan.baidu.com') {
                            $pan_type = 4;
                            $pan_srl = substr($pan_srl, 4);
                        } elseif (substr($pan_srl, 0, 18) == 'http://qiannao.com') {
                            $pan_type = 5;
                        } elseif (substr($pan_srl, 0, 22) == 'http://kuai.xunlei.com') {
                            $pan_type = 6;
                        } else {
                            $pan_type = 0;
                        }

                        if ($pan_type == 0 && $pan_other == 0) {
                            if ($pan_option["thd_tabopen"])
                                $tmpmessage .= '<font color="#F00">' . lang('plugin/threed_pan', 'downld6') .
                                    '</font>';
                            continue;
                        }
                        $buycount = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
                            ' WHERE buy_tid=' . $_G[tid] . ' and buy_uid = ' . $_G['uid']);
                        $allcount = DB::result_first('SELECT count(1) FROM ' . DB::table('threed_pan') .
                            ' WHERE buy_tid=' . $_G[tid]);

                        foreach ($pan_zhekougroupid as $listk => $listv) {
                            if ($_G[groupid] == $listv) {
                                $pan_srljiage = intval($pan_zhekou[$listk] * $pan_yuanjia / 10);
                                $pan_downnum = $pan_zhekoudownum[$listk];
                            }
                        }
                        

                        if ( $post[authorid] == $_G['uid'] || $buycount >0 || !$pan_srljiage) {
                            $pan_url = $pan_type . '|' . $pan_srl;
                            $pan_url = base64_encode($pan_url);
                            $pan_url = 'plugin.php?id=threed_pan:downld&url=' . $pan_url . '&tid=' . $_G['tid'] .
                                '&name=' . $pan_srlname . '&formhash=' . FORMHASH;
                            $ifbuy = 1;

                        } else {

                            $pan_srlgg = ($pan_srljiage + 3) * 91 + 131; //简单加密
                            $pan_url = 'plugin.php?id=threed_pan:payfor&ac=buy&tid=' . $_G['tid'] . '&gg=' .
                                $pan_srlgg . '&formhash=' . FORMHASH;
                            $ifbuy = 0;

                        }
                        $replace = show_pan_attach($ifbuy, $pan_url, $pan_srlname, $pan_srljiage, $allcount,
                            $pan_type, $pan_srl,$pan_yuanjia);

                        $tmpmessage = str_replace($pan_tab1 . $trmp2_arr[0] . $pan_tab3, $replace, $tmpmessage);

                    }

                }
                $post['message'] = $pan_message . $tmpmessage;
                $postlist[$id] = $post;

            }

        }

    }
}

?>