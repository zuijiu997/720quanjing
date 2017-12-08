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
 *      2013-07-10 开始由6.0升级到6.1！
 *
 *		愿我的同学、家人、朋友身体安康，天天快乐！
 ->		同时也祝您使用愉快！
 */
if(!defined('IN_ADMINCP')) exit('Access Denied');
	if(submitcheck('backup')){
		if(preg_match('/[^A-Za-z0-9_]/', $_GET['filename'])) cpmsg(lang("plugin/yinxingfei_zzza","x"));
		$file = DISCUZ_ROOT."./data/zzza_backup/{$_GET[filename]}.vbak";
		@touch($file);
		if(!is_writeable($file)) cpmsg(lang("plugin/yinxingfei_zzza","x1"));
		$out_arr = array('zzza_rank' => array(), 'zzza_fw' => array(), 'zzza_time' => array(), 'zzza_fyb' => array(), 'zzza_tj' => array());
		$query = DB::query('SELECT * FROM '.DB::table('yinxingfei_zzza_rank'));
		while($data = DB::fetch($query)){
			$out_arr['zzza_rank'][] = $data;
		}
		
		$query = DB::query('SELECT * FROM '.DB::table('yinxingfei_zzza_fw'));
		while($data = DB::fetch($query)){
			$out_arr['zzza_fw'][] = $data;
		}
		
		$query = DB::query('SELECT * FROM '.DB::table('yinxingfei_zzza_time'));
		while($data = DB::fetch($query)){
			$out_arr['zzza_time'][] = $data;
		}
		$query = DB::query('SELECT * FROM '.DB::table('yinxingfei_zzza_fyb'));
		while($data = DB::fetch($query)){
			$out_arr['zzza_fyb'][] = $data;
		}
		$query = DB::query('SELECT * FROM '.DB::table('yinxingfei_zzza_tj'));
		while($data = DB::fetch($query)){
			$out_arr['zzza_tj'][] = $data;
		}
		$output = serialize($out_arr);
		file_put_contents($file, $output);
		cpmsg(lang("plugin/yinxingfei_zzza","x2"), "action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_data", 'succeed');
		dexit();
	}elseif(submitcheck('restore', 1)){
		$file = DISCUZ_ROOT."./data/zzza_backup/{$_GET[filename]}";
		if(!file_exists($file)) cpmsg(lang("plugin/yinxingfei_zzza","x3"));
		$data_str = file_get_contents($file);
		$data = unserialize($data_str);
		$zzza_rank = $data['zzza_rank'];
		$zzza_fw = $data['zzza_fw'];
		$zzza_time = $data['zzza_time'];
		$zzza_fyb = $data['zzza_fyb'];
		$zzza_tj = $data['zzza_tj'];
		if($zzza_rank){
			DB::query('TRUNCATE TABLE '.DB::table('yinxingfei_zzza_rank'));
			foreach ($zzza_rank as $line){
				DB::insert('yinxingfei_zzza_rank', $line);
			}
		}
		
		if($zzza_fw){
			DB::query('TRUNCATE TABLE '.DB::table('yinxingfei_zzza_fw'));
			foreach ($zzza_fw as $line){
				DB::insert('yinxingfei_zzza_fw', $line);
			}
		}
		
		if($zzza_time){
			DB::query('TRUNCATE TABLE '.DB::table('yinxingfei_zzza_time'));
			foreach ($zzza_time as $line){
				DB::insert('yinxingfei_zzza_time', $line);
			}
		}
		if($zzza_fyb){
			DB::query('TRUNCATE TABLE '.DB::table('yinxingfei_zzza_fyb'));
			foreach ($zzza_fyb as $line){
				DB::insert('yinxingfei_zzza_fyb', $line);
			}
		}
		if($zzza_tj){
			DB::query('TRUNCATE TABLE '.DB::table('yinxingfei_zzza_tj'));
			foreach ($zzza_tj as $line){
				DB::insert('yinxingfei_zzza_tj', $line);
			}
		}
		require_once libfile('function/cache');
		updatecache('yinxingfei_zzza');
		cpmsg(lang("plugin/yinxingfei_zzza","x4"), "action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_data", 'succeed');
		dexit();
	}
	showtableheader(lang("plugin/yinxingfei_zzza","x5"));
	showformheader("plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_data");
	showsetting(lang("plugin/yinxingfei_zzza","x6"), 'filename', random(10), 'text', '', '', lang("plugin/yinxingfei_zzza","x7").' /data/zzza_backup/ '.lang("plugin/yinxingfei_zzza","x8"));
	showsubmit('backup', lang("plugin/yinxingfei_zzza","x9"));
	showformfooter();
	showtablefooter();
	showtableheader(lang("plugin/yinxingfei_zzza","x10"));
	if(!is_dir(DISCUZ_ROOT.'./data/zzza_backup/')) {
		@mkdir(DISCUZ_ROOT.'./data/zzza_backup/', 0777);
		@touch(DISCUZ_ROOT."./data/zzza_backup/index.htm");
	}
	$backup_dir = @dir(DISCUZ_ROOT.'./data/zzza_backup/');
	$flag = false;
	while(false !== ($entry = $backup_dir->read())) {
		$file = pathinfo($entry);
		if($file['extension'] == 'vbak' && $file['basename']) {
			showtablerow('', '', array(
				lang("plugin/yinxingfei_zzza","x11").''.$file['basename'],
				dgmdate(filemtime(DISCUZ_ROOT."./data/zzza_backup/{$file[basename]}"), 'u'),
				'<a href="?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_data&filename='.$file['basename'].'&restore=yes&formhash='.FORMHASH.'">'.lang("plugin/yinxingfei_zzza","x12").'</a>',
			));
			$flag = true;
		}
	}
	if(!$flag) showtablerow('', '', array('<font color="red">'.lang("plugin/yinxingfei_zzza","x13").'</font>'));
	showtablefooter();
?>