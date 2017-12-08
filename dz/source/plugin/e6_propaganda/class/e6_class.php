<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class e6_class {

	public static $group_list = array();
	public static $get_user = array();

	public static final function M($classname = NULL) {
		!$classname && $classname = 'expand_' . $GLOBALS['e6_name'];
		return new $classname();
	}

	public function __call($method, $arg_array = array()) {
		if (method_exists(new e6_form(), $method)) {
			return call_user_func_array(array(new e6_form(), $method), $arg_array);
		} else {
			self::error('00005', $method);
		}
	}

	public function __get($property) {
		!$classname && $classname = 'expand_' . $GLOBALS['e6_name'];
		$class = new $classname();
		if (property_exists($class, $property)) {
			return $class->$property;
		} else {
			self::error('00006', $property);
		}
	}

	public static function config() {
		return $GLOBALS[$GLOBALS['e6_name']];
	}

	public static function scriptlang(){
		return $GLOBALS['scriptlang'][$GLOBALS['e6_name']];
	}

	public static function lang($str){
		return lang('plugin/' . $GLOBALS['e6_name'], $str);
	}

	public static function getgpc($array) {
		if (is_array($array)) {
			foreach ($array as $value){
				$GLOBALS[$value] = daddslashes(getgpc($value));
			}
		} else {
			$GLOBALS[$array] = daddslashes(getgpc($array));
		}
	}

	public static function msg($uid, $subject, $message) {
		notification_add($uid, 'system', 'system_notice', array('subject' => $subject, 'message' => $message), 1);
	}

	public static function money_list() {
		foreach ($GLOBALS['_G']['setting']['extcredits'] as $key => $value) {
			$money_list[$key] = $value['title'];
		}
		return $money_list;
	}

	public static function group_list($where = " WHERE (`type`='system' AND `radminid`=0)=false AND (`type`='member' AND `creditshigher`<0)=false ") {
		$where == 'all' && $where = null;
		if (self::$group_list[md5($where)]) return self::$group_list[md5($where)];
		$query = DB::query("SELECT `groupid`,`grouptitle` FROM ".DB::table('common_usergroup')." $where ORDER BY `type` DESC,`groupid` ASC");
		while ($rt = DB::fetch($query)) {
			$group_list[$rt['groupid']] = $rt['grouptitle'];
		}
		self::$group_list[md5($where)] = $group_list;
		return $group_list;
	}

	public static function error($id, $str = NULL) {
		exit("error : <a href=\"http://www.6ie6.com/error.php?id={$id}&dir={$GLOBALS['e6_name']}&expand={$str}\" target=\"_blank\">点击查看详情</a>");
	}

	public static function js($name, $e6_url = NULL) {
		$e6_url = $e6_url ? $e6_url : $GLOBALS['e6_name'];
		print "<script type=\"text/javascript\" src=\"source/plugin/{$e6_url}/js/{$name}.js\"></script>";
	}

	public static function css($name, $e6_url = NULL) {
		$e6_url = $e6_url ? $e6_url : $GLOBALS['e6_name'];
		print "<link href=\"source/plugin/{$e6_url}/css/{$name}.css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />";
	}

	public static function get_uid($username) {
		return DB::result_first("SELECT `uid` FROM ".DB::table('common_member')." WHERE `username`='$username'");
	}

	public static function get_username($uid) {
		return DB::result_first("SELECT `username` FROM ".DB::table('common_member')." WHERE `uid`='$uid'");
	}

	public static function get_user($uid, $field = '*') {
		if (self::$get_user[md5($uid.$field)]) return self::$get_user[md5($uid.$field)];
		if ($field == '*' or (strpos($field, ',') !== false)) {
			$get_user = DB::fetch_first("SELECT $field FROM ".DB::table('common_member')." WHERE `uid`='$uid'");
		} else {
			$get_user = DB::result_first("SELECT $field FROM ".DB::table('common_member')." WHERE `uid`='$uid'");
		}
		self::$get_user[md5($uid.$field)] = $get_user;
		return $get_user;
	}

	public static function get_usermoney($uid, $field = '*'){
		if(is_numeric($field)) return DB::result_first("SELECT `extcredits{$field}` FROM ".DB::table('common_member_count')." WHERE `uid`='$uid'");
		return DB::fetch_first("SELECT {$field} FROM ".DB::table('common_member_count')." WHERE `uid`='$uid'");
	}

	public static function update_usermoney($uid, $type, $money = NULL){
		if (strpos($type, '=') === false) {
			!$money && self::error('00004');
			DB::query("UPDATE ".DB::table('common_member_count')." SET `extcredits{$type}`=`extcredits{$type}`+'{$money}' WHERE uid='$uid'");
		} else {
			DB::query("UPDATE ".DB::table('common_member_count')." SET $type WHERE uid='$uid'");
		}
	}

	public static function money($money_arr = NULL, $logtype, $uid = NULL, $alternate = NULL){
		if (!$uid) {
			$uid = $GLOBALS['_G']['uid'];
			$username = $GLOBALS['_G']['username'];
		} else {
			$username = self::get_username($uid);
		}
		if(!$username) return FALSE;
		$money_list = self::money_list();
		if ($money_arr) {
			$money_arr = array_filter($money_arr);
			foreach($money_arr as $key => $value){
				$select_money .= "`extcredits{$key}`,";
				$update_money .= "`extcredits{$key}`=`extcredits{$key}`+'{$value}',";
			}
			$select_money = rtrim($select_money, ',');
			$update_money = rtrim($update_money, ',');
			$smoney = self::get_usermoney($uid, $select_money);
			self::update_usermoney($uid, $update_money);
			$emoney = self::get_usermoney($uid, $select_money);
		} else {
			$list_money = array_keys($money_list);
			$money_arr = array($list_money['0']=>'0');
		}
		$log_arr = self::M()->log_arr();
		foreach ($money_arr as $key => $value) {
			$money = $value;
			$money_title = $money_list[$key];
			eval('$describe="' . $log_arr[$logtype] . '";');
			$logtypes = (float)$logtype;
			DB::query("INSERT INTO ".DB::table(self::M()->log_table)." SET
				`uid`		=	'{$uid}',
				`username`	=	'{$username}',
				`type`		=	'{$key}',
				`logtype`	=	'{$logtypes}',
				`smoney`	=	'{$smoney['extcredits'.$key]}',
				`emoney`	=	'{$emoney['extcredits'.$key]}',
				`change`	=	'{$value}',
				`date`		=	'{$GLOBALS['_G']['timestamp']}',
				`ip`		=	'{$GLOBALS['_G']['clientip']}',
				`describe`	=	'{$describe}'
			");
		}
	}
}
class E6 extends e6_class{}
$GLOBALS['e6_class'] = $e6_class = 1;
?>