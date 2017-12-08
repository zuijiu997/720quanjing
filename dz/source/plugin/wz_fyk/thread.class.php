<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_wz_fyk{
	var $forum_offset;
	function plugin_wz_fyk() {
		global $_G;
		$set= $_G['cache']['plugin']['wz_fyk'];
		$this->forumlist = (array)unserialize($set['forum_offset']);
	}
}

class plugin_wz_fyk_forum extends plugin_wz_fyk {

  function viewthread_tbg_output($a) {
		global $_G, $postlist;
		$wzjs=$_G['cache']['plugin']['wz_fyk']['jstxt'];
		if($a['template'] == 'viewthread' && in_array($_G['fid'], $this->forumlist)){
			foreach($postlist as $pid => $post) {
				$postlist[$pid]['message'] = '<table   cellspacing=0 cellpadding=0 border=0  ><tr><td width=14><img height=8 src=source/plugin/wz_fyk/image/top_l.gif width=14/></td><td width:=auto background=source/plugin/wz_fyk/image/top_c.gif></td><td width=16><img height=8 src=source/plugin/wz_fyk/image/top_r.gif width=16/></td></tr><tr><td valign=top width=14  background=source/plugin/wz_fyk/image/center_l.gif></td><td  bgColor=#fffff1> <div class="t_f">'.$post['message'].'</div></td><td valign=top width=16 background=source/plugin/wz_fyk/image/center_r.gif></td></tr><tr><td vAlign=top width=14><img height=42 src=source/plugin/wz_fyk/image/foot_l1.gif width=14/></td><td background=source/plugin/wz_fyk/image/foot_c.gif><img height=42 src=source/plugin/wz_fyk/image/foot_l3.gif width=36/></td><td align=right width=16><img height=42 src=source/plugin/wz_fyk/image/foot_r.gif width=16/></td></tr></table>'.$wzjs.''.$post[author].'หตฃบ</div>';
			}
		}
	}
}
?>