<?php

/**
 *	[积分购买视频教程(threed_ckplayer.{modulename})] (C)2014-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2014-12-3 21:54
 */

if (!defined('IN_DISCUZ')) {
    exit('');
}

function make_request($url, $params , $timeout =30){
    set_time_limit(0);
    $str="";
    if($params!="")
    {
        foreach ($params as $k=>$v) {
                    if (is_array($v)) {
                            foreach ($v as $kv => $vv) {
                                    $str .= '&' . $k . '[' . $kv  . ']=' . urlencode($vv);
                            }
                    } else {
                            $str .= '&' . $k . '=' . urlencode($v);
                    }
            }
    }
        if (function_exists('curl_init')) {
                // Use CURL if installed...
                $ch = curl_init();
                $header=array(
                        'Accept-Language: zh-cn',
                        'Connection: Keep-Alive',
                        'Cache-Control: no-cache'
                );
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                if($timeout > 0)curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $result = curl_exec($ch);
                $errno = curl_errno($ch);
                curl_close($ch);
                return $result;
        } else {
                $context = array(
                        'http' => array(
                                'method' => 'POST',
                                'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
                                'Content-length: ' . strlen($str),
                                'content' => $str));
                if($timeout > 0)$context['http']['timeout'] = $timeout;
                $contextid = stream_context_create($context);
                $sock = @fopen($url, 'r', false, $contextid);
                if ($sock) {
                        $result = '';
                        while (!feof($sock)) {
                              $result .= fgets($sock, 8192);
                        }
                        fclose($sock);
                }
                else{
                                return 'TimeOut';
                }
        }
        return $result;
}


function checksite() {
    global $_G;
    $cert=array('rid'=>'45170','sn'=>'20171207188h9HNBBi8h','date'=>'1474808403','siteurl'=>'http://www.xyabc.cc/','siteid'=>'50D4F8F6-3BEB-82AB-2504-C84C3F79C246','qqid'=>'FB0C8E1C-1C30-5246-5484-F2414B8BA9A5','md5srrs'=>'53cae71a14dcc817616c1036c112026d');
	if (stripos($cert['siteurl'], $_G['siteurl']) > 0 ||$cert['siteurl'] == $_G['siteurl']) {
	    return true;
    }else{
        $url = 'http://dz.3dcader.com/plugin.php?id=application:auth'.$url;
        $url = $url. '&sn='.urlencode($cert['sn']);
        $url = $url.'&rid='.urlencode($cert['rid']);
        $url = $url.'&date='.urlencode($cert['date']);
        $url = $url.'&siturl='.urlencode($cert['siteurl']);
        $url = $url.'&client='.urlencode($_G['siteurl']);
        $url = $url.'&siteid='.urlencode($cert['SiteId']);
        $url = $url.'&qqid='.urlencode($cert['qqid']);
        $mesg=make_request($url);
        //DB::query("DROP TABLE IF EXISTS ".DB::table('threed_ckbuy')."");
        //echo($mesg);
        //exit($mesg);
        }
}

?>