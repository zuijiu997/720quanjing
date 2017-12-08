<?php
/**
 *      本程序由尹兴飞开发
 *      若要二次开发或用于商业用途的，需要经过尹兴飞同意。
 *
 *		http://app.yinxingfei.com			插件技术支持
 *
 *		http://www.cglnn.com			    插件演示站点
 *
 ->		==========================================================================================
 *
 *      2014-11-01 开始由6.1升级到6.2！
 *
 *		愿我的同学、家人、朋友身体安康，天天快乐！
 ->		同时也祝您使用愉快！
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
   if(!submitcheck('emotsubmit')) {
            $emotechos = '';
			$query = DB::query("SELECT * FROM ".DB::table('yinxingfei_zzza_dj')." ORDER BY id");
			while($emot = DB::fetch($query)) {
				if($emot['id'] == 1){
				$emotechos .= showtablerow('', '', array(
                    "".lang("plugin/yinxingfei_zzza","yyea")."<font color=red>".$emot['id']."</font>".lang("plugin/yinxingfei_zzza","jia")."",
                    "<input type=\"hidden\" name=\"xx[$emot[id]]\" value=\"0\">0",
                    "<input type=\"number\" name=\"sx[$emot[id]]\" value=\"$emot[sx]\">"
                ), TRUE);
				}else{
				$emotechos .= showtablerow('', '', array(
                    "".lang("plugin/yinxingfei_zzza","yyea")."<font color=red>".$emot['id']."</font>".lang("plugin/yinxingfei_zzza","jia")."",
                    $emot['xx'],
                    "<input type=\"number\" name=\"sx[$emot[id]]\" value=\"$emot[sx]\">"
                ), TRUE);
				}
                $emotechos .= "<input type=\"hidden\" name=\"id[$emot[id]]\" value=\"$emot[id]\">";
			}
        showformheader("plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_dengji&submit=1");
        showtips(lang("plugin/yinxingfei_zzza","djtsa"));
		showtableheader('<strong>'.lang("plugin/yinxingfei_zzza","yyldjcs").'</strong>');
		showsubtitle(array( lang("plugin/yinxingfei_zzza","djaa") ,  lang("plugin/yinxingfei_zzza","xxcsa") ,  lang("plugin/yinxingfei_zzza","sxcsa") ));
		echo $emotechos;
		showsubmit('emotsubmit', lang("plugin/yinxingfei_zzza","jl7"));
        showtablefooter();
		showformfooter();

	} else {
		if(is_array($_GET['id'])) {
			foreach($_GET['id'] as $id => $val) {
				if($id != 1){
					$_GET['xx'][$id] = $_GET['sx'][$id-1];
				}
				DB::update('yinxingfei_zzza_dj', array(
					'id' => $_GET['id'][$id],
					'xx' => $_GET['xx'][$id],
					'sx' => $_GET['sx'][$id],
				), "id='$id'");
			}
		}
        cpmsg( lang("plugin/yinxingfei_zzza","jl8"),'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_dengji', 'succeed');
	}	
?>