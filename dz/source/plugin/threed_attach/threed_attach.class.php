<?php
/**
 *	[网盘伪装成本地附件(threed_attach.{modulename})] (C)2015-2099 Powered by 3D设计者.
 *	Version: 商业版
 *	Date: 2015-5-18 12:12
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_threed_attach {
	//TODO - Insert your code here
    public function getattachinfo($pid){
		$pid = dintval($pid);
		$tableid = DB::result_first("SELECT tableid FROM ".DB::table('forum_attachment')." WHERE pid='$pid' LIMIT 1");
		$tableid = $tableid >= 0 && $tableid < 10 ? intval($tableid) : 127;
		$table="forum_attachment_".$tableid;
        $sql="SELECT * FROM ".DB::table($table)." WHERE pid=".$pid." and isimage<>1 ORDER BY aid asc ";
        return DB::fetch_all($sql);	   
    }
    function discuzcode($value){//预先把所有附件都先处理，使之不被解析，方便后面解析
		global $_G;
		$pan_option = $_G['cache']['plugin']['threed_attach'];	
		$pan_forum = unserialize($pan_option["thd_forum"]);
        $thd_back=$_G['cache']['plugin']['threed_attach']['thd_back']; 
        $thd_dazhe=$_G['cache']['plugin']['threed_attach']['thd_dazhe'];
        if(!in_array($_G['fid'],$pan_forum)||$thd_dazhe)return array();
        if($value[caller]=="discuzcode"){
            $pid=$value[param][12];
            //print_r($value[param]);
            if(!$thd_back&&!$value[param][15])return array();
            if(!$pid)return array();
            $pan_msg=$_G['discuzcodemessage'];
            $attachlist=$this->getattachinfo($pid);
			foreach($attachlist as $k=>$attach){
			$str="[oneattachatt]".$attach[aid]."[/oneattachatt]";									
			if(preg_match("/\[attach\]".$attach[aid]."\[\/attach\]/",$pan_msg)){					
						$pan_msg=preg_replace("/\[attach\]".$attach[aid]."\[\/attach\]/",$str,$pan_msg);
					}
				}
                }
                //echo $pan_msg;
       $_G['discuzcodemessage']=$pan_msg;

    }
}
class plugin_threed_attach_forum extends plugin_threed_attach{
    public function getattachinfo($pid){
		$pid = dintval($pid);
		$tableid = DB::result_first("SELECT tableid FROM ".DB::table('forum_attachment')." WHERE pid='$pid' LIMIT 1");
		$tableid = $tableid >= 0 && $tableid < 10 ? intval($tableid) : 127;
		$table="forum_attachment_".$tableid;
        $sql="SELECT * FROM ".DB::table($table)." WHERE pid=".$pid." and isimage<>1 ORDER BY aid asc ";
        return DB::fetch_all($sql);	   
    }
    
    function post_attach_btn_extra() { 
        global $_G;
        $pid=intval($_GET[pid]);
        $thd_back=$_G['cache']['plugin']['threed_attach']['thd_back'];
        if(!$pid)$iffirst=1;else$iffirst = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid='$pid' LIMIT 1");
        $pan_fauser=unserialize($_G['cache']['plugin']['threed_attach']["thd_fauser"]);
        $pan_forum =unserialize($_G['cache']['plugin']['threed_attach']["thd_forum"]);
		$p_action=$_GET[action];
		if(!in_array($_G[groupid], $pan_fauser))return;
        if(!$thd_back&&!$iffirst&&$p_action=="edit")return;
        if(!$thd_back&&$p_action=="reply")return;
        if(!in_array($_G['fid'],$pan_forum))return;
            //$this->mt_swfwidth = 750;
           // $this->mt_switchImagebutton = 'attachlist';
            $ndsvtreturn = "<li  id=\"e_btn_filelist_pan_upload\"><a href=\"javascript:;\" hidefocus=\"true\" onclick=\"switchAttachbutton('filelist_pan_upload');\">" . lang('plugin/threed_attach', 'admin1'). "</a></li><li  id=\"e_btn_filelist_pan_upload\"><a href=\"javascript:;\" hidefocus=\"true\" onclick=\" add_edit_button();\">" .lang('plugin/threed_attach', 'admin2'). "</a></li>";
            return $ndsvtreturn;
    }
    function post_attach_tab_extra() {
        global $_G;
        $pid=intval($_GET[pid]);
        $pan_fauser=unserialize($_G['cache']['plugin']['threed_attach']["thd_fauser"]);
        $thd_back=$_G['cache']['plugin']['threed_attach']['thd_back'];
        if(!$pid)$iffirst=1;else$iffirst = DB::result_first("SELECT first FROM ".DB::table('forum_post')." WHERE pid='$pid' LIMIT 1");
        $pan_forum =unserialize($_G['cache']['plugin']['threed_attach']["thd_forum"]);
        $p_action=$_GET[action];
		if(!in_array($_G[groupid], $pan_fauser))return;
        if(!$thd_back&&!$iffirst&&$p_action=="edit")return;
        if(!$thd_back&&$p_action=="reply")return;
        if(!in_array($_G['fid'],$pan_forum))return;
       $attachlist=array();
       if($pid)$attachlist=$this->getattachinfo($pid);
       //print_r($attachlist);
        include template('threed_attach:add');
        $query = "SELECT v.groupid, v.grouptitle, t.readaccess FROM ".DB::table('common_usergroup')." v LEFT JOIN ".DB::table('common_usergroup_field')." t ON v.groupid=t.groupid where v.allowvisit=1 AND t.readaccess<>0 ORDER BY v.groupid DESC ";
        $data = DB::fetch_all($query);
        //print_r($data);
        $pan_str=show_addpan($data,$_G['tid'],$attachlist);
        return $pan_str;
        }

    function viewthread_posttop_output(){	
		global $_G,$postlist,$post;
        //print_r($_G['cache']['usergroups']);
		$pan_option = $_G['cache']['plugin']['threed_attach'];	
		$pan_forum = unserialize($pan_option["thd_forum"]);
        $thd_back=$pan_option['thd_back'];
        $thd_gong=$pan_option['thd_gong'];
        $thd_tiao=$pan_option['thd_tiao'];
        $thd_dazhe=$_G['cache']['plugin']['threed_attach']['thd_dazhe'];
		if(!in_array($_G['fid'],$pan_forum)||$thd_dazhe)return array();
        include template('threed_attach:attach');
		foreach($postlist as $id => $post) {	
            if(!$thd_back&&!$post['first'])return;
			$pan_message=$post['message'];
            $notimg=0;
			foreach($post['attachments'] as $k=>$attach){
			     if(!$attach['isimage']){
                 if($thd_gong&&$thd_tiao){
                    $notimg++;
			         $str='';
			         }else{
                    $str=show_attach($attach,$post['groupid']);
                    }
                    $pan_message=preg_replace("/\[oneattachatt\]".$attach[aid]."\[\/oneattachatt\]/",$str,$pan_message);
                    }
                 
			}
            if($notimg){
                $str=show_one_attach($post['pid'],$post['groupid']);
                $pan_message.=$str;
            }
			$post["message"]=$pan_message;
		  $postlist[$id] =$post;	
}
}
}
?>