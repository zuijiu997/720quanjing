<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class e6_form extends e6_class {

	public static function header() {
		print <<<EOT
		<form name="e6_form" method="post" autocomplete="off" action="">
			<input type="hidden" name="step" value="2" />
			<table class="tb tb2">
			<tbody>
EOT;
	}

	public static function footer() {
		print <<<EOT
					<tr>
						<td colspan="15">
							<div class="fixsel">
								<input type="submit" class="btn" name="e6_submit" value="&#25552;&#20132;" />
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
EOT;
	}

	public static function prompt($str) {
		print <<<EOT
			<table class="tb tb2">
				<tr>
					<th class="partition" style="text-align:center;">{$str}</th>
				</tr>
			</table>
EOT;
	}

	public static function type($type, $array) {
		if (method_exists(new e6_form(), $type)) {
			self::type_header($array[1], $array[2]);
			unset($array[1],$array[2]);
			call_user_func_array(array(new e6_form(), $type), $array);
			self::type_footer();
		} else {
			self::error('00001', $type);
		}
	}

	public static function type_header_pure($title, $describe = NULL) {
		print <<<EOT
			<tr>
				<td class="td27">{$title}:</td>
				<td class="vtop tips2">{$describe}</td>
			</tr>
EOT;
	}

	public static function type_header($title, $describe = NULL) {
		!$title && self::error('00002');
		self::type_header_pure($title, $describe);
		print <<<EOT
			<tr class="noborder">
				<td class="vtop rowform" colspan="2" style="width:100%">
EOT;
	}

	public static function type_footer() {
		print <<<EOT
				</td>
			</tr>
EOT;
	}

	public static function radio ($name) {
		$config = self::config();
		${'open_'.$config[$name]} = 'checked';
		print <<<EOT
			<ul onmouseover="altStyle(this);">
				<li class="{$open_1}">
					<input class="radio" type="radio" name="{$GLOBALS['e6_name']}[{$name}]" value="1" {$open_1} /> <span>&#26159;</span>
				</li>
				<li class="{$open_0}">
					<input class="radio" type="radio" name="{$GLOBALS['e6_name']}[{$name}]" value="0" {$open_0} /> <span>&#21542;</span>
				</li>
			</ul>
EOT;
	}

	public static function textarea ($name, $style = NULL) {
		$config =  self::config();
		print <<<EOT
			<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="{$GLOBALS['e6_name']}[{$name}]" cols="50" class="tarea" {$style}>{$config[$name]}</textarea>
EOT;
	}

	public static function text ($name, $expand = NULL, $style = 'class="txt" style="width:50px;"') {
		$config =  self::config();
		print <<<EOT
		<input name="{$GLOBALS['e6_name']}[{$name}]" value="{$config[$name]}" type="text" {$style} /> <span>{$expand}</span>
EOT;
	}

	public static function select ($name, $type_arr, $expand = NULL, $style = 'style="width:120px;"') {
		$config =  self::config();
		if ($expand) {
			$type_arr[0] = $expand;
			$type_arr = array_flip($type_arr);
			asort($type_arr);
			$type_arr = array_flip($type_arr);
		}
		$html .= "<select name=\"{$GLOBALS['e6_name']}[{$name}]\" {$style}>";
		foreach ($type_arr as $k=>$v) {
			$html .= "<option value=\"{$k}\" " . ($k == $config[$name] ? 'selected' : '') . ">{$v}</option>";
		}
		$html .= "</select>";
		print $html;
	}

	public static function checkbox($name, $type_arr) {
		$config =  self::config();
		$html .= "<ul class=\"nofloat\" style=\"width:100%\" onmouseover=\"altStyle(this);\">";
		foreach ($type_arr as $k=>$v) {
			if ($config[$name] && in_array($k, $config[$name])) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			$html .= "<li style=\"float: left; width: 18%\" class=\"{$checked}\"><input class=\"checkbox\" type=\"checkbox\" name=\"{$GLOBALS['e6_name']}[{$name}][]\" value=\"{$k}\" class=\"checkbox\" {$checked}>&nbsp;{$v}</li>";
		}
		$html .= "</ul>";
		print $html;
	}

	public static function text_arr ($name, $type_arr) {
		$config =  self::config();
		$html .= "<ul class=\"nofloat\" style=\"width:100%\">";
		foreach ($type_arr as $k=>$v) {
			$html .= "<li style=\"float: left; width: 18%\"><input name=\"{$GLOBALS['e6_name']}[{$name}][{$k}]\" type=\"text\" value=\"{$config[$name][$k]}\" size=\"3\" /> <span>{$v}</span></li>";
		}
		$html .= "</ul>";
		print $html;
	}

	public static function export($str, $indent = '') {
		switch (gettype($str)) {
			case 'string' :
				return "'" . str_replace(array("\\", "'"), array("\\\\", "\'"), $str) . "'";
			case 'array' :
				$output = "array(\r\n";
				foreach ($str as $key => $value) {
					$output .= $indent . "\t" . self::export($key, $indent . "\t") . ' => ' . self::export($value, $indent . "\t");
					$output .= ",\r\n";
				}
				$output .= $indent . ')';
				return $output;
			case 'boolean' :
				return $str ? 'true' : 'false';
			case 'NULL' :
				return 'NULL';
			case 'integer' :
			case 'double' :
			case 'float' :
				return "'" . (string) $str . "'";
		}
		return 'NULL';
	}

	public static function writeover($filename, $data, $method = 'rb+', $iflock = 1, $check = 1, $chmod = 1) {
		$check && strpos($filename,'..') !== false && self::error('00003');
		touch($filename);
		$handle = fopen($filename,$method);
		$iflock && flock($handle,LOCK_EX);
		fwrite($handle,$data);
		$method == 'rb+' && ftruncate($handle,strlen($data));
		fclose($handle);
		$chmod && @chmod($filename,0777);
	}

	public static function save() {
		$e6_name = self::config();
		!$e6_name && $e6_name = array();
		$data = array_merge($e6_name, $GLOBALS['_POST'][$GLOBALS['e6_name']]);
		$data = self::export($data);
		$data = "\$GLOBALS['{$GLOBALS['e6_name']}']=\${$GLOBALS['e6_name']}=$data;\r\n";
		self::writeover($GLOBALS['e6_config'], "<?php\r\n".$data."?>");
		self::cpmsg();
	}

	public static function adminurl($pmod = NULL) {
		$pmod = '&pmod='.($pmod ?  $pmod :  $GLOBALS['_GET']['pmod']);
		return "admin.php?action=plugins&operation=config&identifier={$GLOBALS['e6_name']}{$pmod}";
	}

	public static function cpmsg($msg = NULL, $url = NULL) {
		$msg && $GLOBALS['msg'] = $msg;
		!$GLOBALS['msg'] && $GLOBALS['msg'] = '&#25805;&#20316;&#25104;&#21151;!';
		cpmsg($GLOBALS['msg'], "action=plugins&operation=config&identifier={$GLOBALS['e6_name']}&pmod={$GLOBALS['_GET']['pmod']}{$url}", 'succeed');
	}
}
$GLOBALS['e6_form'] = $e6_form = 1;
?>