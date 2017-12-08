<?php

function dump($vars,$level=1,$pre='')  {
	$block = '  ';
	if($level ==1){
		echo "<pre style='font-size:14px;'>\n type:<c style='color:orange'>".gettype($vars)."</c> count:".count($vars)." level:{$level} {\n";
		if(gettype($vars) == 'array'){
			foreach($vars as $k=>$v){
				if(gettype($v)== 'array'){
					echo $block."<b style='color:sienna'>-['{$k}'] array count:".count($v)." Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($v,$_level,"['{$k}']");
				}else{
					$v = dhtmlspecialchars($v, ENT_QUOTES);
					echo $block."<span style='color:blue'>-['{$k}']=<span style='color:sienna'>{$v}</span></span>\r\n";
				}
			}
		}else{
			echo "  -".$vars."\r\n";
		}
		echo  "   \n</pre>";
	}
	elseif($level >1){
		$_block="";
		for($i=0;$i<$level;$i++){
			$_block .=$block;
		}
		if(gettype($vars)== 'array'){
			foreach($vars as $_k=>$_v){
				if(gettype($_v)== 'array'){
					echo $_block."<b style='color:sienna'>-{$pre}['{$_k}'] Array count:".count($_v)."Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($_v,$_level,$pre."['{$_k}']");
				}else{
					$_v = dhtmlspecialchars($_v, ENT_QUOTES);
					echo $_block."<span style='color:blue'>-{$pre}['{$_k}']=<span style='color:sienna'>{$_v}</span></span>\r\n";
				}
			}
		}else{
			echo $_block."<span style='color:green'> -{$pre}['{$pre}']={$vars}</span>\r\n";
		}
	}
}

function gpc($pre){
	$array = array();
	$pre = str_replace(" ",'',$pre);
	$pre = str_replace("\t",'',$pre);
	if(strpos($pre,'|')!==false)
		$pre_array = explode('|',$pre);
	
	foreach($_GET as $key=>$g){
		if($pre_array){
			foreach($pre_array as $v){
				$substr= '';
				$substr = substr($key,0,strlen($v));
				if(strstr($substr,$v)){
					$array[$key] = dhtmlspecialchars(daddslashes(($g)));
					
				}
			}
		}else{
			$substr= '';
			$substr = substr($key,0,strlen($pre));
			if( strstr($substr,$pre)){
				$array[$key] = dhtmlspecialchars(daddslashes(($g)));
				
			}
		}
	}
	
	return $array;
}

function get_url(){
	global $car_config;
	$url = $_SERVER['QUERY_STRING'];
	$url =  urldecode($url);
	if(defined('IN_MOBILE')){
		$url = diconv($url,"UTF-8",CHARSET);
	}
	$url_query = explode("&",$url);
	$array = array();
	foreach($url_query as $v){
		if(strstr($v,"=")){
			$v = explode("=",$v);
			$array[$v[0]] = $v[1];
		}
	}
	$url ="";
	foreach($array as $k=>$v){
		if(!empty($v) && $k !='page')
		$url[] =$k."=".$v;
	}
	$url = implode("&",$url);
	$url = $car_config['root'].'?'.$url;
	return $url;
}

function getgpc_in_array($key_array){
	$return = array();
	foreach($key_array as $v){
		$return[] = addslashes($_GET[$v]);
	}
	return $return;
}

function get_profile_type_title($profile_type_id){
	return DB::result_first("SELECT profile_type_title FROM ".DB::table('car_profile_type')." WHERE profile_type_id='{$profile_type_id}'");
}

function get_profile_setting($profile_type_id=""){
	if(!empty($profile_type_id)){
		$profile_type_setting_name = fetch_all("car_profile_type_setting"," WHERE profile_type_id='{$profile_type_id}' ORDER BY profile_type_setting_sort ASC ","profile_setting_name");
	}else{
		$profile_type_setting_name = fetch_all("car_profile_type_setting"," ORDER BY profile_type_setting_sort ASC ","profile_setting_name");
	}
	$profile_type_setting_names = array();
	foreach($profile_type_setting_name as $v){
		$profile_type_setting_names[] = $v['profile_setting_name'];
	}

	$profile_setting = fetch_all("car_profile_setting"," WHERE profile_setting_name in ('".implode("','",$profile_type_setting_names)."')  ORDER BY substring_index('".implode(",",$profile_type_setting_names)."', profile_setting_name,1)");
	foreach($profile_setting as $key=>$value){
		$profile_setting[$value['profile_setting_name']]=$value;
		unset($profile_setting[$key]);
	}
	return $profile_setting;
}

function get_profile_type_setting($profile_type_id){
	$type_array = brian_fetch_all("car_profile_type_setting"," WHERE profile_type_id='{$profile_type_id}' ");
	return $type_array;
}

function get_profile_type_jiage($profile_type_id){
	$type_array = brian_fetch_all("car_profile_type_setting"," WHERE profile_type_id='{$profile_type_id}' AND profile_type_setting_jiage='1' ",array('first'=>1,'filter'=>'profile_setting_name'));
	$type_array = $type_array['profile_setting_name'];
	return $type_array;
}

function get_post_profile($post_id){
	$post_profile = array();
	if( is_array($post_id)){
	}else{
		$post_profile = fetch_all('car_post_profile'," WHERE post_id='{$post_id}' ","*");
		foreach($post_profile as $key=>$value){
			$post_profile[$value['profile_setting_name']] = $value;
			unset($post_profile[$key]);
		}
	}
	return $post_profile;
}

function fetch_all($table,$other='',$filter='*',$first="1"){
	$sql = 'SELECT '.$filter.' FROM '.DB::table($table).' '.$other;
	$query =DB::query($sql);
	$array = array();
	while($tem = DB::fetch($query)){
		$array[] = $tem;
	}
	if($first=="0"){
		$array = $array[0];
	}
	return $array;
}

function brian_fetch_all($table,$where='', $other){
	$other['filter'] = empty($other['filter']) ? "*" : $other['filter']; 
	$other['first'] = empty($other['first']) ? "0" : $other['first']; 
	$other['sort'] = empty($other['sort']) ? "" : $other['sort']; 
	
	$sql = 'SELECT '.$other['filter'].' FROM '.DB::table($table).' '.$where;
	if($other['first'] ){
		$sql = $sql." LIMIT 1";
	}
	//var_dump($sql);
	$query =DB::query($sql);
	$array = array();
	while($tem = DB::fetch($query)){
		if(!empty($other['sort'])){
			$array[$tem[$other['sort']]] = $tem;
		}else{
			$array[] = $tem;
		}
	}
	if($other['first']==1){
		$array = $array[0];
	}
	return $array;
}

function sortgpc($array,$id){
	$ids= $array[$id];
	$_array = array();
	foreach($array as $key1=>$a){
		foreach($a as $key2=>$v){
			$_array[$ids[$key2]][$key1]  = $v;
		}
	}
	return $_array;
}

function is_car_admin($groupid=''){
	global $car_config,$_G;
	$groupid = !empty($groupid) ? $groupid : $_G['groupid'];
	$admin_group = unserialize($car_config['admingroup']);
	if(count($admin_group)>1 &&  in_array($groupid,$admin_group)){
		return true;
	}elseif(count($admin_group) ==1 && $groupid == $admin_group[0]){
		return true;
	}else{
		return false;
	}
}

function is_car_broker($uid=''){
	global $car_config,$_G;
	$uid = !empty($uid) ? $uid : $_G['uid'];
	$groupid = DB::result_first('SELECT groupid FROM '.DB::table('common_member')." WHERE uid='{$uid}'");
	$admin_group = unserialize($car_config['brokergroup']);
	if(count($admin_group)>1 &&  in_array($groupid,$admin_group)){
		return true;
	}elseif(count($admin_group) ==1 && $groupid == $admin_group[0]){
		return true;
	}else{
		return false;
	}
}

function addgpc($array){
	$new_array = array();
	foreach($array as $k=>$v){
		foreach($v as $_k=>$_v){
			$new_array[$_k][$k] =$_v;
		}
	}
	return $new_array;
}

function upload_image($file_name,$type='space',$_w=500,$_h=500,$cut=1){
	global $_G;
	$attachdir	= $_G['setting']['attachdir'];
	$attachurl	= $_G['setting']['attachurl'];
	
	$file = $_FILES[$file_name];
	if($_FILES[$file_name]['size']){
		if($_G['setting']['version'] =='X2'){
			require_once libfile('class/upload');
		}
		$upload = new discuz_upload();
		if(!$upload->init($file,$type)) {
			return false;
		}
		$upload->save();
		
		require_once  libfile('class/image');
		$image = new image();
		$thumbTarget =$type.'/'.date('Ym').'/'.date('d').'/'.$upload->attach['attachment'];
		$image->Thumb($upload->attach['target'],$thumbTarget, $_w, $_h, $cut);
		@unlink($image->source);
		
		if(!empty($_GET['temp_'.$file_name])){
			$_goods_pic = addslashes($_GET['temp_'.$file_name]);
			@unlink($_goods_pic);
		}
		
		return $attachurl.$thumbTarget;
	}elseif(isset($_GET['temp_'.$file_name])){
		return addslashes($_GET['temp_'.$file_name]);	
	}
}

function hidden_ip($ip){
	return str_replace(strrchr($ip,'.'),'.*',$ip);
}

function brian_showdistrict($values, $elems=array(), $container='districtbox', $showlevel=null, $containertype = '') {
	$html = '';
	if(!preg_match("/^[A-Za-z0-9_]+$/", $container)) {
		return $html;
	}
	$showlevel = !empty($showlevel) ? intval($showlevel) : count($values);
	$showlevel = $showlevel <= 4 ? $showlevel : 4;
	$upids = array(0);
	for($i=0;$i<$showlevel;$i++) {
		if(!empty($values[$i])) {
			$upids[] = intval($values[$i]);
		} else {
			for($j=$i; $j<$showlevel; $j++) {
				$values[$j] = '';
			}
			break;
		}
	}
	$options = array(1=>array(), 2=>array(), 3=>array(), 4=>array());
	if($upids && is_array($upids)) {
		foreach(table_brian_district::fetch_all_by_upid($upids, 'displayorder', 'ASC') as $value) {
			$options[$value['level']][] = array($value['id'], $value['name']);
		}
	}
	$names = array('province', 'city', 'district', 'community');
	for($i=0; $i<4;$i++) {
		if(!empty($elems[$i])) {
			$elems[$i] = dhtmlspecialchars(preg_replace("/[^\[A-Za-z0-9_\]]/", '', $elems[$i]));
		} else {
			$elems[$i] = $names[$i];
		}
	}
	
	for($i=0;$i<$showlevel;$i++) {
		$level = $i+1;
		if(!empty($options[$level])) {
			$jscall = "brian_showdistrict('$container', ['$elems[0]', '$elems[1]', '$elems[2]', '$elems[3]'], $showlevel, $level, '')";
			$html .= '<select name="'.$elems[$i].'" id="'.$elems[$i].'" class="ps" onchange="'.$jscall.'" tabindex="1">';
			$html .= '<option value="">'.lang('spacecp', 'district_level_'.$level).'</option>';
			foreach($options[$level] as $option) {
				$selected = $option[0] == $values[$i] ? ' selected="selected"' : '';
				$html .= '<option did="'.$option[0].'" value="'.$option[1].'"'.$selected.'>'.$option[1].'</option>';
			}
			$html .= '</select>';
			$html .= '&nbsp;&nbsp;';
		}
	}
	return $html;
}


function bbs_post($input){
	global $_G;
	require_once libfile('function/post');
	require_once libfile('function/forum');
	
	$subject = $input['title'];
	$message = stripslashes($input['text']);
	
	$auid=$input['uid'];
	$au = $input['username'];
	$fid = $input['fid'];
	$dateline= TIMESTAMP;
	
	$data=array('fid' =>$fid,'subject' => $subject, 'dateline' => $dateline ,'lastpost' => $dateline ,'lastposter'=>$au,'author' => $au,'authorid' => $auid);
	$tid = DB::insert("forum_thread", $data, $tid = true);
	
	$pid = insertpost(array('tid' =>$tid,	'fid'=>$fid,'first' =>1,'subject' => $subject,'message'=>$message, 'dateline' => $dateline ,'author' => $au,	'authorid' => $auid,	'htmlon'=>"1"));
	
	updatepostcredits('+', $_G['uid'], 'post', $fid);
	
	$synclastpost = "{$tid}\t".addslashes($subject)."\t{$_G[timestamp]}\t{$_G[username]}";
	DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$synclastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='{$fid}'", 'UNBUFFERED');
	
	return $tid;
}

class table_brian_district 
{
	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? implode("','", array_map('intval', (array)$upid)) : dintval($upid);
		if($upid !== null) {
			$ordersql = ' ORDER BY displayorder ASC' ;
			return brian_fetch_all('car_area'," WHERE upid IN ('{$upid}') {$ordersql} ",array('sort'=>'id'));
		}
		return array();
	}
}

function brian_cat_cache(){
	require_once libfile('function/cache');
	
	$cat_array =array();
	$cat_array = brian_fetch_all('car_cat', ' ORDER BY cat_sort ASC',array('sort'=>'cat_id'));
	foreach($cat_array as $k=>$v){
		if(!empty($v['cat_pid'])){
			$cat_array[$k]['sum'] = DB::result_first("SELECT count(post_id) FROM ".DB::table("car_post")." WHERE subcat_id = '{$v['cat_id']}' ");
		}
	}
	$cat_array_field .= "\$cat_array = ".arrayeval($cat_array).";\n";
	writetocache('car_cat_array', $cat_array_field);
}

function brian_kind_cache(){
	require_once libfile('function/cache');
	
	$kind_array =array();
	$kind_array = brian_fetch_all('car_kind', ' ORDER BY kind_sort ASC',array('sort'=>'kind_id'));
	foreach($kind_array as $k=>$v){
		if(!empty($v['kind_pid'])){
			$kind_array[$k]['sum'] = DB::result_first("SELECT count(post_id) FROM ".DB::table("car_post")." WHERE subkind_id = '{$v['kind_id']}' ");
		}
	}
	$kind_array_field .= "\$kind_array = ".arrayeval($kind_array).";\n";
	writetocache('car_kind_array', $kind_array_field);
}

function shenlan_runquery($sql){
	require_once libfile('function/plugin');
	if(is_array($sql)){
		$sql_array = $sql;
	}elseif( strpos($sql, ";") !==false){
		$sql_array = explode(";",$sql);
	}else{
		$sql_array = array($sql);
	}
	foreach($sql_array as $sa){
		try{
			if(!empty($sa)){
				runquery($sa);
			}
		} catch(Exception $e) {
			//echo $e;
		}
	}
	return true;
}

function curl_get($url){
	$ch = curl_init($url) ;  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	$result = curl_exec($ch); 
	curl_close($ch) ; 
	return $result;
}

function set_cache($cachename, $data) {
	C::t('common_cache')->insert(array('cachekey' => $cachename, 'cachevalue' => serialize($data), 'dateline' => TIMESTAMP), false, true);
}

function del_cache($cachename) {
	C::t('common_cache')->delete($cachename);
}

function get_cache($cachename) {
	$cachevalue = C::t('common_cache')->fetch($cachename);
	return unserialize($cachevalue['cachevalue']);
}

function update_cache($cachename, $data) {
	C::t('common_setting')->update('upgrade', $data);
}
?>