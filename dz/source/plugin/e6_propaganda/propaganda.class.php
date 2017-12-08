<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_e6_propaganda {
 	function global_e6_x() {
		global $_G ,$_GET, $_POST;
		$_GET['x'] && $x = intval($_GET['x']);
		$_POST['regsubmit'] && $e6_reg = 1;
		if ($x or ($e6_reg && $_G['uid'] && getcookie('pro_x'))) {
			!$GLOBALS['e6_propaganda_x'] && @include DISCUZ_ROOT . 'source/plugin/e6_propaganda/x.php';
		}
	}
	function global_header() {
		self::global_e6_x();
	}
}

class plugin_e6_propaganda_member extends plugin_e6_propaganda {
	function register_input_output() {
		$x = intval(getcookie('pro_x'));
		if ($x) {
			!$GLOBALS['hack_e6_propaganda'] && require_once DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
			if ($GLOBALS['e6_propaganda']['open'] == 1 && $GLOBALS['e6_propaganda']['showuser']) {
				$pro_username = E6::M()->get_username($x);
				$text = e6_c('c_1');
				return <<<EOT
<div class="rfm">
	<table>
		<tbody>
			<tr>
				<th>{$text}:</th>
				<td>{$pro_username}</td>
				<td class="tipcol"></td>
			</tr>
		</tbody>
	</table>
</div>
EOT;
			}
		}
	}
}

class plugin_e6_propaganda_forum extends plugin_e6_propaganda {
	static function viewthread_useraction_output() {
		global $_G;
		!$GLOBALS['hack_e6_propaganda'] && require_once DISCUZ_ROOT . 'source/plugin/e6_propaganda/config.php';
		!$e6_propaganda && $e6_propaganda = $GLOBALS['e6_propaganda'];
		if ($e6_propaganda['open'] == 1 && $e6_propaganda['tidurl']) {
			$visit_sum = array_sum($e6_propaganda['visit_money']);
			if ($visit_sum) {
				foreach ($e6_propaganda['visit_money'] as $key => $value) {
					if ($value) {
						$e6_reward .= $value . $_G['setting']['extcredits'][$key]['title'] . '. ';
					}
				}
				$e6_reward = preg_replace('/. $/i','',$e6_reward);
				$e6_reward = '<br><div style="padding-bottom:10px;"><span style="color:#FF6600">' . e6_c('c_2') . ': <font color="blue">' . $e6_reward . '</font></span>';
			} else {
				if ($e6_propaganda['registertype']) {
					if ($e6_propaganda['registertype'] == 1) {
						$register_sum = array_sum($e6_propaganda['register_money']);
						if ($register_sum) {
							foreach ($e6_propaganda['register_money'] as $key => $value) {
								if ($value) {
									$e6_reward .= $value . $_G['setting']['extcredits'][$key]['title'] . '. ';
								}
							}
							$e6_reward = preg_replace('/. $/i','',$e6_reward);
						}
					} else {
						$e6_reward = $e6_propaganda['multi_reg_1'] . $_G['setting']['extcredits'][$e6_propaganda['multi_regtype_1']]['title'];
					}
					$e6_reward = '<br><div style="padding-bottom:10px;"><span style="color:#FF6600">' . e6_c('c_3') . ': <font color="blue">' . $e6_reward . '</font></span>';
				} else {
					$region_sum = array_sum($e6_propaganda['region_money']);
					if ($region_sum) {
						foreach ($e6_propaganda['region_money'] as $key=> $value) {
							if ($value) {
								$e6_reward .= $value.$_G['setting']['extcredits'][$key]['title'] . '. ';
							}
						}
						$e6_reward = preg_replace('/. $/i','',$e6_reward);
						$e6_reward = '<br><div style="padding-bottom:10px;"><span style="color:#FF6600">' . e6_c('c_4') . '[<font color="blue">' . $e6_propaganda['area'] . '</font>]' . e6_c('c_5') . ': <font color="blue">' . $e6_reward . '</font></span>';
					} else {
						if ($e6_propaganda['active_num']>0) {
							$e6_reward = '<br><div style="padding-bottom:10px;"><span style="color:#FF6600">' . e6_c('c_6') . '</span>';
						} else {
							if ($e6_propaganda['paytype']) {
								$e6_reward = '<br><div style="padding-bottom:10px;"><span style="color:#FF6600">' . e6_c('c_7') . '</span>';
							}
						}
					}
				}
			}
			if ($e6_reward) {
				$e6_rewri_url = E6::M()->rewrite($_G['tid']);
				$e6_reward .= '<br><div style="padding-top:5px;"><input type="text" class="px vm" onclick="this.select();setCopy(this.value, \'' . e6_c('c_7') . '\');" value="'.$e6_rewri_url.'" size="80" />' .
				'<button type="submit" class="pn vm" onclick="setCopy($(\'thread_subject\').innerHTML.replace(/&amp;/g, \'&\') + \'\\r\\n\'+\''.$e6_rewri_url.'\', \'' . e6_c('c_7') . '\');" type="submit"><em>' . e6_c('c_9') . '</em></button></div></div>';
				return $e6_reward;
			}
		}	
	}
}

class plugin_e6_propaganda_group extends plugin_e6_propaganda {
	static function viewthread_useraction_output() {
		return plugin_e6_propaganda_forum::viewthread_useraction_output();
	}
}
?>