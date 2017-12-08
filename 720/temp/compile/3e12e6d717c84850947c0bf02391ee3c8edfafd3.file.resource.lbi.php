<?php /* Smarty version Smarty-3.1.7, created on 2017-11-11 00:21:18
         compiled from "plugin\open_alert\template\resource.lbi" */ ?>
<?php /*%%SmartyHeaderCode:67075a05d1feba6a84-29394194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e12e6d717c84850947c0bf02391ee3c8edfafd3' => 
    array (
      0 => 'plugin\\open_alert\\template\\resource.lbi',
      1 => 1482227916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67075a05d1feba6a84-29394194',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5a05d1febaab7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a05d1febaab7')) {function content_5a05d1febaab7($_smarty_tpl) {?><script>
	$(function(){
		plugins_init_function.push(open_alert_init);
	})
	function open_alert_init(data,settings){
		if (data.open_alert.useAlert=='1') {
            settings["events[skin_events].onloadcomplete"] += "show_open_alert('" + data.open_alert.imgPath + "');";
        }
	}
</script><?php }} ?>