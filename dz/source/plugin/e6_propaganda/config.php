<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$GLOBALS['e6_name'] = $e6_name = 'e6_propaganda';

$GLOBALS['e6_url'] = $e6_url = 'source/plugin/' . $e6_name . '/';

$GLOBALS['e6_dir'] = $e6_dir = DISCUZ_ROOT . $e6_url . 'class/';

$GLOBALS['e6_config'] = $e6_config = DISCUZ_ROOT . "data/{$e6_name}.config.php";

!$GLOBALS[$e6_name] && @include $e6_config;

@include DISCUZ_ROOT . $e6_url . 'e6.php';

!$GLOBALS['e6_class'] && require $e6_dir . 'e6_class.php';

if (defined('IN_ADMINCP')) {
	!$GLOBALS['e6_form'] && require $e6_dir . 'e6_form.php';
}

!$GLOBALS['hack_'.$e6_name] && require $e6_dir . 'e6_hack.php';

!$GLOBALS['expand_'.$e6_name] && require $e6_dir . 'e6_expand.php';

$e6_c = E6::M()->scriptlang();

if (!function_exists('e6_c')) {
	function e6_c($str) {
		return E6::M()->lang($str);
	}
}
?>