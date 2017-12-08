<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class hack_e6_propaganda extends e6_class {

	public $log_table = 'e6_pro_credit';
	public static $get_prouser = array();
	public static $get_prouser_count = array();

	public static function nav() {
		return array(
			'index'	=> e6_c('h_1'),
			'task'	=> e6_c('h_2'),
			'son' 	=> e6_c('h_3'),
			'multi' => e6_c('h_4'),
			'withdraw' => e6_c('h_5'),
			'log' 	=> e6_c('h_6'),
			'top' 	=> '<font color="#FF6600">' . e6_c('h_7') . '</font>'
		);
	}

	public static function log_type() {
		return array(
			'1' => e6_c('h_8'),
			'2' => e6_c('h_9'),
			'3' => e6_c('h_10'),
			'4' => e6_c('h_11'),
			'5' => e6_c('h_12'),
			'6' => e6_c('h_13'),
			'7' => e6_c('h_14'),
			'8'	=> e6_c('h_15'),
			'9' => e6_c('h_16'),
		);
	}

	public static function log_arr() {
		return array(
			'1'  => 'IP: {$alternate} ' . e6_c('h_17') . ': {$money}{$money_title}',
			'2a' => e6_c('h_18') . ': {$alternate} ' . e6_c('h_19') . ': {$money}{$money_title}',
			'2b' => e6_c('h_18') . ': {$alternate[0]}' . e6_c('h_20') . '{$alternate[1]} ' . e6_c('h_21') . '{$alternate[1]}' .e6_c('h_22') . ': {$money}{$money_title}',
			'3'	 => e6_c('h_18') . ': {$alternate} ' . e6_c('h_23') . ': {$money}{$money_title}',
			'4'	 => e6_c('h_24') . ': {$alternate[0]} {$alternate[1]}' . e6_c('h_25') . '{$alternate[1]}' . e6_c('h_26') . ': {$money}{$money_title}',
			'5'	 => e6_c('h_27') . '{$alternate[1]}' . e6_c('h_28') . ': {$alternate[0]} ' . e6_c('h_29') . ': {$alternate[2]}, ' . e6_c('h_30') . '{$alternate[1]}' . e6_c('h_31') . ': {$money}{$money_title}',
			'6a' => e6_c('h_27') . '{$alternate[1]}' . e6_c('h_28') . ': {$alternate[0]} ' . e6_c('h_32') . ': {$alternate[2]}' . e6_c('h_33') . '{$alternate[1]}' . e6_c('h_34') . ': {$money}{$money_title}',
			'6b' => e6_c('h_27') . '{$alternate[1]}' . e6_c('h_28') . ': {$alternate[0]} ' . e6_c('h_35') . ': {$alternate[2]}' . e6_c('h_33') . '{$alternate[1]}' . e6_c('h_34') . ': {$money}{$money_title}',
			'7a' => e6_c('h_36') . ': {$money}{$money_title}',
			'7b' => e6_c('h_37') . ': {$money}{$money_title}',
			'7c' => '{$alternate}' . e6_c('h_38') . ': {$money}{$money_title}',
			'7d' => '{$alternate}' . e6_c('h_39') . ': {$money}{$money_title}',
			'8a' => e6_c('h_40') . '<font color=\"blue\">{$alternate}</font>, ' . e6_c('h_41') . ': {$money}{$money_title}',
			'8b' => e6_c('h_40') . '<font color=\"blue\">{$alternate[0]}</font>, ' . e6_c('h_41') . ': {$alternate[1]} {$alternate[2]}',
			'8c' => e6_c('h_40') . '<font color=\"blue\">{$alternate[0]}</font>, ' . e6_c('h_41') . ': {$alternate[1]} ' . e6_c('h_42'),
			'8d' => e6_c('h_40') . '<font color=\"blue\">{$alternate[0]}</font>, ' . e6_c('h_43') . ' {$alternate[1]} ($alternate[2])',
			'9a' => 'IP: {$alternate} ' . e6_c('h_44'),
			'9b' => e6_c('h_18') . ': {$alternate} ' . e6_c('h_45'),
			'9c' => 'IP: {$alternate[0]} ' . e6_c('h_46') . '($alternate[1])' . e6_c('h_47'),
			'9d' => 'IP: {$alternate[0]} ' . e6_c('h_48') . '($alternate[1])' . e6_c('h_47'),
			'9e' => 'IP: {$alternate[0]} ' . e6_c('h_49') . '{$alternate[1]}' . e6_c('h_50'),
			'9f' => 'IP: {$alternate[0]} ' . e6_c('h_51') . ': {$alternate[1]} ' . e6_c('h_52'),
			'9g' => 'IP: {$alternate[0]} ' . e6_c('h_53') . ' {$alternate[1]} ' . e6_c('h_54'),
			'9h' => e6_c('h_18') . ': {$alternate[0]} ' . e6_c('h_55') . ' {$alternate[1]} ' . e6_c('h_56'),
		);
	}

	public static function get_prouser($uid, $field = '*'){
		if (self::$get_prouser[md5($uid.$field)]) return self::$get_prouser[md5($uid.$field)];
		if ($field == '*' or (strpos($field, ',') !== false)) {
			$prouser = DB::fetch_first("SELECT {$field} FROM ".DB::table('e6_pro_user')." WHERE `uid`='$uid'");
		} else {
			$prouser = DB::result_first("SELECT {$field} FROM ".DB::table('e6_pro_user')." WHERE `uid`='$uid'");
		}
		self::$get_prouser[md5($uid.$field)] = $prouser;
		return $prouser;
	}

	public static function get_prouser_count($uid, $field = '*'){
		if (self::$get_prouser_count[md5($uid.$field)]) return self::$get_prouser_count[md5($uid.$field)];
		if ($field == '*' or (strpos($field, ',') !== false)) {
			$prouser = DB::fetch_first("SELECT {$field} FROM ".DB::table('e6_pro_user_count')." WHERE `uid`='$uid'");
		} else {
			$prouser = DB::result_first("SELECT {$field} FROM ".DB::table('e6_pro_user_count')." WHERE `uid`='$uid'");
		}
		self::$get_prouser_count[md5($uid.$field)] = $prouser;
		if($field == '*' && !$prouser['uid']) self::add_prouser($uid);
		return $prouser;
	}

	public static function add_prouser($uid) {
		DB::query("INSERT INTO ".DB::table('e6_pro_user')." SET `uid`='$uid'");
		DB::query("INSERT INTO ".DB::table('e6_pro_user_count')." SET `uid`='$uid'");
	}

	public static function statistics($uid, $num = 1, $Y = null){
		if ($Y) {
			return DB::result_first("SELECT count(*) as `alluser` FROM ".DB::table('e6_pro_user')." WHERE `fuid{$num}`='$uid'");
		}
		$sql = self::statistics_sql($uid, $num);
		if ($sql) {
			return DB::result_first("SELECT count(*) as `alluser` FROM ".DB::table('e6_pro_user')." WHERE {$sql}");
		}
		return 0;
	}

	public static function statistics_sql($uid, $num = 1){
		for($n = 1; $n <= $num; $n++) {
			$sql .= "`fuid{$n}` = '{$uid}' ";
			$n < $num && $sql .= ' or ';
		}
		return $sql;
	}

	public static function rand_digest() {
		$maxtid = DB::result_first("SELECT MAX(tid) FROM " . DB::table('forum_thread') . " WHERE `digest`>'0'");
		!$maxtid && $maxtid = 0;
		$maxtid = DB::result_first("SELECT floor(RAND() * {$maxtid})");
		$digesttid = DB::result_first("SELECT `tid` FROM " . DB::table('forum_thread') .
			" WHERE `digest`>'0' AND `tid`>='{$maxtid}' ORDER BY `tid` LIMIT 1");
		if ($digesttid) return self::rewrite($digesttid);
	}

	public static function rewrite($tid) {
		if ($GLOBALS['_G']['setting']['rewritestatus'] && in_array('forum_viewthread', $GLOBALS['_G']['setting']['rewritestatus'])) {
			$url = rewriteoutput('forum_viewthread', 1, $GLOBALS['_G']['siteurl'], $tid);
			$url .= '?x=' . $GLOBALS['_G']['uid'];
		} else {
			$url = $GLOBALS['_G']['siteurl'] . 'forum.php?mod=viewthread&tid=' . $tid;
			$url .= '&x=' . $GLOBALS['_G']['uid'];
		}
		return $url;
	}

	public static function magic_list($close = NULL) {
		!$close && $where = " WHERE `available`='1' ";
		$query = DB::query("SELECT * FROM ".DB::table('common_magic')." $where ORDER BY `magicid` ASC");
		while($rt = DB::fetch($query)) {
			$magic_list[$rt['magicid']] = $rt['name'];
		}
		return $magic_list;
	}

	public static function medal_list($close = NULL) {
		!$close && $where = " WHERE `available`='1' ";
		$query = DB::query("SELECT * FROM ".DB::table('forum_medal')." $where ORDER BY `medalid` ASC");
		while($rt = DB::fetch($query)) {
			$medal_list[$rt['medalid']] = $rt['name'];
		}
		return $medal_list;
	}

	public static function reward_text($str){
		if(!is_array($GLOBALS['e6_propaganda'][$str])) return false;
		if(array_sum($GLOBALS['e6_propaganda'][$str])){
			$money_list = self::money_list();
			foreach (array_filter($GLOBALS['e6_propaganda'][$str]) as $key => $value) {
				$reward_money .= $value . $money_list[$key] . e6_c('h_90');
			}
			return preg_replace('/' . e6_c('h_90') . '$/i','',$reward_money);
		}
	}

	public static function reward_indextext($str = NULL, $type, $explain, $reward_text = NULL) {
		if(!$reward_text) $reward_text = self::reward_text($str);
		if ($reward_text) {
			return 	"
			<tr>
				<td style=\"color:#FF6600;padding-left:15px;width:80px;height:20px;\">{$type}</td>
				<td style=\"color:#FF6600;width:250px;\">{$explain}</td>
				<td style=\"color:#FF6600;\">" . e6_c('h_57') . ": {$reward_text}</td>
			</tr>";
		}
	}

	public static function task_reward() {
		return array(
			1 	=>	e6_c('h_58'),
			2	=>	e6_c('h_59'),
			3	=>	e6_c('h_60'),
			4	=>	e6_c('h_61')
		);
	}

	public static function task_type() {
		return array(
			1	=>	e6_c('h_62'),
			2 	=>	e6_c('h_63'),
			3	=>	e6_c('h_64'),
			4	=>	e6_c('h_65'),
			5	=>	e6_c('h_66'),
			6	=>	e6_c('h_67')
		);
	}

	public static function task_claim_text($claim, $claim1 = NULL, $claim2 = NULL) {
		switch($claim) {
			case 3 : $config = self::config(); break;
			case 6 : $group_list = self::group_list(); break;
		}
		$task_array =  array(
			1	=>	e6_c('h_68') . $claim1,
			2 	=>	e6_c('h_69') . $claim1 . e6_c('h_70'),
			3	=>	e6_c('h_71') . '<font color="red">' . $config['area'] . '</font>' . e6_c('h_72') . $claim1 . e6_c('h_73'),
			4	=>	e6_c('h_74') . $claim1 . e6_c('h_75'),
			5	=>	e6_c('h_76') . $claim1 . e6_c('h_77') . $claim2 . e6_c('h_73'),
			6	=>	e6_c('h_78') . $group_list[$claim1] . e6_c('h_79') . $claim2 . e6_c('h_73')
		);
		return $task_array[$claim];
	}

	public static function task_reward_text($reward, $reward1 = NULL, $reward2 = NULL) {
		switch($reward) {
			case 1 : $money_list = self::money_list(); break;
			case 2 : $magic_list = self::magic_list(); break;
			case 3 : $medal_list = self::medal_list(); break;
			case 4 : $group_list = self::group_list(); break;
		}
		$reward_array =  array(
			1	=>	e6_c('h_80') . $reward1 . $money_list[$reward2],
			2 	=>	e6_c('h_81') . $reward1 . e6_c('h_82') . $magic_list[$reward2],
			3	=>	e6_c('h_83') . $medal_list[$reward1],
			4	=>	e6_c('h_84') . $group_list[$reward1] . '(' . ($reward2 ? $reward2 . e6_c('h_85') : e6_c('h_86')) . ')'
		);
		return $reward_array[$reward];
	}

	public static function task_group($groupid, $grouplimit = NULL) {
		if(!$grouplimit) return TRUE;
		if(in_array($groupid, unserialize($grouplimit))) return TRUE;
		return FALSE;
	}

	public static function task_img($taskid, $type) {
		if ($type == 'apply' or $type == 'cancel' or $type == 'reward') {
			return "<a href=\"plugin.php?id=e6_propaganda&nav=task&type={$type}&taskid={$taskid}\"><img src=\"source/plugin/e6_propaganda/image/{$type}.gif\"></a>";
		}
		return "<img src=\"source/plugin/e6_propaganda/image/{$type}.gif\">";
	}

	public static function task_my($taskid, $uid = NULL) {
		!$uid && $uid = $GLOBALS['_G']['uid'];
		return DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task_list')." WHERE `taskid`='{$taskid}' AND `uid`='{$uid}'");
	}

	public static function task_value($claim, $claim1 = NULL) {
		$prouser = self::get_prouser_count($GLOBALS['_G']['uid']);
		switch($claim) {
			case 1 : $value = $prouser['ip']; break;
			case 2 : $value = $prouser['register']; break;
			case 3 : $value = $prouser['area']; break;
			case 4 : $value = $prouser['paymoney']; break;
			case 5 :
				$arr = unserialize($prouser['active']);
				$value = $arr[$claim1];
				break;
			case 6 :
				$arr = unserialize($$prouser['upvip']);
				$value = $arr[$claim1];
				break;
		}
		!$value && $value = 0;
		return $value;
	}

	public static function task_ok($task_user, $claim, $claim1 = NULL, $claim2 = NULL) {
		$task_allvalue = self::task_value($claim, $claim1);
		if ($claim > 4) {
			$value = $claim2;
		} else {
			$value = $claim1;
		}
		if (($task_allvalue - $task_user['value']) >= $value) {
			return TRUE;
		}
		return FALSE;
	}

	public static function task_send_reward($taskid, $uid = NULL){
		!$uid && $uid = $GLOBALS['_G']['uid'];
		$task = DB::fetch_first("SELECT * FROM ".DB::table('e6_pro_task')." WHERE `id`='$taskid'");
		$message .= e6_c('h_87') . $task['name'] . e6_c('h_88');
		switch($task['reward']) {
			case 1 :
				self::money(array($task['reward2'] => $task['reward1']), '8a', false, $task['name']);
				$money_list = self::money_list();
				$message .= e6_c('h_58') . $task['reward1'] . $money_list[$task['reward2']];
				DB::query("UPDATE ".DB::table('e6_pro_user_count')." SET `money`=`money`+'{$task['reward1']}' WHERE `uid`='{$uid}'");
				break;
			case 2 :
				self::task_send_magic($uid, $task['reward2'], $task['reward1']);
				$magic_title = DB::result_first("SELECT `name` FROM ".DB::table('common_magic')." WHERE `magicid`='{$task['reward2']}'");
				self::money(false, '8b', false, array($task['name'], $task['reward1'], $magic_title));
				$message .= e6_c('h_81') . $task['reward1'] . e6_c('h_82') . $magic_title;
				break;
			case 3 :
				self::task_send_medal($uid, $task['reward1']);
				$medal_title = DB::result_first("SELECT `name` FROM ".DB::table('forum_medal')." WHERE `medalid`='{$task['reward1']}'");
				self::money(false, '8c', false, array($task['name'], $medal_title));
				$message .= e6_c('h_83') . $medal_title;
				break;
			case 4 :
				self::task_send_group($uid, $task['reward1'], $task['reward2']);
				$group_title = DB::result_first("SELECT `grouptitle` FROM ".DB::table('common_usergroup')." WHERE `groupid`='{$task['reward1']}'");
				$group_date = $task['reward2'] ?  $task['reward2'] . e6_c('h_85') : e6_c('h_86');
				self::money(false, '8d', false, array($task['name'], $group_title, $group_date));
				$message .= e6_c('h_84') . $group_title . "({$group_date})";
				break;
			default: return false;
		}
		DB::query("UPDATE " .DB::table('e6_pro_task_list'). " SET `ok`='1' WHERE `taskid`='$taskid' AND `uid`='$uid'");
		DB::query("UPDATE " .DB::table('e6_pro_user_count'). " SET `task`=`task`+'1' WHERE `uid`='$uid'");
		E6::M()->msg($uid, e6_c('h_89'), $message);
	}

	public static function task_send_medal($uid, $medalid) {
		$my_medal = DB::result_first("SELECT `medals` FROM ".DB::table('common_member_field_forum')." WHERE uid='$uid'");
		$my_medal_arr = explode("\t", $my_medal);
		if ($my_medal) {
			if(!in_array($medalid, $my_medal_arr)){
				$new_medal = $medalid . "\t" . $my_medal;
			}
		} else {
			$new_medal = $medalid;
		}
		if ($new_medal) {
			DB::query("UPDATE ".DB::table('common_member_field_forum')." SET `medals`='$new_medal' WHERE `uid`='$uid'");
			DB::query("INSERT INTO ".DB::table('forum_medallog')." SET `uid`='$uid' , `medalid`='$medalid' , `type`='0' , `dateline`='{$GLOBALS['_G']['timestamp']}' , `expiration`='0' , `status`='0'");
			if ($GLOBALS['_G']['setting']['version'] != 'X2') {
				DB::query("REPLACE INTO ".DB::table('common_member_medal')." SET `uid`='$uid' , `medalid`='$medalid'");
			}
		}
	}

	public static function task_send_magic($uid, $magicid, $num = 1){
		$Y = DB::result_first("SELECT * FROM ".DB::table('common_member_magic')." WHERE `uid` ='$uid' AND `magicid`='$magicid'");
		if ($Y) {
			DB::query("UPDATE ".DB::table('common_member_magic')." SET `num`=`num`+'$num' WHERE `uid`='$uid' AND `magicid`='$magicid'");
		} else {
			DB::query("INSERT INTO ".DB::table('common_member_magic')." SET `uid`='$uid',`magicid`='$magicid',`num`='$num'");
		}
		DB::query("INSERT INTO ".DB::table('common_magiclog')." SET `uid`='$uid',`magicid`='$magicid',`action`='3',`dateline`='{$GLOBALS['_G']['timestamp']}',`amount`='$num',`price`='',`credit`='',`idtype`='',`targetid`='0',`targetuid`='$uid'");
	}

	public static function task_send_group($uid, $groupid, $date = NULL) {
		$user = DB::fetch_first("SELECT `groupid`,`groupexpiry` FROM ".DB::table('common_member')." WHERE `uid`='$uid'");
		$group_radminid = DB::result_first("SELECT `radminid` FROM ".DB::table('common_usergroup')." WHERE `groupid`='$groupid'");
		!$group_radminid && $group_radminid = '-1';
		if ($date) {
			if ($user['groupid'] == $groupid && $user['groupexpiry'] > $GLOBALS['_G']['timestamp']) {
				$groupexpiry = $user['groupexpiry'] + ($date * 86400);
			} else {
				if ($user['groupid'] == $groupid && !$user['groupexpiry']) return TRUE;
				$groupexpiry = $GLOBALS['_G']['timestamp'] + ($date * 86400);
			}
			$groupterms = array('main'=>array('time' => $groupexpiry), 'ext' => array($groupid => $groupexpiry));
			$groupterms = addslashes(serialize($groupterms));
		} else {
			$groupexpiry = 0;
			$groupterms = 'a:0:{}';
		}
		DB::query("UPDATE ".DB::table('common_member')." SET `groupid`='$groupid',`adminid`='$group_radminid',`groupexpiry`='$groupexpiry' WHERE `uid`='$uid'");
		DB::query("UPDATE  ".DB::table('common_member_field_forum')." SET `groupterms`='$groupterms' WHERE `uid`='$uid'");
	}
}
$GLOBALS['hack_'.$e6_name] = ${'hack_'.$e6_name} = 1;
?>