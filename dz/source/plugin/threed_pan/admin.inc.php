<?php
(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) && exit('Access Denied');

global $_G;

loadcache('plugin');
loadcache('pluginlanguage_template');
loadcache('pluginlanguage_script');

$ppp = 20;
$page = max(1, intval($_GET['page']));
$startlimit = ($page - 1) * $ppp;
$deletes = '';
$extrasql = '';

$hosturl=ADMINSCRIPT."?action=";
$identifier = $_GET['identifier'];
$urls = '&pmod=admin&identifier='.$identifier.'&operation='.$operation.'&do='.$do;
define(TOOLS_ROOT, dirname(__FILE__).'/');

if(submitcheck('pansubmit')){
	$del=0;
	foreach($_GET['delete'] as $key => $delid) {
		$delid=intval($delid);
		//DB::delete('threed_pan', "id=$delid");
		DB::delete('threed_pan', "id=$delid");
		$del=$del+1;
	}
	cpmsg(lang('plugin/threed_pan', 'admin1').$del, "action=plugins&cp=admin_buysum&pmod=admin&operation=$operation&do=$do&page=$page", 'succeed');
}

showformheader("plugins&cp=admin_buysum&pmod=admin&operation=$operation&do=$do");
showtableheaders(lang('plugin/threed_pan', 'admin2'));

	$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('threed_pan')." w WHERE 1 ");
	$multipage = multi($count, $ppp, $page, ADMINSCRIPT."?action=plugins&cp=admin_buysum&pmod=admin&operation=$operation&do=$do");
	
	showtableheader();
	showtablerow('', array('class="td25"', '', '', '', 'class="td25"', 'class="td28"'), array('', lang('plugin/threed_pan', 'admin3'),lang('plugin/threed_pan', 'admin4'),lang('plugin/threed_pan', 'admin5'),lang('plugin/threed_pan', 'admin6'),lang('plugin/threed_pan', 'admin7')));

	$query = DB::query("SELECT * FROM ".DB::table('threed_pan')." WHERE 1 LIMIT $startlimit, $ppp");
	while($threed_pan_t = DB::fetch($query)) {
		
		
			$threed_pan_td2=threed_pan_subject($threed_pan_t['buy_tid']);
		
			$threed_pan_td3='<a href="home.php?mod=space&uid='.threed_pan_buysaleid($threed_pan_t['buy_tid']).'" target="_blank">'.threed_pan_getusername(threed_pan_buysaleid($threed_pan_t['buy_tid'])).'</a>';
			$threed_pan_td5='<a href="home.php?mod=space&uid='.$threed_pan_t['buy_uid'].'" target="_blank">'.threed_pan_getusername($threed_pan_t['buy_uid']).'</a>';
		
		
		showtablerow('', array('class="td25"', '', '', '', 'class="td25"', 'class="td28"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$threed_pan_t[id]\"><input type=\"hidden\" name=\"id[$threed_pan_t[id]]\" value=\"$threed_pan[id]\">",
			$threed_pan_td2,
			$threed_pan_td3,
			$threed_pan_t['buy_info'],
			$threed_pan_td5,
			date('Y-m-d H:i:s', $threed_pan_t['buy_time']),
		));
	}
	
	function threed_pan_subject($tid){
	   $tid=intval($tid);
       if($tid>0){$reject='<a href="forum.php?mod=viewthread&tid='.$tid.'" target="_blank">'.DB::result_first("select subject from ".DB::table('forum_post')." where tid=".$tid).'</a>';
       }else{
        $aid=0-$tid;
        $reject='<a href="portal.php?mod=view&aid='.$aid.'" target="_blank">'.DB::result_first("SELECT title FROM " . DB::table('portal_article_title') .
            " WHERE aid='$aid'").'</a>';
        }
	   if($reject){
	       return $reject;
        }else{
             return lang('plugin/threed_pan', 'admin8');
        }
	}
	
	function threed_pan_buysaleid($tid){
	   $tid=intval($tid);
	   	if($tid>0){return DB::result_first("SELECT authorid FROM ".DB::table('forum_thread')." WHERE tid=".$tid);
           }else{
                if($tid<0){
                    $aid=0-$tid;
                    return DB::result_first("SELECT uid FROM " . DB::table('portal_article_title') .
            " WHERE aid='$aid'");
                }else{
	               return "0";
         }
        }
		
	}
	
	function threed_pan_getusername($uid){
	   $uid=intval($uid);
	   if($uid>=0){
	       return DB::result_first("select username from ".DB::table('common_member')." where uid=".$uid);
	   }else{
		  return lang('plugin/threed_pan', 'admin9');
        }
	}
	
	function showtableheaders($title = '', $classname = '', $extra = '', $titlespan = 15) {
	global $_G;
	$classname = str_replace(array('nobottom', 'notop'), array('nobdb', 'nobdt'), $classname);
	if(isset($_G['showsetting_multi'])) {
		if($_G['showsetting_multi'] == 0) {
			$extra .= ' style="width:'.($_G['showsetting_multicount'] * 270 + 20).'px"';
		} else {
			return;
		}
	}
	echo "\n".'<table class="tb tb2 '.$classname.'"'.($extra ? " $extra" : '').' style="clear: both;margin-top: 5px;width: 100%">';
	if($title) {
		$span = $titlespan ? 'colspan="'.$titlespan.'"' : '';
		echo "\n".'<tr><th '.$span.' class="partition">'.cplang($title).'</th></tr>';
		showmultititle(1);
	}
}
	
	showsubmit('pansubmit', 'submit', 'del', "<input type=hidden value=$page name=page />", $multipage);
	showtablefooter();
showformfooter();
?>